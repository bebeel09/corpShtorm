@extends('admin.layouts.admin')

@section('content')
    @if($item->exists)
        <form method="POST" action="{{ route('admin.categories.update', $item->id) }}">
        @method('PATCH')
    @else
        <form method="POST" action="{{ route('admin.categories.store') }}">
    @endif

    @csrf
    @if($errors->any())
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                    {{ $errors->first() }}
                </div>
            </div>
        </div>
    @endif
    @if(session('success'))
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                    {{ session()->get('success') }}
                </div>
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                @if($item->exists)
                                    <div class="h4">Изменение категории</div>
                                @else
                                    <div class="h4">Добавление категории</div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="maindata" role="tabpanel">
                                    <div class="form-group">
                                        <label for="title">Название</label>
                                        <input name="title" value="{{ $item->title }}" id="title" type="text"
                                               class="form-control" minlength="3" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="parent_id">Родительская категория</label>
                                        <select name="parent_id" id="parent_id" class="form-control"
                                                placeholder="Выберете категорию..." required>
                                            @foreach($categoryList as $categoryOption)
                                                <option value="{{ $categoryOption->id }}"
                                                        @if($categoryOption->id == $item->parent_id) selected @endif>
                                                    {{ $categoryOption->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection