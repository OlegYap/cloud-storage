<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Requests\FolderRequest;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class FolderController extends Controller
{
    public function createFolder(FolderRequest $request)
    {
        $errors = $request->validated();
        $folder = new Folder([
            'name' => $errors['name'],
            'user_id' => Auth::id(),
            'parent_id' => 0
        ]);
        $folder->save();
        return redirect()->route('main');
    }

    public function viewFolder(int $user_id, int $folder_id)
    {
        $folder = Folder::where('id', $folder_id)->where('user_id', $user_id)->firstOrFail();
        $files = File::where('folder_id', $folder_id)->get();
        if ($folder->user_id !== Auth::id()) {
            return redirect()->route('login');
        }
        return view('folder', compact('folder', 'files'));
    }

    public function uploadFile(FileRequest $request)
    {
        $errors = $request->validated();
        $file = $request->file('file');
        $folderId = $request->input('folder_id');
        $destinationPath = public_path('uploads/');
        $fileName = $file->getClientOriginalName();
        if ($file->move($destinationPath, $fileName)) {
            $fileData = new File();
            $fileData->name = $fileName;
            $fileData->path = $destinationPath;
            $fileData->size = $file->getSize();
            $fileData->type = $file->getClientMimeType();
            $fileData->user_id = Auth::id();
            $fileData->folder_id = $folderId;
            $fileData->save();
            return redirect()->route('viewFolder', ['user_id' => Auth::id(), 'folder_id' => $folderId]);
        } else {
            return view('errorFile');
        }
    }
}
