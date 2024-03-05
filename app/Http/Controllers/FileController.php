<?php

namespace App\Http\Controllers;
use App\Http\Requests\FileRequest;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Exception;

class FileController
{
    public function uploadFile(FileRequest $request)
    {
        try {
            $errors = $request->validated();
            $file = $request->file('file');
            $destinationPath = "uploads/";
            $fileName = $file->getClientOriginalName();
            if ($file->move($destinationPath, $fileName)) {
                $fileData = new File();
                $fileData->name = $fileName;
                $fileData->path = $file->getRealPath();
                $fileData->size = $file->getSize();
                $fileData->type = $file->getClientMimeType();
                $fileData->user_id = Auth::id();
                $fileData->folder_id = 0;
                $fileData->save();
                return redirect(url("main"));
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

    public function downloadFile(int $user_id, int $file_id)
    {
        $file = File::where('id', $file_id)->where('user_id', $user_id)->firstOrFail();
        if ($file->user_id !== Auth::id()) {
            return redirect()->route('login');
        }
        $pathToFile = public_path('uploads/' . $file->name);

        return response()->download($pathToFile);
    }

    public function viewFile(int $user_id, int $file_id)
    {
        $file = File::where('id', $file_id)->where('user_id', $user_id)->firstOrFail();
        if ($file->user_id !== Auth::id()) {
            return redirect()->route('login');
        }
        $pathToFile = public_path('uploads/' . $file->name);
        return response()->file($pathToFile);
    }
}
