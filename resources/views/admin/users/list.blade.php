@extends('layouts.admin.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Список пользователей
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
                            <th>ФИО</th>
                            <th>Должность</th>
                            <th>Email</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                            <td class="align-middle">{{$user->id}}</td>
                            <td class="align-middle"><a href="">{{$user->first_name}} {{$user->sur_name}} {{$user->last_name}}</a></td>
                            <td class="align-middle">{{$user->position}}</td>
                            <td class="align-middle">{{$user->email}}</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-between">

                                    @if(Auth::user()->hasPermissionTo('edit users'))
                                    <a class="btn btn-secondary" title="изменить данные пользователя" href="{{route('admin.users.edit', $user->id)}}"><span class="fa fa-pencil text-primary"></span></a>
                                    @endif
                                    <a class="btn btn-secondary {{((Auth::user()->hasPermissionTo('edit rolesAndPermissions') && !$user->hasAnyRole(['admin','grant admin'])) || Auth::user()->hasRole('grant admin')) ? '' : 'disabled'}}" title="изменить права доступа" href="{{route('admin.users.permission.edit', $user->id)}}"><span class="fa fa-shield text-primary"></span></a>
                                    @if(Auth::user()->hasPermissionTo('delete users'))
                                    <form action="{{route('admin.users.destroy', $user->id)}}" method="POST">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-secondary " title="Удалить пользователя" type="submit"><span class="fa fa-trash text-danger"></span></button>
                                    </form>

                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
</section>
@endsection