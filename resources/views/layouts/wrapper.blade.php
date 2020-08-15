<!DOCTYPE html>
<html lang="{{ Lang::locale() }}" class="bg-blue-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name')}}</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-77808450-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-77808450-1');
    </script>
</head>
<body class="body @yield('body-class')">
    @yield('body')

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    @routes
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    {!! NoCaptcha::renderJs(Lang::locale()) !!}
</body>
</html>
