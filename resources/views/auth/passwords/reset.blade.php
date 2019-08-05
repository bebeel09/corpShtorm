@extends('layouts.auth')

@section('content')
    <div class="login-box">

        <div class="login-logo">
            <img src="http://www.shtorm-lorch.ru/assets/templates/lorch/img/logo.png" alt="logo">
        </div>

        <div class="login-box-body pb-20">
            <p class="login-box-msg text-uppercase">Восстановление пароля</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group has-feedback">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autofocus placeholder="Новый пароль">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Повторите пароль">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-info btn-block text-uppercase">Изменить пароль</button>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12 pt-20">
                        <a href="/login">← Вернуться на страницу входа</a>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->

    </div>
@endsection