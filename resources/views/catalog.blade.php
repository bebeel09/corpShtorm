@extends('layouts.app')

@section('content')

<div class="pageTitle-block">
    <h2>{{$currentCatalog->title}}</h2>
</div>

<div class="post">
    @if (!$subcatalogs->isEmpty() || !$catalogPosts->isEmpty())
    @foreach($subcatalogs as $subcatalog)
    <div class="post-body">
        <h3 class="post_title"><i class="fa fa-folder-open "></i> <a href="{{route('catalog.show', $subcatalog->slug)}}">{{ $subcatalog->title }}</a></h3>
        <hr>
    </div>
    @endforeach

    @foreach($catalogPosts as $post)
    <div class="post-body">
        <h3 class="post_title"> <i class="fa fa-file-o"></i> <a href="{{ route('catalogPost.show', ['catalogSlug'=>$currentCatalog->slug, 'catalogPostSlug'=>$post->slug]) }}">{{ $post->title }}</a></h3>
        <hr>
    </div>
    @endforeach
    @else
    <span class="text-muted">Здесь пока что ничего нет :D </span>
    @endif
</div>

<div class="row">
    <div class="col">
        <div id="pagination">
            <!-- ПАГИНАЦИЯ -->
        </div>
    </div>
</div>
@endsection