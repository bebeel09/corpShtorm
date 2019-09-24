<div class="sidebar d-md-block d-none col-4 pl-0">

    <ul class="sidebar-menu ">
        <li class="p-0 {{ (Request::routeIs('news')) ? 'active' : '' }}"><a href="{{route('news')}}"><i class="fa fa-newspaper-o"></i>Новости</a></li>
        <li class="p-0 {{ (Request::routeIs('phoneBook')) ? 'active' : '' }}"><a href="{{ route('phoneBook') }}"><i class="fa fa-phone"></i>Телефонный справочник</a></li>
        <li class="p-0 {{ (Request::routeIs('events')) ? 'active' : '' }}"><a href="{{ route('events') }}"><i class="fa fa-calendar"></i>Календарь событий</a></li>

        @foreach ($TypeCategory as $category)
        <li class="p-0 {{ request()->path() == 'category/'.$category['id']  ? 'active' : '' }} "><a href="{{route('listTypeCategory', $category['id'])}}"><i class="fa fa-folder-open"></i>{{$category['title']}}</a></li>
        @endforeach
    </ul>
    <hr>
    <div class="post">
        <h3>События недели</h3>
        @if ($eventsDate != Null)
        <ul class="list-unstyled">
            @foreach ($eventsDate as $eventDate)
            <hr>
            <li id="">
                <time class="text-muted">
                    <em class="text-danger">
                        @if ($eventDate[0]->start == date("Y-m-d"))
                        Сегодня
                        @endif
                    </em>
                    <small class="">{{$eventDate[0]->start}}</small><br>
                </time>
                @foreach ($eventDate as $event)
                    <a class="text-break"><i class="{{$event->className}} pr-2">&nbsp;&nbsp;</i>&nbsp;{{$event->title}}</a><br>

                @endforeach
            </li>
            @endforeach
        </ul>
        @else 
       <span class="text-muted"> На этой неделе мероприятий нет </span>
        @endif
    </div>
</div>


<!-- БОКОВАЯ МЕНЮШКА -->
<input type="checkbox" id="nav-toggle" hidden>
<div class="nav">
    <ul>
        <li class="p-0 {{ (Request::routeIs('news')) ? 'active' : '' }}"><a href="{{route('news')}}"><i class="fa fa-newspaper-o"></i>Новости</a></li>
        <li class="p-0 {{ (Request::routeIs('phoneBook')) ? 'active' : '' }}"><a href="{{ route('phoneBook') }}"><i class="fa fa-phone"></i>Телефонный справочник</a></li>
        @foreach ($TypeCategory as $category)
        <li class="p-0"><a href="{{route('listTypeCategory', $category['id'])}}"><i class="fa">&#128447;</i>{{$category['title']}}</a></li>
        @endforeach
    </ul>
</div>

</div>