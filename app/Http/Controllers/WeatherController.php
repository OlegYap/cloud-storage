<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather()
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/forecast?q=Ulan-Ude&appid=0668d2df1055c5b0ca26e75facb5dbb9&units=metric');
        $response->body();
        echo $response;
    }
}
