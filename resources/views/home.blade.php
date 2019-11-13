@extends('layouts.app')

@section('content')
    @if ($postsData)
        @foreach($postsData as $post)
            <div class="post">
                <div class="post-body">
                    <div class="text-right post_date-publish">
                        {{$post->created_at}}
                    </div>
                    <h3 class="post_title"><a href="{{ route('blog.posts.show', $post->category->slug.'/'.$post->slug) }}">{{ $post->title }}</a></h3>
                    <p><a class="text-purple text-uppercase text-break" style="background-color:#ff0015; color:white; padding: 2px 10px">{{ $post->category->title }}</a></p>

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
        <div class="row">
            <div class="col">
                <div id="pagination">
                    {{ $postsData->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="post text-center">
            <img src="https://emojio.ru/images/apple-b/1f912.png" alt="">
            <h1>Сервис чуток приболел</h1>
        </div>
    @endif
@endsection