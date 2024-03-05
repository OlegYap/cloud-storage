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
            {{--<input type="hidden" name="parent_id" value="{{ $parentId ?? null }}">--}}
            <button type="submit" class="btn btn-primary">Создать папку</button>
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
                <a href="{{ route('download', ['user_id' => Auth::id(), 'file_id' => $file->id]) }}" class="btn btn-primary">Download</a>
                <a href="{{ route('viewFile', ['user_id' => Auth::id(), 'file_id' => $file->id]) }}" class="btn btn-primary">View</a>
            </li>
        @endforeach
    </ul>
    <ul>
        @foreach($folders as $folder)
            <li>
                <a href="{{route('folder')}}">{{$folder->name}}</a>
                <br>
                <a href="{{ route('viewFolder', ['user_id' => Auth::id(), 'folder_id' => $folder->id]) }}" class="btn btn-primary">View</a>
            </li>
        @endforeach
    </ul>
</main>
<footer>
</footer>
</body>
</html>
@endsection
