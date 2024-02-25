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
    <h2>
        Your Files
    </h2>
    <ul>
        @foreach($files as $file)
            <li>
                <a href="{{ asset('storage/' . $file->name) }}">{{ $file->name }}</a>
                <br>
                <a href="{{ route('download', ['file' => $file->name]) }}" class="btn btn-primary">Download</a>
            </li>
        @endforeach
    </ul>
</main>
<footer>
</footer>
</body>
</html>
@endsection

{{--        @foreach ($fileUrls as $fileUrl)
            <a href="{{ $fileUrl }}">{{ $fileUrl }}</a><br>
        @endforeach--}}
