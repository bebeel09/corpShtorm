<div class="info-block_container">
    <div class="info-block">
        <div class="box">
            <div class="box_title">
                События недели
            </div>
            <div class="box_content">
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
    </div>
</div>