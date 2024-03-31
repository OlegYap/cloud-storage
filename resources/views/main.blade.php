@extends('layouts')
@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Storage</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Welcome to Cloud Storage</h1>
    <nav>
    </nav>
</header>
<main>
    <div class="container">
        <form method="POST" action="{{route("main")}}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="formFile" class="form-label">Загрузить файл</label>
                <input class="form-control" name="file" type="file" id="formFile">
            </div>
            <input type="submit" class="btn btn-primary">
        </form>
    </div>
    <div class="container">
        <form method="POST" action="{{ route('folder') }}">
            @csrf
            <div class="mb-3">
                <label for="folder" class="form-label">Создать папку</label>
                <input class="form-control" name="name" type="text" id="folder" required>
            </div>
            <button type="submit" class="btn btn-primary">Создать папку</button>
        </form>
    </div>
{{--    <div>
        <h2>Погода</h2>
        <p>Температура: {{ $weatherData['main']['temp'] }} °C</p>
    </div>--}}
    <div id="openweathermap-widget-15"></div>
    <script>window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];  window.myWidgetParam.push({id: 15,cityid: '2014407',appid: '0668d2df1055c5b0ca26e75facb5dbb9',units: 'metric',containerid: 'openweathermap-widget-15',  });  (function() {var script = document.createElement('script');script.async = true;script.charset = "utf-8";script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(script, s);  })();</script>
    <h2>
        Your Files
    </h2>
    <ul>
        @foreach($files as $file)
            <li>
                <a href="{{ asset('storage/' . $file->name) }}">{{ $file->name }}</a>
                <br>
                <a href="{{ route('download', ['file_id' => $file->id]) }}" class="btn btn-primary">Download</a>
                <a href="{{ route('viewFile', ['file_id' => $file->id]) }}" class="btn btn-primary">View</a>
            </li>
        @endforeach
    </ul>
    <ul>
        @foreach($folders as $folder)
            <li>
                <a href="{{route('folder')}}">{{$folder->name}}</a>
                <br>
                <a href="{{ route('viewFolder', [ 'folder_id' => $folder->id]) }}" class="btn btn-primary">View</a>
            </li>
        @endforeach
    </ul>
</main>
<footer>
</footer>
</body>
</html>
@endsection
