<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeather($userId)
    {
        $userWeather = User::where('id',$userId)->first();
        $city = $userWeather->city;
        $weatherResponse = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$city}&appid=0668d2df1055c5b0ca26e75facb5dbb9&units=metric");
        return $weatherResponse->json();
    }
}
