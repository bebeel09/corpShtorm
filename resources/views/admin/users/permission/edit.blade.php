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
        Изменение ролей и прав пользователя
    </h1>
</section>
<section class="content">
    <div class="alert hide"></div>
    <div class="row">
        <div class="col-9">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{$user->first_name." ". $user->sur_name ." ".$user->last_name}}</h3>
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

                    <div class="d-flex">
                        <div class="col-4">
                            <h2>Роль</h2>
                            <form action="" name="roles">

                                @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="{{$role->name}}" id="{{$role->name}}" {{($user->hasRole($role->name)) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="{{$role->name}}">
                                        {{$role->name}}
                                    </label>
                                </div>
                                @endforeach

                            </form>
                        </div>
                        <div class="col-4">
                            <h2>Разрешения</h2>
                            <form action="" name="permissions">

                                @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="{{$permission->name}}" id="{{$permission->name}}" {{($user->hasPermissionTo($permission->name)) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="{{$permission->name}}">
                                        {{$permission->name}}
                                    </label>
                                </div>
                                @endforeach

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="box">
                <div class="box-body">
                    <button type="submit" class="btn btn-success col-12" onclick="editRoleAndPermission()">Опубликовать</button>
                </div>
            </div>
        </div>

    </div>

</section>
@endsection

@section('additional_js')

<script>
    function editRoleAndPermission() {
        var formData = new FormData();

        $('form[name="roles"]').find('input:checkbox:checked').each(function(i, elem) {
            formData.append(i + 'r', elem.name);
        });

        $('form[name="permissions"]').find('input:checkbox:checked').each(function(i, elem) {
            formData.append(i + 'p', elem.name);
        });

        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{ route('admin.users.permission.update', $user->id) }}",
            contentType: false,
            processData: false,
            data: formData,
            success: function(jqXhr, json, errorThrown) {
                console.log(jqXhr);
                $('html,body').animate({
                    scrollTop: 0
                }, 300);
                $('.alert').removeClass('alert-danger').addClass('alert-success').html(jqXhr.message).slideDown(800);
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

@endsection