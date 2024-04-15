@extends('layouts')
@section('content')
    <div class="container">
        <h2>Share File</h2>
        <p>Here is your shared file:</p>
        <a href="{{ $temporaryUrl }}" target="_blank">{{ $temporaryUrl }}</a>
    </div>
@endsection
