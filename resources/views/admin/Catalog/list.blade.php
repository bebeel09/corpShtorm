@extends('layouts.admin.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Список Каталогов
    </h1>
</section>
<!-- Main content -->
<section class="content">

    @if(session('success'))
    <div class="alert alert-success">
        {{session()->get('success')}}
    </div>
    @endif
    <input type="text" id="search" placeholder="Поиск" class="col p-2 mt-3 mb-3" style=" font-size: 14px;">

    <form action="{{route('admin.catalogPost.index')}}" method="GET">
        <input name="paginateAll" type="hidden" value="1">
        <button type="submit">Показать все</button>
    </form>

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body no-padding">
                    <table class="table table-hover table-responsive" id="categoryList">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Название</th>
                                <th>Каталог</th>
                                <th>Дата создания</th>
                                <th class="text-center">Действия</th>
                            </tr>
                        </thead>
                        @foreach($catalogs as $catalog)
                        <tr>
                            <td>{{$catalog->id}}</td>
                            <td><a href="{{route('catalogPost.show', [ 'catalogSlug'=> $catalog->catalog->slug,'catalogPostSlug'=> $catalog->slug])}}">{{$catalog->title}}</a></td>
                            <td class="text-break">{{$catalog->catalog->title}}</td>
                            <td><time>{{$catalog->created_at->diffForHumans()}}</time></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-around">
                                    <a href="{{route('admin.catalogPost.edit', $catalog->id)}}"><button title="Редактировать" type="submit"><span class="fa fa-pencil text-primary"></span></button></a>
                                    <form action="{{route('admin.catalogPost.destroy', $catalog->id)}}" method="POST">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button title="Удалить пост" type="submit"><span class="fa fa-trash text-danger"></span></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if(Request::get('paginateAll')== null)
    <div class="row">
        {{ $catalogs->links() }}
    </div>
    @endif
</section>
@endsection

@section('additional_js')
<script>
    (function($) {
        $("#search").keyup(function() {
            _this = this;
            $.each($("#categoryList tr"), function() {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1) {
                    $("#categoryList thead > tr:first-child").show();
                    $(this).hide();

                } else {
                    $("#categoryList thead > tr:first-child").show();
                    $(this).show();
                };
            });
        });
    })(jQuery);
</script>
@endsection