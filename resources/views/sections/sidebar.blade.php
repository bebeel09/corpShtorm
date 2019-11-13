<div class="sidebar d-md-block d-none col-4 pl-0">

    <ul class="sidebar-menu ">

        @foreach ($typeCategory as $categoryItem)
        <li class="p-0 {{ request()->is('/')  ? 'active' : '' }}"><a href="{{route('main')}}"><i class="fa fa-newspaper-o"></i>{{$categoryItem['title']}}</a></li>
        @endforeach

        <li class="p-0 {{ (Request::routeIs('employee')) ? 'active' : '' }}"><a href="{{ route('employee') }}"><i class="fa fa-phone"></i>Телефонный справочник</a></li>
        <li class="p-0 {{ (Request::routeIs('events')) ? 'active' : '' }}"><a href="{{ route('events') }}"><i class="fa fa-calendar"></i>Календарь событий</a></li>
        
        @foreach ($mainCatalogs as $catalog)
        <li class="p-0 {{ request()->is('catalog/'.$catalog['slug'].'*')  ? 'active' : '' }} "><a href="{{route('catalog.show', $catalog['slug'])}}"><i class="fa fa-folder-open"></i>{{$catalog['title']}}</a></li>
        @endforeach
    </ul>
    <hr>
    <div class="post">
        <h3>События недели</h3>
        @if ($events->count())
            <ul class="list-unstyled">
                @foreach ($events as $event)
                    @if($event[0]->start < date('Y-m-d'))
                        @continue
                    @endif
                <hr>
                <li>
                    <time class="text-muted">
                        <em class="text-danger">
                            @if ($event[0]->start == date("Y-m-d"))
                            Сегодня
                            @endif
                        </em>
                        <small class="">{{$event[0]->start}}</small><br>
                    </time>
                    @foreach ($event as $item)
                        <a class="text-break"><i class="{{$item->className}} pr-2">&nbsp;&nbsp;</i>&nbsp;{{$item->title}}</a><br>

                    @endforeach
                </li>
                @endforeach
            </ul>
        @else 
            <span class="text-muted">Нет событий</span>
        @endif
    </div>
</div>


<!-- БОКОВАЯ МЕНЮШКА -->
<input type="checkbox" id="nav-toggle" hidden>
<div class="nav">
    <ul>
       {{-- <li class="p-0 {{ (Request::routeIs('news')) ? 'active' : '' }}"><a href="{{route('news')}}"><i class="fa fa-newspaper-o"></i>Новости</a></li>--}}
        @foreach ($typeCategory as $categoryItem)
        <li class="p-0 {{ request()->path() == 'category/'.$categoryItem['id']  ? 'active' : '' }}"><a href="{{route('showCategory', $categoryItem['slug'])}}"><i class="fa fa-newspaper-o"></i>{{$categoryItem['title']}}</a></li>
        @endforeach
        <li class="p-0 {{ (Request::routeIs('employee')) ? 'active' : '' }}"><a href="{{ route('employee') }}"><i class="fa fa-phone"></i>Телефонный справочник</a></li>
        <li class="p-0 {{ (Request::routeIs('events')) ? 'active' : '' }}"><a href="{{ route('events') }}"><i class="fa fa-calendar"></i>Календарь событий</a></li>
        @foreach ($mainCatalogs as $catalog)
        <li class="p-0 {{ request()->path() == 'catalog/'.$catalog['slug']  ? 'active' : '' }} "><a href="{{route('catalog.show', $catalog['slug'])}}"><i class="fa fa-folder-open"></i>{{$catalog['title']}}</a></li>
        @endforeach
    </ul>
</div>

</div>