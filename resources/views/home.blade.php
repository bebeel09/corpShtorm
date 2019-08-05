{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">Dashboard</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    You are logged in!--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}


@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="category-title">Новости</div>
        </div>
    </div>
    @foreach($posts as $post)
        <div class="post">
            <table class="table table-bordered">
                <tr>
                    <td>
                        <div class="h4">{{ $post->title }}</div>
                    </td>
                </tr>
                <tr>
                    <td>{{ $post->content_raw }}</td>
                </tr>
            </table>
        </div>
    @endforeach


    <div class="row">
        <div class="col">
            <div id="pagination">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
