@extends('layouts.no-header')
@section('title')
    Studentski planer - Prijava
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
                <form id="login-f" name="login-form">
                    @csrf
                    <table id="login-table">
                       <tr>
                           <th>Prijavi se na svoj nalog</th>
                       </tr>
                        <tr>
                            <td>
                                <input type="text" id="username" name="username" placeholder="Korisničko ime"/>
                                <p class="user-error" id="username-error"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" id="password" name="password" placeholder="Lozinka"/>
                                <p class="user-error" id="password-error"></p>
                                <p class="user-error" id="error-ajax"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="button" id="login" name="login">Prijavi se</button>
                            </td>
                        </tr>
                    </table>
                </form>
                <ul id="other-list">
                    <li id="pass-forgot"><a id="forget-password" href="{{url('/forget-password')}}">Zaboravljena lozinka?</a></li>
                    <li><a href="{{url('/register')}}">Nemaš nalog? Registruj se</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
