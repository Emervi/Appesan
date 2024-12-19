{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 8 with Tailwind CSS</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-black">
    <h1 class="text-3xl font-bold text-center text-blue-500">Hello, Tailwind CSS!</h1>

    <div class="flex justify-between">
        <div class="w-24 h-24 bg-blue-500">s</div>
        <div class="w-24 h-24 bg-green-500">s</div>
        <div class="w-24 h-24 bg-yellow-500">s</div>
        <div class="w-24 h-24 bg-purple-500">sdasda</div>
        <div class="w-24 h-24 bg-yellow-500">s</div>
        <div class="w-24 h-24 bg-yellow-500">s</div>
    </div>

</body>
</html> --}}

@extends('layouts.app')

{{-- @section('title', 'Dashboard') --}}

@section('content')
    <h1 class="text-2xl font-bold">Welcome to the Dashboard</h1>
    <p>This is the dashboard content.</p>
@endsection
