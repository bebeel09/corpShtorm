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
{{--                    <search-component>--}}
{{--                        --}}
{{--                    </search-component>--}}
                    <div class="header-1__search">
                        <div class="header-1__search_input-block">
                            <i class="fa fa-search header-1__search_input-icon"></i>
                            <input type="text" class="header-1__search_input" id="search_input" placeholder="Сотрудник, новости или любой контент" spellcheck="false" autocomplete="off">
                            <div class="search-results">
                                <div class="suggestions-header">
                                    <span>Пользователи</span>
                                </div>
                                <div class="suggestions-body">
                                    <a href="#" class="suggest-string">
                                        <div class="d-flex align-items-center">
                                            <img src="https://sun9-49.userapi.com/c851232/v851232663/197ad0/IEx66gks-m4.jpg?ava=1" alt="user">
                                            <span>Шикалов Никита</span>
                                        </div>
                                        <div class="d-flex justify-content-around flex-wrap">
                                            <div class="d-flex align-items-center" style="color: rgba(0,0,0, .5)">
                                                <i class="fa fa-phone d-flex justify-content-center align-items-center" style="font-size: 24px"></i>
                                                <span class="phone-number">880</span>
                                            </div>
                                            <div class="d-flex align-items-center" style="margin: 0 20px; color: rgba(0,0,0, .5)">
                                                <i class="fa fa-mobile d-flex justify-content-center align-items-center" style="font-size: 27px"></i>
                                                <span class="phone-number">8805553535</span>
                                            </div>
                                            <div class="d-flex align-items-center" style="color: rgba(0,0,0, .5)">
                                                <i class="fa fa-envelope d-flex justify-content-center align-items-center" style="font-size: 20px"></i>
                                                <span class="phone-number">shtorm@storm-its.ru</span>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="all-results">
                                        Все результаты
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                                <div class="suggestions-header">
                                    <span>Посты</span>
                                </div>
                                <div class="suggestions-body">
                                    <a href="#" class="suggest-string">
                                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
                                        <div class="text-uppercase" style="background-color:#ff0015; color:white; padding: 1px 10px; font-size: 12px">#новости</div>
                                    </a>
                                    <a href="#" class="suggest-string">
                                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
                                        <div class="text-uppercase" style="background-color:#ff0015; color:white; padding: 1px 10px; font-size: 12px">#новости</div>
                                    </a>
                                    <a href="#" class="suggest-string">
                                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
                                        <div class="text-uppercase" style="background-color:#ff0015; color:white; padding: 1px 10px; font-size: 12px">#новости</div>
                                    </a>
                                    <a href="#" class="all-results">
                                        Все результаты
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-1__item profile nowrap col-auto">
                    <a class="user-profile dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="name">
                            <span>{{$currentUser->first_name}} {{$currentUser->sur_name}} {{$currentUser->last_name}}</span>
                        </div>
                        <div class="avatar">
                            Д
                        </div>
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
                <a href="{{route('logout')}}" class="btn btn-danger text-white">
                    Выход
                </a>
            </div>
        </div>
    </div>
</header>