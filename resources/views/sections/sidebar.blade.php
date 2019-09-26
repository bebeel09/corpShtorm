<div class="sidebar d-md-block d-none col-4 pl-0">

    <ul class="sidebar-menu ">
        @foreach ($typeCategory as $categoryItem)
        <li class="p-0 {{ request()->path() == 'category/'.$categoryItem['id']  ? 'active' : '' }}"><a href="{{route('rubricTypeCategory', $categoryItem['id'])}}"><i class="fa fa-newspaper-o"></i>{{$categoryItem['title']}}</a></li>
        @endforeach
        
        <li class="p-0 {{ (Request::routeIs('phoneBook')) ? 'active' : '' }}"><a href="{{ route('phoneBook') }}"><i class="fa fa-phone"></i>Телефонный справочник</a></li>
        <li class="p-0 {{ (Request::routeIs('events')) ? 'active' : '' }}"><a href="{{ route('events') }}"><i class="fa fa-calendar"></i>Календарь событий</a></li>

        @foreach ($typeList as $listItem)
        <li class="p-0 {{ request()->path() == 'list/'.$listItem['id']  ? 'active' : '' }} "><a href="{{route('rubricTypeList', $listItem['id'])}}"><i class="fa fa-folder-open"></i>{{$listItem['title']}}</a></li>
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
       {{-- <li class="p-0 {{ (Request::routeIs('news')) ? 'active' : '' }}"><a href="{{route('news')}}"><i class="fa fa-newspaper-o"></i>Новости</a></li>--}}
        @foreach ($typeCategory as $categoryItem)
        <li class="p-0"><a href=""><i class="fa fa-folder-open"></i>{{$categoryItem['title']}}</a></li>
        @endforeach
        <li class="p-0 {{ (Request::routeIs('phoneBook')) ? 'active' : '' }}"><a href="{{ route('phoneBook') }}"><i class="fa fa-phone"></i>Телефонный справочник</a></li>
        @foreach ($typeCategory as $listItem)
        <li class="p-0"><a href="{{route('rubricTypeList', $listItem['id'])}}"><i class="fa">&#128447;</i>{{$listItem['title']}}</a></li>
        @endforeach

    </ul>
</div>

</div>