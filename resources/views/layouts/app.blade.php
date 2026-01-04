<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ClashDeck') }}</title>

        <link href="https://fonts.bunny.net/css?family=bangers:400" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=verdana:400" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background-color: #f0f0f0;">
        <div class="min-h-screen">
            
            @include('layouts.navigation')

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>