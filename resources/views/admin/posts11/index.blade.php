@extends('admin.layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <a class="btn btn-primary" href="{{ route('admin.posts.create') }}">Добавить запись</a>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Автор</th>
                        <th>Категория</th>
                        <th>Заголовок</th>
                        <th>Дата публикации</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->user->name}}</td>
                                <td>{{ $post->category->title }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}">{{ $post->title }}</a>
                                </td>
                                <td>{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d.m.Y') : '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot></tfoot>
                </table>
                @if($posts->total() > $posts->count())
                    <br>
                    <div class="card-title">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
