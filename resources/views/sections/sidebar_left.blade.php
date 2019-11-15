<div class="sidebar_container">
    <div class="sidebar">
        <ul class="sidebar-menu">
            @foreach ($typeCategory as $categoryItem)
                <li class="{{ (request()->is('/') || Request::routeIs('showCategory') || Request::routeIs('showPost')) ? 'active' : '' }}"><a href="{{route('main')}}"><i class="fa fa-newspaper-o"></i>{{$categoryItem['title']}}</a></li>
            @endforeach
            <li class="{{ (Request::routeIs('employee')) ? 'active' : '' }}"><a href="{{ route('employee') }}"><i class="fa fa-phone"></i>Телефонный справочник</a></li>
            <li class="{{ (Request::routeIs('events')) ? 'active' : '' }}"><a href="{{ route('events') }}"><i class="fa fa-calendar"></i>Календарь событий</a></li>
            @foreach ($mainCatalogs as $catalog)
                <li class="{{ request()->is('catalog/'.$catalog['slug'].'*')  ? 'active' : '' }} "><a href="{{route('catalog.show', $catalog['slug'])}}"><i class="fa fa-folder-open"></i>{{$catalog['title']}}</a></li>
            @endforeach
        </ul>
    </div>
</div>