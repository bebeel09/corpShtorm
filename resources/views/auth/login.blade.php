@extends('layouts.auth')

@section('content')

    <div class="login-box">
        <div class="login-logo">
            <img src="http://www.shtorm-lorch.ru/assets/templates/lorch/img/logo.png" alt="logo">
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Доступ только для авторизованных</p>
            @if(count( $errors ) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('login') }}" method="post" class="form-element">
                @csrf
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                    <span class="ion ion-email form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Пароль" name="password">
                    <span class="ion ion-locked form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="checkbox">
                            <input type="checkbox" id="basic_checkbox_1" name="remember">
                            <label for="basic_checkbox_1">Запомнить меня</label>
                        </div>
                    </div>
                    <!-- /.col -->
                    @if (Route::has('password.request'))
                        <div class="col-6">
                            <div class="fog-pwd">
                                <a href="{{ route('password.request') }}"><i class="ion ion-locked"></i> Забыли пароль?</a><br>
                            </div>
                        </div>
                        <!-- /.col -->
                    @endif
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-info btn-block margin-top-10">Войти</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <!-- jQuery 3 -->
    <script src="{{ asset('vendor_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- popper -->
    <script src="{{ asset('vendor_components/popper/dist/popper.min.js') }}"></script>
    <!-- Bootstrap 4.0-->
    <script src="{{ asset('vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
@endsection
