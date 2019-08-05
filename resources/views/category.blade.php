@extends('layouts.app')

@section('title')
    {{ ' - '.$category->title }}
@endsection

@section('content')

    <div class="row">
        <div class="col">
            <div class="category-title">{{ $category->title }}</div>
        </div>
    </div>

    @foreach($posts as $post)
        <table class="table table-bordered">
            <tr>
                <td>
                    <div class="h3">{{ $post->title }}</div>
                </td>
            </tr>
            <tr>
                <td>{{ $post->content_raw }}</td>
            </tr>
        </table>
    @endforeach

    <div class="row">
        <div class="col">
            <div id="pagination">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection