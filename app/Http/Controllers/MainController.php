<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        $weatherResponse = Http::get('https://api.openweathermap.org/data/2.5/weather?q=Ulan-Ude&appid=0668d2df1055c5b0ca26e75facb5dbb9&units=metric');
        $weatherData = $weatherResponse->json();

        return view('main', ['files' => $files, 'folders' => $folders,'weatherData' => $weatherData]);
    }
}
