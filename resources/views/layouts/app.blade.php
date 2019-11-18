<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} / Личный кабинет</title>

    @yield('additional_css')

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('vendor_components/bootstrap/dist/css/bootstrap-extend.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

   
</head>

<body>
    <div id="app">
        @include('sections.header')
        <main class="container">
            <div class="row content_wrapper">
                @include('sections.sidebar_left')
                <div class="content">
                    @yield('content')
                </div>
                @include('sections.sidebar_right')
            </div>
        </main>
    </div>


    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    {{--  Custom javascript  --}}
    @yield('additional_js')
</body>

</html>