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

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('vendor_components/bootstrap/dist/css/bootstrap-extend.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rightMenu.css') }}">

   
</head>

<body class="skin-corp">
    <div id="app">
    @include('sections.header')
    <main class="container">
        <div class="row content_wrapper">
            <div class="sidebar_container">
                <div class="sidebar">
                    <ul class="sidebar-menu">
                        @foreach ($typeCategory as $categoryItem)
                            <li class="{{ request()->is('/')  ? 'active' : '' }}"><a href="{{route('main')}}"><i class="fa fa-newspaper-o"></i>{{$categoryItem['title']}}</a></li>
                        @endforeach
                        <li class="{{ (Request::routeIs('employee')) ? 'active' : '' }}"><a href="{{ route('employee') }}"><i class="fa fa-phone"></i>Телефонный справочник</a></li>
                        <li class="{{ (Request::routeIs('events')) ? 'active' : '' }}"><a href="{{ route('events') }}"><i class="fa fa-calendar"></i>Календарь событий</a></li>
                        @foreach ($mainCatalogs as $catalog)
                            <li class="{{ request()->is('catalog/'.$catalog['slug'].'*')  ? 'active' : '' }} "><a href="{{route('catalog.show', $catalog['slug'])}}"><i class="fa fa-folder-open"></i>{{$catalog['title']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="content">
                @yield('content')
            </div>
            <div class="info-block_container">
                <div class="info-block">
                    <div class="box">
                        <div class="box_title">
                            События недели
                        </div>
                        <div class="box_content">
                            @if ($events->count())
                                <ul class="list-unstyled">
                                    @foreach ($events as $event)
                                        @if($event[0]->start < date('Y-m-d'))
                                            @continue
                                        @endif
                                        <hr>
                                        <li>
                                            <time class="text-muted">
                                                <em class="text-danger">
                                                    @if ($event[0]->start == date("Y-m-d"))
                                                        Сегодня
                                                    @endif
                                                </em>
                                                <small class="">{{$event[0]->start}}</small><br>
                                            </time>
                                            @foreach ($event as $item)
                                                <a class="text-break"><i class="{{$item->className}} pr-2">&nbsp;&nbsp;</i>&nbsp;{{$item->title}}</a><br>

                                            @endforeach
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">Нет событий</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    </div>





{{--    <section class="container d-flex mt-4 p-0">--}}
{{--        <div class="content col ">--}}
{{--            @yield('content')--}}
{{--        </div>--}}
{{--        @include('sections.sidebar')--}}
{{--    </section>--}}

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
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    @yield('additional_js')

</body>

</html>