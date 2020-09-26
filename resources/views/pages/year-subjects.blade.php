@extends('layouts.template')
@section('title')
    Predmeti
@endsection
@section('main')
    <div id="content" class="flex-element">
        <div id="subjects-wrapper">
            <div id="subjects-header" class="flex-element">
                <div id="new-subject">
                    <a href="#" id="plus-link"><i class="fa fa-plus" aria-hidden="true"></i> Dodaj novi predmet</a>
                </div>
                <span id="link-back">
                    <a href="{{url('/predmeti')}}">Predmeti/</a>{{$year}}. godina
                </span>
                <div id="search-block">
                    <input type="search" id="search" placeholder="Pretraži ovde..." data-year="{{$year}}"/>
                </div>
                @if(session()->has('success'))
                    <div id="success-subject">
                        <p>Uspešno ste dodali novi predmet.</p><a href="#" id="close-success"><i class="fa fa-window-close"></i></a>
                    </div>
                @endif
                <div id="add-subject">
                    <form method="post" action="{{url('/add-subject')}}" onsubmit="return checkNewSubjectInfo();">
                        @csrf
                        <table id="new-subject-table">
                            <tr>
                                <td>
                                    Predmet:<input type="text" id="subject-name" name="subject-name"/>
                                    <input type="hidden" id="year" name="year" value="{{$year}}"/>
                                    <p class="user-error" id="subject-error"></p>
                                </td>
                                <td>
                                    Profesor: <input type="text" id="subject-professor" name="subject-professor"/>
                                    <p class="user-error" id="professor-error"></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Opis predmeta: <textarea id="subject-desc" name="subject-desc"></textarea>
                                    <p class="user-error" id="desc-error"></p>
                                </td>
                                <td>
                                    Termin ispita: <input type="date" id="final-date" name="final-date"/>
                                    <p class="empty-grey">***Ostaviti prazno ako se ne zna termin</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Broj kolokvijuma:
                                    <select id="exams-number">
                                        @for($i = 1; $i<5; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </td>
                               <td id="exams-date">
                                   1. kolokvijum termin: <input type="date" id="exam1" name="exam[]" class="exams-dates"/>
                                   <p class="empty-grey">***Ostaviti prazno ako se ne zna termin</p>
                               </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="td-flex"> <input type="submit" value="Upiši" name="btn-add-subject" id="btn-add-subject"/></span>
                                    @if(session()->has('message'))
                                    <p class="user-error">
                                        {{session('message')}}
                                    </p>
                                     @endif
                                </td>
                                <td>
                                    <span class="td-flex"> <button type="button" id="btn-cancel">Odustani</button></span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            @if(count($subjects))
            <table id="subjects-table">
                <tr id="subjects-h">
                    <th>
                        Predmet
                    </th>
                    <th>
                        Profesor
                    </th>
                    <th>
                        Opis predmeta
                    </th>
                    <th>
                        Termini kolokvijuma
                    </th>
                    <th>
                        Termin ispita
                    </th>
                </tr>
                @foreach($subjects as $subject)
                <tr id="row{{$subject->subject_id}}">
                    <td>
                        {{$subject->subject_name}}
                    </td>
                    <td>
                        {{$subject->professor}}
                    </td>
                    <td id="desc-column{{$subject->subject_id}}" class="td-desc">
                        <textarea id="new-desc" value="{{$subject->description}}">
                            {{$subject->description}}
                        </textarea><a href="#" class="add-new-desc" data-id="{{$subject->subject_id}}"><i class="fa fa-check"></i></a>
                        <p class="description">
                            {{$subject->description}}
                        </p>
                            <a href="#" class="show-desc-input" data-id="{{$subject->subject_id}}">
                            @if(empty($subject->description))
                                Dodaj opis
                                @else
                                Izmeni opis
                            @endif
                            </a>
                    </td>
                    <td id="column{{$subject->subject_id}}">
                        <ul class="exams-list">
                        @foreach($exams as $exam)
                            @if($subject->subject_id == $exam->subject_id)
                                    <li>{{$exam->exam_date}}</li>
                            @endif
                        @endforeach
                        </ul>
                                <a href="#" class="show-input" data-id="{{$subject->subject_id}}">Dodaj termin</a>
                    </td>
                    <td id="column-final{{$subject->subject_id}}">
                        @if(empty($subject->final_date))
                            <a href="#" class="show-final-input" data-id="{{$subject->subject_id}}">Dodaj termin</a>
                            @else
                            {{$subject->final_date}}
                        @endif
                    </td>
                </tr>
                 @endforeach
            </table>
            <div id="pagination-block">
                <?php $numberOfLinks = $total->number / 6 ?>
                <ul class="flex-element">
                    @for($i = 0; $i < $numberOfLinks; $i++)
                        <li>
                            @if($i == 0)
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" data-year="{{$year}}" class="s-pagination active">{{$i+1}}</a>
                               @else
                            <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" data-year="{{$year}}" class="s-pagination">{{$i+1}}</a>
                            @endif
                        </li>
                    @endfor </ul>
            </div>
                @else
                    <p id="none-subjects"> Nemate dodatih predmeta </p>
                @endif

        </div>
    </div>
    </div>
@endsection

