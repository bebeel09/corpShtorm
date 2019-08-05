<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
{{--    <link rel="icon" href="http://www.shtorm-lorch.ru/favicon.ico">--}}
    <title>{{ config('app.name', 'Laravel') }} / Личный кабинет</title>

@yield('additional_css')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.css') }}">--}}
</head>
<body class="skin-corp">
<div class="wrapper container">
        @yield('content')
</div>

@yield('additional_js')
</body>
</html>

