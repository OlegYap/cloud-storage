<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MainController
{
    public function getMainPage()
    {
        if (!Auth::id()) {
            return view('login');
        }
        $userId = Auth::id();
        $files = File::where('user_id', $userId)->get();
        return view('main', ['files' => $files]);
    }
}

/*       $files = Storage::files('uploads');
       $fileUrls = [];
       foreach ($files as $file) {
           $fileUrls[] = Storage::url($file);
       }
       return view('main', ['fileUrls' => $files]);*/
