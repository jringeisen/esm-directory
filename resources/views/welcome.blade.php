<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/6229d48325.js" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            .card {
                cursor: pointer;
                font-size: 12px;
            }

            .card:hover {
                border-color: #6c757d !important;
                border-width: 1.2px;
            }
        </style>
    </head>
    <body>
        <div id="app" class="container flex-center position-ref full-height">
            <b-navbar toggleable="lg" type="light" variant="light">
                <b-navbar-brand href="#">ESM Directory</b-navbar-brand>

                <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

                <b-collapse id="nav-collapse" is-nav>

                <b-navbar-nav class="ml-auto">
                    @auth
                        <b-nav-item href="{{ url('/home') }}">Home</b-nav-item>
                    @else
                        <b-nav-item href="{{ url('login') }}">Login</b-nav-item>
                        <b-nav-item href="{{ url('register') }}">Register</b-nav-item>
                    @endauth
                </b-navbar-nav>
                </b-collapse>
            </b-navbar>
            <directory-page :listings="{{ $listings }}"></directory-page>
        </div>
    </body>
</html>
