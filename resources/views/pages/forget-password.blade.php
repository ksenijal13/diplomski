@extends('layouts.no-header')
@section('title')
    Zaboravljena lozinka
@endsection
@section('main')
    <div id="wrapper-login">
        <div id="login-main" class="flex-element">
            <div id="login-image">
                <img src="{{asset('assets/img/login-image.jpg')}}" alt="Login image"/>
            </div>
            <div id="login-form">
                <div id="logo-planer" class="flex-element">
                    <div id="logo-form"><img src="{{asset('assets/img/logo.png')}}" alt="Logo"/></div>
                    <h1>Studentski planer</h1>
                </div>
                @if(session()->has("success"))
                    <form id="mail-pass-form" name="mail-pass-form" method="post" action="{{url('/check-pass')}}" onsubmit="return checkPass();">
                        @csrf
                        <table id="login-table">
                            <tr>
                                <th>Lozinka koja je poslata na Vaš mejl</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="password" id="mail-password" name="mail-password" placeholder="Lozinka sa mejla"/>
                                    <p class="user-error" id="pass-error">
                                        @if(session()->has("incorrect"))
                                            Lozinka se ne poklapa sa lozinkom koja Vam je poslata na mail.
                                            @endif

                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" id="check-password" name="check-password" value="Potvrdi">
                                </td>
                            </tr>
                        </table>
                    </form>
                    @else
                <form id="forget-form" name="forget-form" method="post" action="{{url('/regain-access')}}" onsubmit="return checkEmail();">
                    @csrf
                    <table id="login-table">
                        <tr>
                            <th>Povrati svoj nalog</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="email" name="email" placeholder="Email"/>
                                <p class="user-error" id="email-error"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" id="regain-access" name="regain-access" value="Potvrdi">
                            </td>
                        </tr>
                    </table>
                </form>
                    @endif
            </div>
        </div>
    </div>
@endsection
