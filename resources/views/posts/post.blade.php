@extends('layouts.app')

@section('additional_css')
<style>
img{
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
     <a href="{{route('listTypeCategory', $breadcrump->id)}}">{{$breadcrump->title}} </a>>>
    @endforeach
    <span>
    </div>
        <div class="post">
            <div class="post-body">
                <div class="text-right post_date-publish">
                {{$post->created_at}}
                </div>
                <h3 class="post_title"><a href=""></a></h3>
                <p><a class="text-purple text-uppercase text-break" style="background-color:#ff8a3c; color:white; padding: 2px">{{$category->title}}</a></p>

              {!! $post->content_html !!}

            </div>
            <div class="post-footer">
                <div class="row align-items-center justify-content-between mt-3">
                    <div class="col">
                        <a href="{{ route('profile',$post->user->id ) }} " class="user-profile">
                            <img src="{{$post->user->avatar}}" alt="user">
                            <span>{{$post->user->first_name}} {{$post->user->sur_name}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

@endsection
