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
            </div>
        </main>
    </div>
    <!-- jQuery 3 -->
    <script src="{{ asset('vendor_components/jquery/dist/jquery.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('vendor_components/jquery-ui/jquery-ui.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- popper -->
    <script src="{{ asset('vendor_components/bootstrap/assets/js/vendor/popper.min.js') }}"></script>
    <!-- Bootstrap 4.0-->
    <script src="{{ asset('vendor_components/bootstrap/dist/js/bootstrap.js') }}"></script>


    {{--  Custom javascript  --}}
    @yield('additional_js')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>