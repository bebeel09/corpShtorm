@extends('admin.layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">Добавить категорию</a>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Категория</th>
                            <th>Родительская категория</th>
                            <th>Записи (кол-во)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}">
                                        {{ $category->title }}</a>
                                </td>
                                <td>{{ $category->parent_id }}</td>
                                <td>{{ $posts_count[$category->title] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($categories->total() > $categories->count())
                        <br>
                        <div class="card-title">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
