<?php

namespace App\Http\Controllers;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController
{
    public function uploadFiles(Request $request)
    {
        $file = $request->file('file');

        $destinationPath = "uploads/";
        $filePath = $destinationPath . $file->getClientOriginalName();
        if ($file->move($destinationPath, $file->getClientOriginalName())) {
            $fileData = new File();
            $fileData->name = $filePath;
            $fileData->path = $file->getRealPath();
            $fileData->size = $file->getSize();
            $fileData->type = $file->getClientMimeType();
            $fileData->user_id = Auth::id();
            $fileData->folder_id = 1;
            $fileData->save();
            return redirect(url("main"));
        } else {
            return "Failed to upload";
        }
    }
    public function downloadFiles($fileName)
    {
        $file = File::where('name', $fileName)->firstOrFail();
        $pathToFile = public_path('uploads/' . $file->name);

        return response()->download($pathToFile);
    }

    public function viewFiles($fileName)
    {
        $file = File::where('name', $fileName)->firstOrFail();
        $pathToFile = public_path('uploads/' . $file->name);
        return response()->file($pathToFile);
    }
}
