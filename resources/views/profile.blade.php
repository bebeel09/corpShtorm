@extends('layouts.app')

@section('content')
<div class="d-flex-column  d-md-flex">
    <div class="post col-12 col-md-4">
        <img style="width: 100%;" src="{{$userMetaData->avatar}}" alt="">
    </div>
    <div class="post col ml-0 ml-md-3 ">
        <div class="">
            <h3><b> {{ $userMetaData->first_name }} {{ $userMetaData->sur_name }} {{ $userMetaData->last_name }}</b></h3>
            <hr>
        </div>
        <div>
            <table>
                <tbody>

                    <tr>
                        <th>Рабочий телефон: </th>
                        <th>{{$userMetaData->work_phone}}</th>
                    </tr>
                    <tr>
                        <th>Личный телефон: </th>
                        <th>{{$userMetaData->mobile_phone}}</th>
                    </tr>
                    <tr>
                        <th>email: </th>
                        <th><a href="mailTo:{{$userMetaData->email}}">{{$userMetaData->email}}</a></th>
                    </tr>
                    <tr>
                        <th>Регион: </th>
                        <th>{{$userMetaData->region->region_appellation}}</th>
                    </tr>
                    <tr>
                        <th>Офис: </th>
                        <th>{{$userMetaData->office->office_appellation}}</th>
                    </tr>
                    <tr>
                        <th>Отдел: </th>
                        <th>{{$userMetaData->department->department_appellation}}</th>
                    </tr>
                    <tr>
                        <th>Должность: </th>
                        <th>{{$userMetaData->position}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="post achivment">
    Не знаю зачем
</div>


@endsection