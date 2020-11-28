<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

{{--            If guest, Show all the login links--}}
                @guest
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ route('superadmin.login') }}">Superadmin Login</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ route('login') }}">User Login</a>
                        </li>
                    </ul>
{{--            If logged in, Show the corresponding navigation links for each user type--}}
                @else
                    @auth('superadmin')
                        <x-superadmin-nav></x-superadmin-nav>
                    @endauth
                    @auth('web')
                        <x-user-nav></x-user-nav>
                    @endauth
                @endguest
            </div>
        </nav>

        <main class="py-4">
            <x-alert></x-alert>
            @yield('content')
        </main>
    </div>
</body>
</html>
