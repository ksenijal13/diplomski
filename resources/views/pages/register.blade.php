@extends('layouts.no-header')
@section('title')
    Registracija
@endsection
@section('main')
    <div id="wrapper-register">
        <div id="register-main" class="flex-element">
            <div id="register-image">
                <img src="{{asset('assets/img/login-image.jpg')}}" alt="Register image"/>
            </div>
            <div id="register-form">
                <div id="logo-planer" class="flex-element">
                    <div id="logo-form"><img src="{{asset('assets/img/logo.png')}}" alt="Logo"/></div>
                    <h1>Studentski planer</h1>
                </div>
                <form id="register-f" name="register-form">
                    @csrf
                    <table id="register-table">
                        <tr>
                            <th>Registracija</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="first-name" name="first-name" placeholder="Ime"/>
                                <p class="user-error" id="first-name-error"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="last-name" name="last-name" placeholder="Prezime"/>
                                <p class="user-error" id="last-name-error"></p>
                            </td>
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
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" id="repeat-password" name="repeat-password" placeholder="Ponovi lozinku"/>
                                <p class="user-error" id="repeat-password-error"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="email" id="email" name="email" placeholder="E-mail"/>
                                <p class="user-error" id="email-error"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select id="gender">
                                    <option value="0">Izaberi pol</option>
                                    <option value="1">M</option>
                                    <option value="2">Ž</option>
                                </select>
                                <p class="user-error" id="gender-error"></p>
                                <p class="user-error" id="error-ajax"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="button" id="register" name="register">Registruj se</button>
                            </td>
                        </tr>
                    </table>
                </form>
                <ul id="other-list">
                    <li><a href="{{url('/')}}"><i class="fa fa-backward"></i> Povratak na prijavu.</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
