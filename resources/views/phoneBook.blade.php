@extends('layouts.app')

@section('content')

<div class="pageTitle-block">
    <h2>Телефонный справочник</h2>
</div>
<div class="post">
    <input type="text" id="search" placeholder="Поиск по справочнику" class="col p-2 mt-3 mb-3" style="border: 2px solid #cc0f04; font-size: 14px;">

    <?php
    $i = 0;
    ?>
    <table class="table table-hover table-responsive d-md-table" id="spravochnik">
        <caption>{{$users["0"]->office->office_appellation}}</caption>
        <thead class="thead-light">
            <tr>
                <th scope="col">ФИО</th>
                <th scope="col">email</th>
                <th scope="col">Должность</th>
                <th scope="col">Номер телефона</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            @if($i>0 && $user->office->id!=$users[$i-1]->office->id)
            <table class="table table-hover table-responsive d-md-table" id="spravochnik">
            <caption>{{$user->office->office_appellation}}</caption>    
            <thead class="thead-light">
                    <tr>
                        <th scope="col">ФИО</th>
                        <th scope="col">email</th>
                        <th scope="col">Должность</th>
                        <th scope="col">Номер телефона</th>
                    </tr>
                </thead>
                <tbody>
                    @endif
                    <tr>
                        <td scope="row"><a href="{{ route('profile', $user->id)}}"> {{$user->first_name}} {{$user->sur_name}} {{$user->last_name}}</a></td>
                        <td> <a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                        <td>{{$user->position}}</td>
                        <td>{{$user->work_phone}}</td>
                    </tr>
                    @if($i>0 && $user->office->id!=$users[$i-1]->office->id)
                </tbody>
            </table>
            @endif
            <?php
            $i++;
            ?>
            @endforeach
        </tbody>
    </table>

</div>


@endsection

@section('additional_js')
<script>
    (function($) {
        $("#search").keyup(function() {
            _this = this;
            $.each($("#spravochnik tr"), function() {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1) {
                    $(this).hide();
                    
                } else {
                    $("#spravochnik thead > tr:first-child").show();
                    $(this).show();
                };
            });
        });
    })(jQuery);
</script>
@endsection