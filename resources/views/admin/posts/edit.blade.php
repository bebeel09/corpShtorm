@extends('layouts.admin.app')
@section('additional_css')

<link rel="stylesheet" href="{{ asset ('vendor_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset ('vendor/summernote/dist/summernote.css') }}">
<link rel="stylesheet" href="{{ asset ('vendor/summernote/dist/summernote-bs4.css') }}">
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
        Редактировать пост
    </h1>
</section>
<section class="content">
    <div class="alert hide"></div>
    <div class="row">

        <div class="col-9">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{$item->title}}</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
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
                                <input type="text" name="postTitle" class="form-control" required=""
                                    value="{{$item->title}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Текст поста</h5>
                            <textarea id="summernote" name="editor1" rows="20"
                                cols="80">{{$item->content_html}}</textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-3">

            <div class="box">
                <div class="box-body">
                    <button type="submit" class="btn btn-success col-12" onclick="editPost(this)">Обновить
                        пост</button>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Рубрика</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <h5>Выбрать рубрику:</h5>
                        <div class="controls">
                            <select class="form-control select2" style="width: 100%;" name="category">
                                @foreach($categories as $category)
                                <option @if($category->id == $item->category->id) selected @endif
                                    value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <a data-widget="hider" style="text-decoration: underline;"> Добавить новую рубрику</a>
                        <form id="addCategoryForm" method="POST" style="margin-top: 15px; display: none;">
                            @csrf
                            <div class="form-group">
                                <label for="newCategoryName">Название новой рубрики</label>
                                <input type="text" name="newCategoryName" id="newCategoryName" class="form-control"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label for="typeCategory">Тип рубрики</label>
                                <select type="text"  onchange="sortParentRubricByType()" name="typeCategory" id="typeCategory" class="form-control" required="">
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="newCategoryName">Родительская рубрика</label>
                                <select class="form-control" style="width: 100%;" id="parentRubric" name="newCategoryParent">
                                <option value="0" selected>Без родительской категории</option>
                                    @foreach($categories as $category)
                                    <option data-type="{{$category->type_id}}" value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-block btn-success" onclick="addCategory(this); return false;"><i
                                    class="fa fa-plus"></i> Добавить новую рубрику</button>
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
<script src="{{ asset('vendor/summernote/dist/summernote.js')}}"></script>
<script src="{{ asset('vendor/summernote/dist/summernote-bs4.js')}}"></script>
<script src="{{ asset('vendor/summernote/plugin/uploadfile-master/summernote-ext-uploadfile.js')}}"></script>


<script>
$(document).ready(function() {

    $('#summernote').summernote({
        lang: "ru-RU",
        height: 450,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['uploadfile', ['uploadfile']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                for (var i = 0; i < files.length; i++) {
                    sendCMSFile(files[i]);
                }
            }
        }
    });
});

function sendCMSFile(file) {
    if (file.type.includes('image')) {
        var name = file.name.split(".");
        name = name[0];
        var data = new FormData();
        data.append('action', 'imgUpload');
        data.append('file', file);
        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}'
            },
            url: "{{route('admin.create.linkImg')}}",
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(linkToImg) {
                $('#summernote').summernote('insertImage', linkToImg);
            }
        });
    }
}
</script>
<script>
$(document).ready(function() {
    sortParentRubricByType();
    $('.select2').select2();
    $('[data-widget=hider]').on('click', function(event) {
        if (event) event.preventDefault();
        var isOpen = $('#addCategoryForm').is('.collapsed-box');
        console.log(isOpen);
        if (isOpen) {
            $('#addCategoryForm').slideUp(300, function() {
                $(this).removeClass('collapsed-box');
            });
        } else {
            $('#addCategoryForm').slideDown(300, function() {
                $(this).addClass('collapsed-box');
            });
        }
    })
});

function sortParentRubricByType() {
        var typeId = $('#typeCategory').val(),
            optionsCount = $("#parentRubric option").length;

        $("#parentRubric option").each(function() {
            if (this.dataset.type == typeId) {
                this.hidden=false;
            }else this.hidden=true;
        });
    }



function editPost(msg) {
    var data = {};

    data['title'] = $('input[name="postTitle"]')[0].value;
    data['content_html'] = $('#summernote').val();
    data['category_id'] = $('select[name=category]')[0].value;

    $.ajax({
        headers: {
            'X-CSRF-Token': '{{csrf_token()}}'
        },
        type: "PATCH",
        url: "{{route('admin.posts.update', $item->id)}}",
        data: data,
        success: function(jqXhr, json, errorThrown) {
            $('html,body').animate({
                scrollTop: 0
            }, 300);
            $('.alert').removeClass('alert-danger').addClass('alert-success').html(
                'Новость успешно изменена, просмотреть: <a href="' + jqXhr.url + '">' + jqXhr.url +
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
            $('.alert').addClass('alert-danger').html(errorsHtml).slideDown(800);
        }
    });
}

function addCategory(el) {
    var data = $('#addCategoryForm').serialize();
    console.log(data);
    $.ajax({
        headers: {
            'X-CSRF-Token': '{{csrf_token()}}'
        },
        type: "POST",
        url: "{{route('blog.category.store')}}",
        data: data,
        success: function(jqXhr, json, errorThrown) {
            console.log('Успех');
            $('.select2.form-control').append('<option selected value="' + jqXhr.categoryId + '">' + jqXhr
                .categoryName + '</option>');
        },
        error: function(jqXhr, json, errorThrown) {
            console.log('NO Успех');
        }
    });
}
</script>
@endsection