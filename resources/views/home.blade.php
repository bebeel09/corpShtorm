@extends('layouts.app')

@section('content')
    <div class="pageTitle-block">
        <h2>Новости</h2>
    </div>
    @foreach($posts as $post)
        <div class="post">
            <div class="post-body">
                <div class="text-right post_date-publish">
                    {{$post->published_at}}
                </div>
                <h3 class="post_title"><a href="{{$post->slug}}">{{ $post->title }}</a></h3>
                <p><a class="text-purple text-uppercase" href="#">#Новости</a></p>

                {{$post->content_html}}

            </div>
            <div class="post-footer">
                <div class="row align-items-center justify-content-between mt-3">
                    <div class="col">
                        <a class="btn btn-round btn-bold btn-primary" href="{{$post->slug}}">Подробнее</a>
                    </div>
                    <div class="col">
                        <a href="#" class="user-profile">
                            <img src="https://pp.userapi.com/c639230/v639230484/330e0/xBUNIhelAh0.jpg?ava=1" alt="user">
                            <span>Евгения Лунина</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <div class="row">
        <div class="col">
            <div id="pagination">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
