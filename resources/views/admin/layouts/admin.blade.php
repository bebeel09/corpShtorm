<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/ajax.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <div class="card">
        <div class="card-header">
            <div class="logo"></div>
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('admin/categories')) ? 'active' : null }}"
                       href="{{ route('admin.categories') }}">Категории</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('admin/posts')) ? 'active' : null }}"
                       href="{{ route('admin.posts.index') }}">Записи</a>
                </li>
            </ul>
        </div>
        <div class="card-body container">
            @yield('content')
        </div>



        <div class="card-footer">
            <div class="card-title"></div>
        </div>
    </div>
</body>
</html>