<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IQAC') }}</title>
    <link rel="icon" href="{{ asset('assets/images/iqac.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>
    </div>
<footer class=" bottom-0 w-100 bg-white mt-5 py-2 px-3">
    <div class="text-center">
        <span class="text-muted">
            © {{ date('Y') }} All rights reserved <br>
            Institutional Quality Assurance Cell (IQAC), MBSTU
        </span>
    </div>
</footer>
</body>

</html>
