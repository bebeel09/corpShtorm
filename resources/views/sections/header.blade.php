{{--<header class="header container-fluid">--}}
{{--    <div class=" row align-items-center justify-content-between pl-3 pr-3">--}}
{{--        <label for="nav-toggle" class="nav-toggle d-block d-md-none btn btn-success">--}}
{{--        </label>--}}
{{--        <div class="">--}}
{{--            <a href="{{route('main')}}" class="header_logo"></a>--}}
{{--        </div>--}}

{{--        <div class=" offset-md-6 col-auto header_user-profile dropdown p-0">--}}
{{--            <a class="user-profile dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                @if (!$currentUser->avatar=="")--}}
{{--                <img src="{{$currentUser->avatar}}" alt="user">--}}
{{--                @endif--}}
{{--                <span class="d-xl-inline d-none ">{{$currentUser->first_name}} {{$currentUser->sur_name}} {{$currentUser->last_name}}</span>--}}
{{--            </a>--}}


{{--            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">--}}
{{--                <a class="dropdown-item ml-0" href="{{ route('profile', $currentUser['id'])}}">Моя страница</a>--}}
{{--                @if($currentUser->hasPermissionTo('access webPanel'))--}}
{{--                <a class="dropdown-item ml-0" href="{{route('admin.dashboard')}}">Админ панель</a>--}}
{{--                @endif--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a class="dropdown-item ml-0" href="{{route('logout')}}">Выход</a>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</header>--}}

<header class="header-1">
    <div class="header-1__navigation sticky">
        <div class="container">
            <div class="header-1__inner row align-items-center">
                <div class="header-1__item text-left nowrap col-auto">
                    <span class="header-1__logo">
                        <a href="{{route('main')}}" class="header-logo header-logo_main"></a>
                    </span>
                </div>
                <div class="header-1__item header-1__item__fullwidth">
                    <search-component></search-component>
                </div>
                <div class="header-1__item profile nowrap col-auto">
                    <a class="user-profile dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{$currentUser->first_name}} {{$currentUser->sur_name}} {{$currentUser->last_name}}</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item ml-0" href="{{ route('profile', $currentUser['id'])}}">Моя страница</a>
                        @if($currentUser->hasPermissionTo('access webPanel'))
                            <a class="dropdown-item ml-0" href="{{route('admin.dashboard')}}">Админ панель</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item ml-0" href="{{route('logout')}}">Выход</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>