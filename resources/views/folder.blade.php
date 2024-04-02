@extends('layouts')
@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
<main>
    <header>
        <nav>
            <h1>{{ $folder->name }}</h1>
        </nav>
    </header>
    <div class="container">
        <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="formFile" class="form-label">Загрузить файл</label>
                <input class="form-control" name="file" type="file" id="formFile">
            </div>
            <input type="hidden" name="folder_id" value="{{ $folder->id }}">
            <input type="submit" class="btn btn-primary">
        </form>
    </div>
    <div class="container">
        <form method="POST" action="{{ route('subFolder', ['parent_id' => $folder->id]) }}">
            @csrf
            <div class="mb-3">
                <label for="folder" class="form-label">Создать папку</label>
                <input class="form-control" name="name" type="text" id="folder" required>
            </div>
            <button type="submit" class="btn btn-primary">Создать папку</button>
        </form>
    </div>
    <div class="button">
        <a href="/main">Вернуться на главную</a>
    </div>
    <h2>Files</h2>
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
        @foreach($subfolders as $subfolder)
            <li>
                <a href="{{ route('viewFolder', ['folder_id' => $subfolder->id]) }}">{{ $subfolder->name }}</a>
            </li>
        @endforeach
    </ul>
</main>
</body>
</html>
@endsection
