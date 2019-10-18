@extends('layouts.admin.app')
@section('additional_css')

<link rel="stylesheet" href="{{ asset ('vendor_components/select2/dist/css/select2.min.css') }}">
<style>
    #uploadForm,
    #uploadFormAnounce {
        border: 3px dashed #d3d2d2;
        border-radius: 10px;
    }

    .dropzone.dz-clickable .dz-message {
        line-height: 60px !important;
        font-size: 14px !important;
    }

    label>span {
        color: red;
    }
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Изменить данные пользователя
    </h1>
</section>
<section class="content">
    <div class="alert hide"></div>
    <div class="row">

        <div class="col-9">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Пользователь</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form name="updateUser">
                        <div class="form-group">
                            <div class="d-flex">
                                <div class="col pl-0">
                                    <label for="exampleInputFirstName1">Фамилия <span>*</span></label>
                                    <input type="text" autocomplete="off" name="first_name" class="form-control" aria-describedby="nameHelp" placeholder="Петров" value="{{$user['first_name']}}">
                                </div>
                                <div class="col">
                                    <label for="exampleInputSurName1">Имя <span>*</span></label>
                                    <input type="text" autocomplete="off" name="sur_name" class="form-control" aria-describedby="nameHelp" placeholder="Пётр" value="{{$user['sur_name']}}">
                                </div>
                                <div class="col pr-0">
                                    <label for="exampleInputLastName1">Отчество <span>*</span></label>
                                    <input type="text" autocomplete="off" name="last_name" class="form-control" aria-describedby="nameHelp" placeholder="Петрович" value="{{$user['last_name']}}">
                                </div>
                            </div>
                            <small id="nameHelp" class="form-text text-muted">Введите Фамилию, Имя, Отчество</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputAvatar1">Аватарка</label>
                            <input type="file" accept="image/*,image/jpeg" name="avatar" class="form-control" aria-describedby="avatarHelp">
                            <small id="avatarHelp" class="form-text text-muted">Выбирите картинку для аватарки пользователя</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputDepartment1">Отдел <span>*</span></label>
                            <select type="text" autocomplete="off" id="department" class="form-control" aria-describedby="DepartmentHelp">
                                @foreach ($departments as $department )
                                <option @if($department->id == $user->department->id) selected @endif
                                    value="{{$department->id}}">{{$department->department_appellation}}</option>
                                @endforeach
                            </select>
                            <small id="DepartmentHelp" class="form-text text-muted">Введите отдел к которому относится сотрудник</small>

                            <!-- collapse department -->
                            <p>
                                <a class="btn btn-primary" data-toggle="collapse" href="#collapseDepartment" role="button" aria-expanded="false" aria-controls="collapseDepartment">
                                    Добавить новый отдел
                                </a>
                            </p>
                            <div class="collapse" id="collapseDepartment">

                                <div class="form-row align-items-center">
                                    <input type="text" class="col form-control bg-dark text-white" name="department_appellation" placeholder="Название города в котором располагается новый филиал">
                                    <div class="col-auto">
                                        <button onclick="addDepartment(this); return false;" class="col btn btn-success">Добавить</button>
                                    </div>
                                </div>

                            </div>
                            <!-- end collapse department -->

                        </div>

                        <div class="form-group">
                            <label for="exampleInputPos1">Должность <span>*</span></label>
                            <input type="text" autocomplete="off" name="position" class="form-control" aria-describedby="posHelp" placeholder="Старший специалист" value="{{$user['position']}}">
                            <small id="posHelp" class="form-text text-muted">Введите должность сотрудника</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputworkPhone1">Рабочий телефон </label>
                            <input id="workPhone" type="text" autocomplete="off" name="work_phone" class="form-control" aria-describedby="workPhoneHelp" placeholder="911" value="{{$user['work_phone']}}">
                            <small id="workPhoneHelp" class="form-text text-muted">Рабочий телефон сотрудника</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPhone1">Личный телефон <span>*</span></label>
                            <input id='personalPhone' type="text" autocomplete="off" name="mobile_phone" class="form-control" aria-describedby="phoneHelp" placeholder="79929999999" value="{{$user['mobile_phone']}}">
                            <small id="phoneHelp" class="form-text text-muted">Личный телефон сотрудника</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputReg1">филиал <span>*</span> </label>
                            <select type="text" autocomplete="off" id="office" class="form-control" aria-describedby="regHelp">
                                @foreach ($offices as $office)
                                <option @if($office->id == $user->office->id) selected @endif
                                    value="{{$office->id}}">{{$office->office_appellation}}</option>
                                @endforeach
                            </select>
                            <small id="regHelp" class="form-text text-muted">филиал компании в регионе</small>

                            <!-- collapse office -->
                            <p>
                                <a class="btn btn-primary" data-toggle="collapse" href="#collapseOffice" role="button" aria-expanded="false" aria-controls="collapseOffice">
                                    Добавить новый филиал
                                </a>
                            </p>
                            <div class="collapse" id="collapseOffice">

                                <div class="form-row align-items-center">
                                    <input type="text" class="col form-control bg-dark text-white" name="office_appellation" placeholder="Название города в котором располагается новый филиал">
                                    <div class="col-auto">
                                        <button onclick="addOffice(this);  return false;" class="col btn btn-success">Добавить</button>
                                    </div>
                                </div>

                            </div>
                            <!--end collapse office -->
                        </div>
                </div>
            </div>
        </div>
        </form>
        <div class="col-3">

            <div class="box">
                <div class="box-body">
                    <button class="btn btn-success col-12" onclick="editUser(this)">Обновить</button>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Форма изменения пароля</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <a data-widget="hider" style="text-decoration: underline;"> Изменить пароль</a>
                        <form id="changePassword" method="POST" style="margin-top: 15px; display: none;">
                            @csrf
                            <div class="form-group">
                                <label for="newCategoryName">Введите новый пароль</label>
                                <input type="password" name="newPassword" id="newPassword" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="newCategoryName">Введите пароль повторно</label>
                                <input type='password' class="form-control" id="newPassword_confirmation" name="newPassword_confirmation">
                            </div>
                            <button class="btn btn-block btn-success" onclick="editPassword(this); return false;"> Изменить пароль</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('additional_js')
<script src="{{ asset('vendor_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('vendor/maskedinput/src/jquery.maskedinput.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('[data-widget=hider]').on('click', function(event) {
            if (event) event.preventDefault();
            var isOpen = $('#changePassword').is('.collapsed-box');
            if (isOpen) {
                $('#changePassword').slideUp(300, function() {
                    $(this).removeClass('collapsed-box');
                });
            } else {
                $('#changePassword').slideDown(300, function() {
                    $(this).addClass('collapsed-box');
                });
            }
        })


        jQuery(function($) {
            $("#personalPhone").mask("+7(999) 99-99-999");
            $("#workPhone").mask("999");
        });
    });
</script>



<script>
    function editUser(msg) {

        var avatar = $('form[name="updateUser"]').serializeArray();

        var formData = new FormData();
        formData.append('first_name', $('input[name="first_name"]')[0].value);
        formData.append('sur_name', $('input[name="sur_name"]')[0].value);
        formData.append('last_name', $('input[name="last_name"]')[0].value);
        formData.append('office_id', $('#office').val());
        formData.append('work_phone', $('input[name="work_phone"]')[0].value);
        formData.append('mobile_phone', $('input[name="mobile_phone"]')[0].value);
        formData.append('position', $('input[name="position"]')[0].value);
        formData.append('department_id', $('#department').val());
        formData.append('avatar', $('input[name="avatar"]')[0].files[0]);

        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            contentType: false,
            processData: false,
            url: "{{ route('admin.user.update', $user['id']) }}",
            data: formData,
            success: function(jqXhr, json, errorThrown) {
                $('html,body').animate({
                    scrollTop: 0
                }, 300);
                $('.alert').removeClass('alert-danger').addClass('alert-success').html(
                    'Данные успешно заменены').slideDown(800);
            },
            error: function(jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = '<ul>';
                $.each(errors['errors'], function(index, value) {
                    errorsHtml += '<li>' + value + '</li>';
                });
                errorsHtml += '</ul>';
                $('html,body').animate({
                    scrollTop: 0
                }, 300);
                $('.alert').addClass('alert-danger').html(errorsHtml).slideDown(800);
            }
        });
    }
</script>


<script>
    function addOffice(el) {
        var data = {};
        data['office_appellation'] = $('input[name="office_appellation"]').val();

        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{route('admin.addOffice')}}",
            data: data,
            success: function(jqXhr, json, errorThrown) {
                console.log('Успех');
                var data = JSON.parse(jqXhr);
                $('#Office').append('<option selected value="' + data['id'] + '">' + data['office_appellation'] + '</option>');
            },
            error: function(jqXhr, json, errorThrown) {
                console.log('NO Успех');
            }
        });
    }
</script>

<script>
    function addDepartment(el) {
        var data = {};
        data['department_appellation'] = $('input[name="department_appellation"]').val();
        console.log(data);

        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{route('admin.addDepartment')}}",
            data: data,
            success: function(jqXhr, json, errorThrown) {
                console.log('Успех');
                var data = JSON.parse(jqXhr);
                $('#department').append('<option selected value="' + data['id'] + '">' + data['department_appellation'] + '</option>');
            },
            error: function(jqXhr, json, errorThrown) {
                console.log('NO Успех');
            }
        });
    }
</script>

<script>
    function editPassword(el) {
        var data = $('#changePassword').serialize();
        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{route('admin.users.changePassword', ['id'=>$user['id']])}}",
            data: data,
            success: function(jqXhr, json, errorThrown) {
                $('html,body').animate({
                    scrollTop: 0
                }, 300);
                $('.alert').removeClass('alert-danger').addClass('alert-success').html(
                    jqXhr.message).slideDown(800);
            },
            error: function(jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON.errors;
                var errorsHtml = '<ul>';
                $.each(errors.newPassword, function(index, value) {
                    errorsHtml += '<li>' + value + '</li>';
                });
                errorsHtml += '</ul>';
                $('html,body').animate({
                    scrollTop: 0
                }, 300);
                $('.alert').addClass('alert-danger').html(errorsHtml).slideDown(800);
            }
        });
    }


    function editPassword(el) {
        var data = $('#changePassword').serialize();
        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{route('admin.users.changePassword', ['id'=>$user['id']])}}",
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
@endsection