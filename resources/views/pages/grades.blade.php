@extends('layouts.template')
@section('title')
    Ocene
@endsection
@section('main')
    <div id="content" class="flex-element">
        <div id="grades-wrapper">
            <div id="grades-header" class="flex-element">
                <div class="sort-grade">
                    <select id="sort-grade-list" data-list="grade">
                        <option value="0">Sortiraj po ocenama...</option>
                        <option value="asc">Od najniže ka najvišoj oceni</option>
                        <option value="desc">Od najviše ka najnižoj oceni</option>
                    </select>
                </div>
                <span id="average-grade">
                    <label>Prosek: {{$average}}</label>
                </span>
                <div class="sort-grade">
                    <select id="sort-grade-by-year-list" data-list="year">
                        <option value="0">Sortiraj po godini studija...</option>
                        <option value="asc">Od najniže ka najvišoj godini</option>
                        <option value="desc">Od najviše ka najnižoj godini</option>
                    </select>
                </div>
            </div>
            @if(count($subjectsGrades))
            <div id="grades">
                <form>
                    <table id="grades-table">
                        <tr id="grades-first">
                            <th>
                                Predmet
                            </th>
                            <th>
                                Godina studija
                            </th>
                            <th>
                                Profesor
                            </th>
                            <th>
                                Ocena
                            </th>
                        </tr>
                        @foreach($subjectsGrades as $sg)
                            <tr>
                                <td>
                                    {{$sg->subject_name}}
                                </td>
                                <td>
                                    {{$sg->name}} ({{$sg->alt}})
                                </td>
                                <td>
                                    {{$sg->professor}}
                                </td>
                                <td id="column{{$sg->subject_id}}">
                                    @if(empty($sg->grade))
                                        <select class="grades-list" data-id="{{$sg->subject_id}}">
                                            <option value="0" selected disabled>Ocena...</option>
                                            @foreach($grades as $grade)
                                                <option value="{{$grade->grade_id}}">{{$grade->grade}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        {{$sg->grade}} ({{$sg->grade_name}}) <a href="#" data-id="{{$sg->subject_id}}" class="edit-grade"><i class="fa fa-edit"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </form>
            </div>
            <div id="pagination-block">
                <?php $numberOfLinks = $total->number / 8 ?>
                <ul class="flex-element">
                    @for($i = 0; $i < $numberOfLinks; $i++)
                        <li>
                            @if($i == 0)
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}"  class="grades-pagination active">{{$i+1}}</a>
                            @else
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" class="grades-pagination">{{$i+1}}</a>
                            @endif
                        </li>
                    @endfor </ul>
            </div>
                @else
                <p id="none-subjects">Dodajte <a href="{{url('/predmeti')}}">predmete</a> kako biste dodali ocene.</p>
            @endif
        </div>
    </div>
  </div>
@endsection
