<!DOCTYPE html>
<html lang="{{ Lang::locale() }}" class="bg-blue-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ? $pageTitle . ' - ' : ''}}{{ config('app.name')}}</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-77808450-1"></script>
    <link rel="preload" as="font" href="{{ url('/webfonts/fa-regular-400.woff2') }}" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="{{ url('/webfonts/fa-brands-400.woff2') }}" type="font/woff2" crossorigin="anonymous">
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-77808450-1');
    </script>
    @livewireStyles
</head>
<body class="body">
    {{ $slot }}

    <livewire:notification-container />

    @livewireScripts
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
