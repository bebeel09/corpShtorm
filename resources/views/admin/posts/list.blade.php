@extends('layouts.admin.app')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Новости
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
                                    <th>Название</th>
                                    <th>Категория</th>
                                    <th>Дата создания</th>
                                    <th class="text-center">Действия</th>
                                </tr>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td><a href="{{route('blog.posts.show', $item->category->slug.'/'.$item->slug)}}">{{$item->title}}</a></td>
                                        <td>{{$item->category->title}}</td>
                                        <td><time>{{$item->created_at->diffForHumans()}}</time></td>
                                        <td class="text-center">
                                            <a href="{{route('admin.posts.edit', $item->id)}}">Редактировать</a>
                                            <form action="{{route('admin.posts.destroy', $item->id)}}" method="POST">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit"><span class="fa fa-trash text-danger"></span></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{ $items->links() }}
            </div>
        </section>
@endsection