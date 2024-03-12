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
        $request->validated();
        $folder = new Folder([
            'name' => $request['name'],
            'user_id' => Auth::id(),
            'parent_id' => 0
        ]);
        $folder->save();
        return redirect()->route('main');
    }

    public function viewFolder(int $folderId)
    {
        $userId = Auth::id();
        $folder = Folder::where('id', $folderId)->where('user_id', $userId)->firstOrFail();
        if ($folder->user_id !== Auth::id()) {
            return redirect()->route('login');
        }
        $files = File::where('folder_id', $folderId)->get();
        $subfolders = Folder::where('parent_id', $folderId)->get();

        return view('folder', compact('folder', 'files', 'subfolders'));
    }

    public function uploadFile(FileRequest $request)
    {
        try {
            $request->validated();
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

    public function createSubfolder(FolderRequest $request, int $parentId) //Попробовать передать parent_id в body
    {
        $request->validated();
        $subFolder = new Folder([
            'name' => $request['name'],
            'user_id' => Auth::id(),
            'parent_id' => $parentId
        ]);
        $subFolder->save();
        return redirect()->route('viewFolder', ['folder_id' => $parentId]);
    }
}
