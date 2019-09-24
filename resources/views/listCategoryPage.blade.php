@extends('layouts.app')

@section('content')

<div class="pageTitle-block">
    <h2>{{$currentCategory->title}}</h2>
</div>

<div class="post">
@if (!$subcategories->isEmpty() && !$postsСategories->isEmpty())
@foreach($subcategories as $subcategory)
    <div class="post-body">
        <h3 class="post_title"> <b>	
&#128194;</b> <a href="{{route('listTypeCategory', $subcategory->id)}}">{{ $subcategory->title }}<hr></a></h3>
    </div>
    @endforeach

@foreach($postsСategories as $post)
    <div class="post-body">
        <h3 class="post_title"> <b>	&#128240;</b> <a href="{{ route('blog.posts.show', $post->category->slug.'/'.$post->slug) }}">{{ $post->title }}<hr></a></h3>
    </div>
@endforeach

@else
<span class="text-muted">Здесь пока что ничего нет :D  </span>

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