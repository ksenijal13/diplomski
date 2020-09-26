@extends('layouts.no-header')
@section('title')
    Promena lozinke
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

                    <form id="repeat-pass-form" name="repeat-pass-form" method="post" action="{{url('/edit-pass')}}" onsubmit="return checkNewPass();">
                        @csrf
                        <table id="login-table">
                            <tr>
                                <th>Unesite lozinku koju ćete lakše zapamtiti</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="password" id="password" name="password" placeholder="Lozinka"/>
                                    <p class="user-error" id="password-error">
                                        @if(session()->has("error"))
                                            Dogodila se greška. Molimo Vas, pokušajte kasnije.
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="password" id="repeat-password" name="repeat-password" placeholder="Ponovi lozinku"/>
                                    <p class="user-error" id="repeat-password-error">

                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" id="edit-password" name="edit-password" value="Potvrdi">
                                </td>
                            </tr>
                        </table>
                    </form>
            </div>
        </div>
    </div>
@endsection
