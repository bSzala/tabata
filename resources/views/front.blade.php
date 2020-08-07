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
            <div id="app" class="container">
                <header class="header">
                    <div class="header__content">
                        <p>T2.0</p>
                    </div>
                </header>
                <main class="content-section">
                        <nav class="nav">
{{--                            empty--}}
                        </nav>
                        <div class="tabata">
                            <div class="tabata__timer">
                                <span>04:00</span>
                            </div>
                            <div class="tabata__additional">
                                <div class="tabata__cycles">
                                    <h3 class="tabata__heading">Cycles</h3>
                                    <span class="tabata__number" v-text="value1"></span>
                                </div>
                                <div class="tabata__tabatas">
                                    <h3 class="tabata__heading">Tabatas</h3>
                                    <span class="tabata__number" v-text="value2"></span>
                                </div>
                            </div>

                        </div>
                </main>
                <div class="sidebar">
                    <div class="settings">
                        <div class="setting">
                            <span class="setting__title">Prepare</span>

                        </div>
                        <div class="setting">
                            <span class="setting__title">Work</span>

                        </div>
                        <div class="setting">
                            <span class="setting__title">Rest</span>

                        </div>
                        <div class="setting">
                            <span class="setting__title">Cycles</span>
                            <vue-slider ref="slider" v-model="value1"  v-bind="options1" class="setting__slider"></vue-slider>
                        </div>

                        <div class="setting">
                            <span class="setting__title">Tabatas</span>
                            <vue-slider  ref="slider" v-model="value2"  v-bind="options2"  class="setting__slider"></vue-slider>
                        </div>

                        <div class="settings__buttons">
                            <button class="btn btn--block">Minus</button>
                            <button class="btn btn--block">Plus</button>
                            <button class="btn btn--wide">Start</button>
                        </div>




                    </div>
                </div>
            </div>
            <!-- Scripts -->
            <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
