@extends('layouts.admin-template')
@section('title')
    Admin - Početna stranica
@endsection
@section('main')
    <div id="admin-main" class="flex-element">
        <div class="admin-block">
            <h3>Users</h3>
            <table id="users-table">
               <tr class="first-row">
                   <th>
                       Ime
                   </th>
                   <th>
                       Prezime
                   </th>
                   <th>
                       Username
                   </th>
                   <th>
                       Email
                   </th>
                   <th>
                       <i class="fa fa-edit"></i>
                   </th>
               </tr>
                @foreach($users as $u)
                    <tr>
                        <td>
                            {{$u->first_name}}
                        </td>
                        <td>
                            {{$u->last_name}}
                        </td>
                        <td>
                            {{$u->username}}
                        </td>
                        <td>
                            {{$u->email}}
                        </td>
                        <td>
                            <a href="#" data-id="{{$u->user_id}}" class="delete-user">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                 @endforeach
            </table>
            <div class="admin-pagination" id="user-pagination">
                <ul class="flex-element" id="user-list">
                    @for($i = 0; $i < $total; $i++)
                        <li>
                            @if($i == 0)
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" class="user-pagination active">{{$i+1}}</a>
                            @else
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" class="user-pagination">{{$i+1}}</a>
                            @endif
                        </li>
                    @endfor </ul>
            </div>
        </div>
        <div class="admin-block">
            <h3>Meni</h3>
            <table id="menu-table">
                <tr class="first-row">
                    <th>
                        Tekst
                    </th>
                    <th>
                        Putanja linka
                    </th>
                    <th>
                        Ikonica
                    </th>
                    <th>
                        <i class="fa fa-edit"></i>
                    </th>
                </tr>
                    @foreach($menu as $m)
                        <tr>
                            <td>
                                {{$m->text}}
                            </td>
                            <td>
                                {{$m->href}}
                            </td>
                            <td>
                                {{$m->icon}}
                            </td>
                            <td>
                                <a href="#" data-id="{{$m->link_id}}" class="delete-link">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                                <a href="#" data-id="{{$m->link_id}}" class="update-icon" data-text="{{$m->text}}" data-href="{{$m->href}}" data-icon="{{$m->icon}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>

                    @endforeach
            </table>
            <div class="admin-pagination" id="menu-pagination">
                <ul class="flex-element" id="menu-list">
                    @for($i = 0; $i < $totalLinks; $i++)
                        <li>
                            @if($i == 0)
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" class="menu-pagination active">{{$i+1}}</a>
                            @else
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" class="menu-pagination">{{$i+1}}</a>
                            @endif
                        </li>
                    @endfor </ul>
            </div>
            <div id="update-block">
                <form method="post" action="{{url('/update-link')}}" onsubmit=" return checkUpdateLink();">
                    @csrf
                    <table id="update-table">

                    </table>
                </form>
            </div>
            <div id="new-link">
                <a href="#" id="add-menu-link"><i class="fa fa-plus" aria-hidden="true"></i>Dodaj novi link</a>
                @if(session()->has('success'))
                    <div id="success-subject" class="link-message">
                        <p>{{ session()->get("success") }}</p><a href="#" id="close-success"><i class="fa fa-window-close"></i></a>
                    </div>
                @endif
                <form method="post" action="{{url('/add-menu-link')}}" onsubmit="return checkAddLink();">
                    @csrf
                    <table id="add-link-table">
                        <tr class="first-row">
                            <th>
                                Tekst
                            </th>
                            <th>
                                Putanja
                            </th>
                            <th>
                                Ikonica
                            </th>
                            <th>
                                <i class="fa fa-edit"></i>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="link-text" name="link-text"/>
                                <p class="user-error link-error" id="link-text-error"></p>
                            </td>
                            <td>
                                <input type="text" id="link-path" name="link-path"/>
                                <p class="user-error link-error" id="link-path-error"></p>
                            </td>
                            <td>
                                <input type="text" id="link-icon" name="link-icon"/>
                                <p class="user-error link-error" id="link-icon-error"></p>
                            </td>
                            <td class="flex-element">
                                <input type="submit" id="btn-add-link" name="btn-add-link" value="Dodaj"/>
                                <a href="#" id="close-link-table"><i class="fa fa-window-close"></i></a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
