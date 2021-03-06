@extends('layouts.app')

@section('content')

    <div class="pageTitle-block">
        <h2>Лента новостей</h2>
    </div>
    @if (!$postsData->isEmpty())
    @foreach($postsData as $post)
    <div class="post">
        <div class="post-body">
            <div class="text-right post_date-publish">
                {{$post->created_at}}
            </div>
            <h3 class="post_title"><a href="{{ route('blog.posts.show', $post->category->slug.'/'.$post->slug) }}">{{ $post->title }}>></a></h3>
            <p><a class="text-purple text-uppercase text-break" style="background-color:#ff8a3c; color:white; padding: 2px">{{ $post->category->title }}</a></p>

            {{$post->excerpt}}

        </div>
        <div class="post-footer">
            <div class="row align-items-center justify-content-between mt-3">
                <div class="col">
                    <a href="{{ route('profile',$post->user->id ) }}" class="user-profile">
                        @if(!$post->user->avatar=="")
                        <img src="{{$post->user->avatar}}" alt="user">
                        @endif
                        <span>{{$post->user->first_name}} {{$post->user->sur_name}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@else
<div class="post">
<span class="text-muted">Пока не опубликованно ни одной новости :D</span>
</div>
@endif


    <div class="row">
        <div class="col">
            <div id="pagination">
            {{ $postsData->links() }}
            </div>
        </div>
    </div>
@endsection