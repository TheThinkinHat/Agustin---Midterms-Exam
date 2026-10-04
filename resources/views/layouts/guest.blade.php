@props(['title' => 'Student Information System'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body class="auth-layout">
        <div class="container form-container auth-container">
            <header>
                <h1>{{ $title }}</h1>
            </header>
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
