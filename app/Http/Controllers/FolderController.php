<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Requests\FolderRequest;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

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

    public function viewFolder(int $folder_id)
    {
        $user_id = Auth::id();
        $folder = Folder::where('id', $folder_id)->where('user_id', $user_id)->firstOrFail();
        $files = File::where('folder_id', $folder_id)->get();
        $subfolders = Folder::where('parent_id', $folder_id)->get();

        if ($folder->user_id !== Auth::id()) {
            return redirect()->route('login');
        }

        return view('folder', compact('folder', 'files', 'subfolders'));
    }

    public function uploadFile(FileRequest $request)
    {
        try {
            $errors = $request->validated();
            $file = $request->file('file');
            $folderId = $request->input('folder_id');
            $destinationPath = public_path('uploads');
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
        } catch (\Throwable $e) {
            if (file_exists($destinationPath . $fileName)) {
                unlink($destinationPath . $fileName);
            }
            return view('errorFile');
        }
    }

    public function createSubfolder(FolderRequest $request, $parent_id)
    {
        $errors = $request->validated();
        $subFolder = new Folder([
            'name' => $errors['name'],
            'user_id' => Auth::id(),
            'parent_id' => $parent_id
        ]);
        $subFolder->save();
        return redirect()->route('viewFolder', ['folder_id' => $parent_id]);
    }
}
