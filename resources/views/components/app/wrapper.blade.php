<!DOCTYPE html>
<html lang="{{ Lang::locale() }}" class="bg-primary-lightest">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ $pageTitle ? $pageTitle . ' - ' : ''}}{{ config('app.name')}}</title>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite(['resources/css/main.css'])
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P4S7PBBEQ4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-P4S7PBBEQ4');
    </script>
</head>
<body class="body">
    {{ $slot }}

    @vite(['resources/src/main.js'])
</body>
</html>
