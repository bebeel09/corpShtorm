@extends('layouts.auth')

@section('content')
    <div class="login-box">

        <div class="login-logo">
            <img src="http://www.shtorm-lorch.ru/assets/templates/lorch/img/logo.png" alt="logo">
        </div>

        <div class="login-box-body pb-20">
            <p class="login-box-msg text-uppercase">Восстановление пароля</p>
            @if (session('status'))
                <div class="alert alert-success">
                    Ссылка на восстановление пароля отправлена на почту
                </div>
            @endif
            <form action="{{ route('password.email') }}" method="post" class="form-element">
                @csrf
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <span class="ion ion-email form-control-feedback"></span>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-info btn-block text-uppercase">Сбросить пароль</button>
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

