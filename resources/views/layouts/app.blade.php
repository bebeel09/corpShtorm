<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Corp @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class = "container">
        <!-- Start Header -->
        <div id="header" class = "row">
            <div class = "col">
                <div id = "logo"></div>
            </div>
        </div>
        <!-- End Header -->

        <div class="row">
            <div class="col-9">
                @yield('content')
            </div>
            <div class="col-3">
                <div class="sidebar">
                    <a {{ (request()->is('/')) ? 'class= active ' : null }} href="{{ route('home') }}">Новости</a>
                    @foreach($categories as $category)
                        <a {{ (request()->is('category/'.$category->slug)) ? 'class= active ' : null }} href="{{ route('category', $category->slug) }}">{{ $category->title }}</a>
                    @endforeach
                </div>

            </div>
        </div>


    </div>
</body>
</html>
