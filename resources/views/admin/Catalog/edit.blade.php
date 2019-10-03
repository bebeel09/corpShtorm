@extends('layouts.admin.app')
@section('additional_css')

<link rel="stylesheet" href="{{ asset ('vendor_components/select2/dist/css/select2.min.css') }}">
<style>
    #uploadForm,
    #uploadFormAnounce {
        border: 3px dashed #d3d2d2;
        border-radius: 10px;
    }

    .dropzone.dz-clickable .dz-message {
        line-height: 60px !important;
        font-size: 14px !important;
    }
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Добавить каталог
    </h1>
</section>
<section class="content">
    <div class="alert hide"></div>
    <div class="row">

        <div class="col-9">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Файлы</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form>
                        <div class="form-group">
                            <h5>Заголовок</h5>
                            <div class="controls">
                                <input type="text" name="postTitle" class="form-control" required="" data-validation-required-message="This field is required" aria-invalid="false" value="{{$postCatalog->title}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Выберите файлы</h5>
                            <input onchange="seeFiles(this)" id="filesForCatalog" type="file" multiple>
                        </div>
                    </form>
                    <div>

                        <div class="p-0">
                            <label for="fileArea">Новые файлы</label>
                            <table class="table table-hover border-bottom border-dark" id="fileArea">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Название файла</th>
                                        <th>Размер</th>
                                        <th class="text-center">Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="p-0">
                            <label for="dBasefileArea">Текущие файлы</label>
                            <table class="table table-hover border-bottom border-dark" id="dBasefileArea">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Название файла</th>
                                        <th class="text-center">Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">

            <div class="box">
                <div class="box-body">
                    <button type="submit" class="btn btn-success col-12" onclick="updateCatalogPost(this)">Опубликовать</button>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Каталог</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <h5>Выбрать каталог:</h5>
                        <div class="controls">
                            <select class="form-control select2" style="width: 100%;" name="catalog">
                                @foreach($catalogs as $catalog)
                                <option @if($catalog->id == $postCatalog->catalog->id) selected @endif
                                    value="{{$catalog->id}}">{{$catalog->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <a data-widget="hider" style="text-decoration: underline;"> Добавить новый каталог</a>
                        <form id="addCatalogForm" method="POST" style="margin-top: 15px; display: none;">
                            @csrf
                            <div class="form-group">
                                <label for="newCatalogName">Название нового каталога</label>
                                <input type="text" name="newCatalogName" id="newCatalogName" class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label for="newCatalogName">Родительский каталог</label>
                                <select class="form-control" style="width: 100%;" id="parentRubric" name="newCatalogParent">
                                    <option value="0" selected>Без родительского каталога</option>
                                    @foreach($catalogs as $catalog)
                                    <option value="{{$catalog->id}}">{{$catalog->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-block btn-success" onclick="addCatalog(this); return false;"><i class="fa fa-plus"></i> Добавить новую рубрику</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('additional_js')
<script src="{{ asset('vendor_components/select2/dist/js/select2.full.min.js')}}"></script>

<script>
    const Store = {
        files: [], // для новых файлов
        dBasefilesPath: [ //для путей файлов из бд
            @foreach($filesPath as $filePath)["{{$filePath}}", 0],
            @endforeach
        ]
    }


    $(document).ready(function() {
        showFiles();
        $('.select2').select2();
        $('[data-widget=hider]').on('click', function(event) {
            if (event) event.preventDefault();
            var isOpen = $('#addCatalogForm').is('.collapsed-box');
            if (isOpen) {
                $('#addCatalogForm').slideUp(300, function() {
                    $(this).removeClass('collapsed-box');
                });
            } else {
                $('#addCatalogForm').slideDown(300, function() {
                    $(this).addClass('collapsed-box');
                });
            }
        })
    });


    function seeFiles(e) {
        if (!e.files.length) {
            return;
        }

        // создаем новый массив с нашими файлами
        const files = Object.keys(e.files).map((i) => e.files[i]);

        addFiles(files);
        showFiles();

        // очищаем input, т.к. файл мы сохранили
        e.value = '';

    }

    function addFiles(files) {
        // добавляем файлы в общую кучу
        Store.files = Store.files.concat(files);
    }

    function showFiles() {
        $('#fileArea>tbody').html("");
        $('#dBasefileArea>tbody').html("");
        Store.dBasefilesPath.forEach(function(item, i) {
            if (item[1] != 1) {
                $('#dBasefileArea>tbody').append('<tr><th class="align-middle text-break">' + item[0].slice(item[0].lastIndexOf('/') + 1, -1) + '</th><th class="d-flex justify-content-around"><button onclick="deletedBaseFile(' + i + ')" class="btn btn-success"><i class="fa fa-trash"></i></button></th></tr>');
            }
        });
        Store.files.forEach(function(item, i) {
            $('#fileArea>tbody').append('<tr><th class="align-middle text-break">' + item.name + '</th><th class="align-middle">' + (item.size / 1024 / 1024).toFixed(2) + 'Mb</th><th class="d-flex justify-content-around"><button onclick="deleteFile(' + i + ')" class="btn btn-danger"><i class="fa fa-trash"></i></button></th></tr>');
        });
    }

    function deleteFile(index) {
        Store.files.splice(index, 1);
        showFiles();
    }

    function deletedBaseFile(index) {
        Store.dBasefilesPath[index][1]=1;
        showFiles();
    }

    function updateCatalogPost(msg) {

        var formData = new FormData();

        Store.files.map((file, index) => {
            formData.append(index, file);
        });
        formData.append('dBasefilesPath', JSON.stringify(Store.dBasefilesPath));
        formData.append('post_title', $('input[name="postTitle"]')[0].value);
        formData.append('catalog', $('select[name="catalog"]')[0].value);

        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{route('admin.catalogPost.update', $postCatalog->id)}}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(jqXhr, json, errorThrown) {
                $('html,body').animate({
                    scrollTop: 0
                }, 300);
                $('.alert').removeClass('alert-danger').addClass('alert-success').html(
                    'Новость успешно опубликована, просмотреть: <a href="' + jqXhr.url + '">' + jqXhr.url +
                    '</a>').slideDown(800);
            },
            error: function(jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = '<ul>';
                $.each(errors['errors'], function(index, value) {
                    errorsHtml += '<li>' + value + '</li>';
                });
                errorsHtml += '</ul>';
                $('html,body').animate({
                    scrollTop: 0
                }, 300);
                $('.alert').removeClass('alert-success').addClass('alert-danger').html(errorsHtml).slideDown(800);
            }
        });
    }

    function addCatalog(el) {
        var data = $('#addCatalogForm').serialize();

        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            type: "POST",
            url: "{{route('admin.addCatalog')}}",
            data: data,
            success: function(jqXhr, json, errorThrown) {
                console.log('Успех');
                $('.select2.form-control').append('<option selected value="' + jqXhr.catalogId + '">' + jqXhr
                    .catalogName + '</option>');
            },
            error: function(jqXhr, json, errorThrown) {}
        });
    }
</script>
@endsection