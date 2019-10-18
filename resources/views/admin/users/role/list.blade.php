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
        Список ролей
    </h1>
</section>
<!-- Main content -->
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
        <div class="col-12">
            <div class="box">
                <div class="box-body no-padding">
                    <table class="table table-hover table-responsive" id="categoryList">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Роль</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        @foreach($roles as $role)
                        <tr>
                            <td class="align-middle">{{$role->id}}</td>
                            <td class="align-middle"><a href="">{{$role->name}}</a></td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-secondary {{(($role->name =='admin' || $role->name =='grant admin') && Auth::user()->hasRole('grant admin')==false) ? 'disabled' : ''}} " title="изменить права доступа роли" href="{{route('admin.roles.edit', $role->id)}}"><span class="fa fa-pencil text-primary"></span></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
  
</section>
@endsection