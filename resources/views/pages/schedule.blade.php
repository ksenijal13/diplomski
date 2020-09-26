@extends('layouts.template')
@section('title')
    Raspored
@endsection
@section('main')
    <div id="content" class="flex-element">
        <div id="schedule-wrapper">
            <div id="schedule-header">
                <h2>Raspored</h2>
                <a href="{{url('/delete-schedule')}}" id="delete-schedule">Poništi raspored, dodaj novi</a>
            </div>
            <table id="schedule-table">
                <tr id="schedule-first">
                    <th id="th-time"><i class="fa fa-clock-o" aria-hidden="true"></i></th>
                    @foreach($days as $day)
                        <th>{{$day->day_name}}</th>
                    @endforeach
                </tr>
                  @foreach($time as $t)
                      <tr>
                          <td id="column{{$t->time}}" class="td-time">{{substr($t->time, 0, 5)}}
                              <input type="hidden" class="time" name="time"
                                      value="{{$t->time}}"/>
                          </td>
                          @for($i = 1; $i < 8; $i++)
                              <td data-day="{{$i}}">
                                  <a href="#" class="link-activity">
                                  @foreach($schedule as $s)
                                    @if($s->day_id == $i && $s->time == $t->time)
                                                  {{$s->activity}}
                                    @endif
                                  @endforeach
                                  </a>
                                          </td>
                              @endfor
                      </tr>
                  @endforeach
                @if(count($time) < 10)
                    @for($i = 0; $i < (10 - count($time)); $i++)
                        <tr>
                            <td id="column{{$i}}" class="td-time"><a href="#" class="link-time"></a></td>
                            @for($j = 1; $j < 8; $j++)
                                <td data-day="{{$j}}">
                                    <a href="#" class="link-activity">
                                    </a>
                                </td>
                            @endfor
                        </tr>
                    @endfor
                @endif
            </table>
        </div>
    </div>
  </div>
@endsection
