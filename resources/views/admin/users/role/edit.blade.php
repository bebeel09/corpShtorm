@extends('layouts.admin.app')

@section('additional_css')
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
        Редактировать роль
    </h1>
</section>
<section class="content">
    @if(session('success'))
    <div class="alert alert-success">
        {{session()->get('success')}}
    </div>
    @endif

    @if(session('status'))
    <div class="alert alert-danger">
        {{session()->get('status')}}
    </div>
    @endif
    <div class="row">
        <div class="col-9">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Роль: {{$role->name}}</h3>
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
                            <h2>Разрешения</h2>
                            <form action="{{route('admin.roles.update', $role->id)}}" method="POST" name="permissionsViaRole" id="permissionsViaRole">
                                {{ method_field('PUT') }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="{{$permission->name}}" id="{{$permission->name}}" {{($role->hasPermissionTo($permission->name)) ? 'checked' : ''}}>
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
                    <button type="submit" form="permissionsViaRole" class="btn btn-success col-12">Изменить</button>
                </div>
            </div>
        </div>

    </div>

</section>
@endsection

@section('additional_js')

<script>
    function editRoleAndPermission() {

        // var data = new FormData();
        // data.append('roles', JSON.stringify( $('form[name="roles"]').serializeArray()));
        // data.append('permissions', JSON.stringify($('form[name="permissions"]').serializeArray()));

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
            url: "",
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