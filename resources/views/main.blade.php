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
{{--    <section class="uploads">
        <h2>Upload Files</h2>
        <input type="file">
        <button>Upload</button>
    </section>--}}
    <section class="files">
        <h2>Your Files</h2>
        <ul>

        </ul>
    </section>
</main>
<footer>

</footer>
</body>
</html>
@endsection
