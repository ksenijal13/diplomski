@extends('layouts.template')
@section('title')
    Predmeti
@endsection
@section('main')
    <div id="content" class="flex-element">
        <div id="info-wrapper" class="flex-element">
            @foreach($years as $year)
                <a href="{{url('godina-predmeti/'.$year->year_id)}}">
                @if($year->year_id == $userData->year_of_study)
                    <div class="year-link" id="current-year">
                        <img src="{{asset('/assets/img/'.$year->image)}}" alt="{{$year->alt}}"/>
                        <p>{{$year->name}} godina</p>
                    </div>
                    @else
                    <div class="year-link">
                        <img src="{{asset('/assets/img/'.$year->image)}}" alt="{{$year->alt}}"/>
                        <p>{{$year->name}} godina</p>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
    </div>
  </div>
@endsection
