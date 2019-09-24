<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="http://www.shtorm-lorch.ru/favicon.ico">
    <title>{{ config('app.name', 'Laravel') }} / Личный кабинет</title>
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('vendor_components/bootstrap/dist/css/bootstrap-extend.css') }}">

@yield('additional_css')

<!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/master_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.css') }}">
    <!-- Morris.js charts CSS -->
    <link rel="stylesheet" href="{{ asset ('vendor_components/morris.js/morris.css') }}">
    <!-- Vector CSS -->
    <link rel="stylesheet" href="{{ asset('vendor_components/jvectormap/lib2/jquery-jvectormap-2.0.2.css') }}">
    <!-- date picker -->
    <link rel="stylesheet" href="{{ asset('vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('vendor_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition sidebar-mini skin-green">
<div class="wrapper">
@include('sections.admin.header')
@include('sections.admin.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
        <div class="support">
            <div class="np__footer">
                <div class="np__footer_wrapper row no-gutters align-items-center">
                    <div class="np__sm col-auto align-items-center">
                        <a target="_blank" href="https://vk.com/shtorm_its" class="np_vk"><i class="fa fa-vk"></i></a>
                        <a target="_blank" href="https://www.instagram.com/shtorm_its/" class="np_fb"><i class="fa fa-instagram"></i></a>
                        <a target="_blank" href="https://www.youtube.com/user/shtormTv" class="np_tw"><i class="fa fa-youtube-play"></i></a>
                    </div>
                    <div class="col-auto align-items-center">
                        <a target="_blank" href="http://shtorm-lorch.ru/" class="np__border_link site">Перейти на сайт</a>
                        <a href="mailto:911@shtorm-lorch.ru" class="np__border_link stp">Техническая поддержка</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./wrapper -->

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
<!-- Morris.js charts -->
<script src="{{ asset('vendor_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('vendor_components/morris.js/morris.min.js') }}"></script>
<!-- ChartJS -->
<script src="https://unpkg.com/chart.js@2.7.3/dist/Chart.js"></script>
<!-- Sparkline -->
<script src="{{ asset('vendor_components/jquery-sparkline/dist/jquery.sparkline.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('vendor_components/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('vendor_components/fastclick/lib/fastclick.js') }}"></script>
<!-- peity -->
<script src="{{ asset('vendor_components/jquery.peity/jquery.peity.js') }}"></script>
<!-- Vector map JavaScript -->
<script src="{{ asset('vendor_components/jvectormap/lib2/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('vendor_components/jvectormap/lib2/jquery-jvectormap-uk-mill-en.js') }}"></script>
<!-- MinimalLite Admin App -->
<script src="{{ asset('js/template.js') }}"></script>
<!-- MinimalLite Admin dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('js/pages/dashboard.js') }}"></script>
<!-- MinimalLite Admin for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>

@yield('additional_js')
</body>
</html>