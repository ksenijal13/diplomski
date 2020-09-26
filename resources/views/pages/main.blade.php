@extends('layouts.template')
@section('title')
    Studentski planer - Početna
@endsection
@section('main')
    <div id="content-main" class="flex-element">
        <div id="student-info" class="flex-element">
            <div id="about-student">
                <div id="student-image">
                    <div id="round-image">
                        <img src="{{asset('assets/img/student.png')}}" alt="Student image"/>
                    </div>
                    <p>{{$userData->username}}</p>
                </div>
                <form id="student-form" action="{{url('/update-student-info')}}" onsubmit="return checkStudentInfo();" method="post">
                    @csrf
                <table id="student-info-table">
                    <tr>
                        <td>
                            <label>Student: </label> {{$userData->first_name}} {{$userData->last_name}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Fakultet: </label>
                            @if(empty($userData->university))
                                <input type="text" placeholder="University" id="university" name="university"/>
                                <p class="user-error" id="university-error"></p>
                                @else {{$userData->university}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Smer: </label>
                            @if(empty($userData->module))
                                <input type="text" placeholder="Smer" id="module" name="module"/>
                                <p class="user-error" id="module-error"></p>
                            @else {{$userData->module}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Godina studija: </label>
                            <select id="year-of-study">
                                @if(empty($userData->year_of_study))
                                    <option selected disabled value="0">Izaberi...</option>
                                @endif
                                @for($i = 1; $i <= 6; $i++)
                                    @if($userData->year_of_study == $i)
                                            <option selected value="{{$i}}">{{$i}}</option>
                                     @else
                                            <option value="{{$i}}">{{$i}}</option>
                                     @endif
                                @endfor
                            </select>
                        </td>
                    </tr>
                    @if(empty($userData->university) || empty($userData->year_of_study) || empty($userData->module))
                    <tr>
                        <td class="flex-element" id="td-btn">
                            <input type="submit" id="btn-update-student" value="Submit" name="btn-update-student"/>
                            @if(session()->has('message'))
                                <p class="user-error">{{session('message')}}</p>
                            @endif
                        </td>
                    </tr>
                    @endif
                </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
