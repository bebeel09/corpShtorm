<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} / Личный кабинет</title>

    @yield('additional_css')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="skin-corp">
    <div class="wrapper">
        @include('sections.header')
        <div class="wrapper_section-content">
            <div class="row">
                <div class="col-9">
                    @yield('content')
                </div>
                <div class="col-3">
                    <section class="sidebar">
                        @include('sections.sidebar')
                    </section>
                </div>
            </div>
        </div>
    </div>

    @yield('additional_js')
</body>
</html>

