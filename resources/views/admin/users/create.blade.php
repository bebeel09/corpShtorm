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
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Добавить пользователя
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
                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.register') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="d-flex">
                                <div class="col pl-0">
                                    <label for="exampleInputFirstName1">Фамилия</label>
                                    <input type="text" autocomplete="off" name="first_name" class="form-control" aria-describedby="nameHelp" placeholder="Петров">
                                </div>
                                <div class="col">
                                    <label for="exampleInputSurName1">Имя</label>
                                    <input type="text" autocomplete="off" name="sur_name" class="form-control" aria-describedby="nameHelp" placeholder="Пётр">
                                </div>
                                <div class="col pr-0">
                                    <label for="exampleInputLastName1">Отчество</label>
                                    <input type="text" autocomplete="off" name="last_name" class="form-control" aria-describedby="nameHelp" placeholder="Петрович">
                                </div>
                            </div>
                            <small id="nameHelp" class="form-text text-muted">Введите Фамилию, Имя, Отчество</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" autocomplete="off" name="email" class="form-control" aria-describedby="DepartmentHelp" placeholder="admin@shtorm-its.ru">
                            <small id="DepartmentHelp" class="form-text text-muted">Введите электронную почту сотрудника</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputLogin1">Логин</label>
                            <input type="login" autocomplete="off" name="login" class="form-control" aria-describedby="loginHelp" placeholder="admin">
                            <small id="loginHelp" class="form-text text-muted">Придумайте логин</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Пароль</label>
                            <input type="password" autocomplete="off" name="password" class="form-control" aria-describedby="passwordHelp" placeholder="">
                            <small id="passwordHelp" class="form-text text-muted">Придумайте пароль</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputAvatar1">Аватарка</label>
                            <input type="file" accept="image/*,image/jpeg" name="avatar" class="form-control" aria-describedby="avatarHelp">
                            <small id="avatarHelp" class="form-text text-muted">Выбирите картинку для аватарки пользователя</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputDepartment1">Отдел</label>
                            <select type="text" autocomplete="off" name="department" id="department" class="form-control" aria-describedby="DepartmentHelp" placeholder="Логистика">
                                @foreach($departments as $department)
                                <option value="{{$department['id']}}">{{$department->department_appellation}}</option>
                                @endforeach
                            </select>
                            <small id="DepartmentHelp" class="form-text text-muted">Введите отдел к которому относится
                                сотрудник</small>

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
                                            <button  onclick="addDepartment(this); return false;" class="col btn btn-success">Добавить</button>
                                        </div>
                                    </div>
                                
                            </div>
                            <!-- end collapse department -->

                        </div>

                        <div class="form-group">
                            <label for="exampleInputPos1">Должность</label>
                            <input type="text" autocomplete="off" name="position" class="form-control" aria-describedby="posHelp" placeholder="Старший специалист">
                            <small id="posHelp" class="form-text text-muted">Введите должность сотрудника</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputworkPhone1">Рабочий телефон</label>
                            <input id="workPhone" type="text" autocomplete="off" name="work_phone" class="form-control" aria-describedby="workPhoneHelp" placeholder="911">
                            <small id="workPhoneHelp" class="form-text text-muted">Рабочий телефон сотрудника</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPhone1">Личный телефон</label>
                            <input id='personalPhone' type="text" autocomplete="off" name="mobile_phone" class="form-control" aria-describedby="phoneHelp" placeholder="79929999999">
                            <small id="phoneHelp" class="form-text text-muted">Личный телефон сотрудника</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputReg1">Регион</label>
                            <select type="text" autocomplete="off" name="region" id="region" class="form-control" aria-describedby="regHelp" placeholder="Верхняя Пышма">
                                @foreach($regions as $region)
                                <option value="{{$region['id']}}">{{$region->region_appellation}}</option>
                                @endforeach
                            </select>

                            <small id="regHelp" class="form-text text-muted">Регион филиала где работает
                                сотрудник</small>

                            <!-- collapse region -->
                            <p>
                                <a class="btn btn-primary" data-toggle="collapse" href="#collapseRegion" role="button" aria-expanded="false" aria-controls="collapseRegion">
                                    Добавить новый регион
                                </a>
                            </p>
                            <div class="collapse" id="collapseRegion">
                               
                                    <div class="form-row align-items-center">
                                        <input type="text" class="col form-control bg-dark text-white" name="region_appellation" placeholder="Название города в котором располагается новый филиал">
                                        <div class="col-auto">
                                            <button onclick="addRegion(this); return false;" class="col btn btn-success">Добавить</button>
                                        </div>
                                    </div>
                               
                            </div>
                            <!-- end collapse region -->

                        </div>

                        <div class="form-group">
                            <label for="exampleInputReg1">филиал </label>
                            <select type="text" name="office" id="Office" class="form-control" aria-describedby="regHelp">
                                @foreach($offices as $office)
                                <option value="{{$office['id']}}">{{$office->office_appellation}}</option>
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
        <div class="col-3">
            <div class="box">
                <div class="box-body">
                    <button type="submit" class="btn btn-success col-12" onclick="">Зарегистрировать</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('additional_js')
<script src="{{ asset('vendor_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('vendor/maskedinput/src/jquery.maskedinput.js')}}"></script>

<script>
    $(document).ready(function() {

        jQuery(function($) {
            $("#personalPhone").mask("+7(999) 99-99-999");
            $("#workPhone").mask("+7(999) 99-99-999");
        });
    });
</script>

<script>
    function addOffice(el) {
        var data={};
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
        var data={};
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
    function addRegion(el) {
        var data={};
         data['region_appellation'] = $('input[name="region_appellation"]').val();

        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{route('admin.addRegion')}}",
            data: data,
            success: function(jqXhr, json, errorThrown) {
                console.log('Успех');
                var data = JSON.parse(jqXhr);
                $('#region').append('<option selected value="' + data['id'] + '">' + data['region_appellation'] + '</option>');
            },
            error: function(jqXhr, json, errorThrown) {
                console.log('NO Успех');
            }
        });
    }
</script>
@endsection