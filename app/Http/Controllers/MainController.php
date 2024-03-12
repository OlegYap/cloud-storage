<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class MainController
{
    public function getMainPage()
    {
        if (!Auth::id()) {
            return view('login');
        }
        $userId = Auth::id();
        $files = File::where('user_id', $userId)->where('folder_id',0)->get();
        $folders = Folder::where('user_id', $userId)->where('parent_id',0)->get();
        return view('main', ['files' => $files, 'folders' => $folders]);
    }
}
