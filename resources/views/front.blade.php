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
            <div class="container">
                <main class="content-section">
                    <header class="header">
                        <div class="header__content">
                            <p>T2.0</p>
                        </div>
                    </header>
                    <div class="content-section__main">
                        <div class="tabata">
                            <div class="tabata__timer">
                                <span>04:00</span>
                            </div>
                            <div class="tabata__cycles">
                                <h3 class="tabata__heading">Cycles</h3>
                                <span>08</span>
                            </div>
                            <div class="tabata__tabatas">
                                <h3 class="tabata__heading">Tabatas</h3>
                                <span>01</span>
                            </div>

                        </div>
                    </div>
                    <div class="content-section__sidebar">

                    </div>
                </main>
            </div>
            <!-- Scripts -->
            <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
