<!DOCTYPE html>
<html lang="{{ Lang::locale() }}" class="bg-primary-lightest">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ? $pageTitle . ' - ' : ''}}{{ config('app.name')}}</title>
    <link rel="stylesheet" href="{{ mix('/css/main.css') }}">
    <link rel="preload" as="font" href="{{ url('/webfonts/fa-regular-400.woff2') }}" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="{{ url('/webfonts/fa-brands-400.woff2') }}" type="font/woff2" crossorigin="anonymous">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P4S7PBBEQ4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-P4S7PBBEQ4');
    </script>
    @livewireStyles
</head>
<body class="body">
    {{ $slot }}

    <livewire:notification-container />

    @livewireScripts
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/main.js') }}"></script>
</body>
</html>
