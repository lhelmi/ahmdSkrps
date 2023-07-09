<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/select2.full.js', 'resources/css/select2.css'])

    @yield('css')
</head>
<body>
    <div id="app">
        @include('front.layouts.navbar')

        <main role="main">
            @yield('content')
        </main>
        @include('front.layouts.footer')
    </div>
    @yield('js')
</body>
</html>
