@extends('layouts.app')

@section('content')

<div class="d-flex-column  d-md-flex">
    <div class="post col-12 col-md-4 align-self-start">
        <img style="width: 100%;" src="{{$userMetaData->avatar}}" alt="">
    </div>
    <div class="post col ml-0 ml-md-3 ">
        <div class="">
            <h3><b> {{ $userMetaData->first_name }} {{ $userMetaData->sur_name }} {{ $userMetaData->last_name }}</b></h3>
            <hr>
        </div>
        <div>
            <table>
                <tbody>

                    <tr>
                        <th>Рабочий телефон: </th>
                        <th>{{$userMetaData->work_phone}}</th>
                    </tr>
                    <tr>
                        <th>Личный телефон: </th>
                        <th>{{$userMetaData->mobile_phone}}</th>
                    </tr>
                    <tr>
                        <th>email: </th>
                        <th><a href="mailTo:{{$userMetaData->email}}">{{$userMetaData->email}}</a></th>
                    </tr>
                    <tr>
                        <th>Офис: </th>
                        <th>{{$userMetaData->office->office_appellation}}</th>
                    </tr>
                    <tr>
                        <th>Отдел: </th>
                        <th>{{$userMetaData->department->department_appellation}}</th>
                    </tr>
                    <tr>
                        <th>Должность: </th>
                        <th>{{$userMetaData->position}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="post achivment">

    @if(Auth::user()->id == $userMetaData->id)
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-key"></i> Сменить пароль
    </button>

    <!-- Модальное окно -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Сменить пароль</h4>
                </div>
                <div class="alert hide"></div>
                <div class="modal-body">
                    <form id="changePassword">
                        @csrf
                        <div class="form-group">
                            <label for="newCategoryName">Введите новый пароль</label>
                            <input type="password" name="newPassword" id="newPassword" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="newCategoryName">Введите пароль повторно</label>
                            <input type='password' class="form-control" id="newPassword_confirmation" name="newPassword_confirmation">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="editPassword(this);" name="newPassword_confirmation">Сменить</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection


@section('additional_js')
@if(Auth::user()->id == $userMetaData->id)
<script>
    function editPassword(el) {
        var data = $('#changePassword').serialize();
        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{route('changePassword', ['id'=>$userMetaData['id']])}}",
            data: data,
            success: function(jqXhr, json, errorThrown) {
                $('html,body').animate({
                    scrollTop: 0
                }, 300);

                $('.alert').removeClass('alert-danger').addClass('alert-success').html(jqXhr.message).slideDown(800);
            },
            error: function(jqXhr, json, errorThrown) {
                if (jqXhr.responseJSON.errors != undefined) {
                    var errors = jqXhr.responseJSON.errors;

                    var errorsHtml = '<ul>';
                    $.each(errors.newPassword, function(index, value) {
                        errorsHtml += '<li>' + value + '</li>';
                    });
                    errorsHtml += '</ul>';
                } else {
                    errorsHtml = jqXhr.responseJSON.message;
                }

                $('html,body').animate({
                    scrollTop: 0
                }, 300);

                $('.alert').removeClass('alert-success').addClass('alert-danger').html(errorsHtml).slideDown(800);
            }
        });
    }
</script>
@endif
@endsection