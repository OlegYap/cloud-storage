<?php

namespace App\Http\Controllers;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController
{
    public function uploadFiles(Request $request)
    {
        $file = $request->file('file');
        $destinationPath = "storage";
        $filePath = $destinationPath . $file->getClientOriginalName();
        if ($file->move($destinationPath, $file->getClientOriginalName())) {
            return redirect(url("main"));
        } else {
            return "Failed to upload";
        }
    }
}

/*            $fileData = new File();
            $fileData->name = $filePath;
            $fileData->size = $file->getSize();
            $fileData->type = $file->getMimeType();
            $fileData->user_id = Auth::id();
            $fileData->save();*/

/*echo 'File_Name' . $file->getClientOriginalName();
echo 'File_Extension' . $file->getClientOriginalExtension();
echo 'File_Path' . $file->getRealPath();
echo 'File_Size' . $file->getSize();
echo 'File_Mime_Type' . $file->getMimeType();*/
