<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tabata</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <app :tabata-cycle="6" :tabata-counter="2" :prepare="5" :work="25" :rest="2"></app>
        </div>
            <!-- Scripts -->
            <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
