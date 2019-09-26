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
                            <td>{{$user->id}}</td>
                            <td><a href="">{{$user->first_name}} {{$user->sur_name}} {{$user->last_name}}</a></td>
                            <td>{{$user->position}}</td>
                            <td><time>{{$user->email}}</time></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-around">
                                    <a href="{{route('admin.users.edit', $user->id)}}"><button title="Редактировать пользователя" type="submit"><span class="fa fa-pencil text-primary"></span></button></a>
                                    <form action="{{route('admin.users.destroy', $user->id)}}" method="POST">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button title="Удалить пользователя" type="submit"><span class="fa fa-trash text-danger"></span></button>
                                    </form>
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