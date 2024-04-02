<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MainController
{
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getMainPage()
    {
        if (!Auth::id()) {
            return view('login');
        }
        $userId = Auth::id();
        $files = File::where('user_id', $userId)->where('folder_id',0)->get();
        $folders = Folder::where('user_id', $userId)->where('parent_id',0)->get();

        $weatherData = $this->weatherService->getWeather($userId);

        return view('main', ['files' => $files, 'folders' => $folders,'weatherData' => $weatherData]);
    }
}
