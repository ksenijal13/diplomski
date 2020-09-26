@for($j = 0; $j < 8; $j ++)
    @foreach($schedule as $key => $s)


        <td id="column{{$i}}" class="td-time"><a href="#" class="link-time">{{$s->time}}</a></td>
        <td id="column{{$i}}" class="td-time"><a href="#" class="link-time"></a></td>

        @if($s->day_id == $day->day_id)
            <td data-day="{{$day->day_id}}" id="column-activity-{{$day->day_id}}">
                <a href="#" class="link-activity">
                    {{$s->activity}}
                    @unset($s[$key])
                </a>
        @else
            <td data-day="{{$day->day_id}}" id="column-activity-{{$day->day_id}}">
                <a href="#" class="link-activity">
                </a>
            </td>
        @endif

    @endforeach
@endfor
