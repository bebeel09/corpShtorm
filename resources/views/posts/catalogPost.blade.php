@extends('layouts.app')

@section('additional_css')
<style>
    img {
        width: 100%;
    }
</style>
@endsection

@section('content')

<div class="pageTitle-block">
    <h2>{{ $post->title }}</h2>
</div>
<div>
    <span>
        @foreach ($postBreadcrump as $breadcrump)
        <a href="{{route('catalog.show', $breadcrump->slug)}}">{{$breadcrump->title}} </a>>>
        @endforeach
        <span>
</div>
<div class="post">
    <div class="post-body">
        <div class="text-right post_date-publish">
            {{$post->created_at}}
        </div>
        <h3 class="post_title"><a href=""></a></h3>
        <p><a class="text-purple text-uppercase text-break" style="background-color:#ff8a3c; color:white; padding: 2px">{{$catalog->title}}</a>
            @can('edit postsCatalog')
            <a href="{{route('admin.catalogPost.edit', $post->id)}}" title="Редактировать пост" class="btn btn-secondary"><span class="fa fa-pencil text-white"></span></a>
            @endrole</p>

        @foreach(json_decode($post->content_json) as $pathFile)
        <a href="{{asset($pathFile)}}"><span class="fa fa-file"></span>{{substr($pathFile, strripos($pathFile, '/')+1)}}</a><br>

        @endforeach
    </div>
    <div class="post-footer">
        <div class="row align-items-center justify-content-between mt-3">
            <div class="col">
                <a href="{{ route('profile',$post->user->id ) }} " class="user-profile">
                    @if(!$post->user->avatar=="")
                    <img src="{{$post->user->avatar}}" alt="user">
                    @endif
                    <span>{{$post->user->first_name}} {{$post->user->sur_name}}</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection