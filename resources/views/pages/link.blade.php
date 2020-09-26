@extends('layouts.template')
@section('title')
    Linkovi
@endsection
@section('main')
    <div id="content" class="flex-element">
        <div id="links-wrapper">
            <div id="new-link-block">
                <h2>Dodaj novi link</h2>
                <div id="new-link-btn" class="flex-element">
                    <form action="{{url('/add-link')}}" method="post" onsubmit="return checkLinkText();" name="form-link">
                        @csrf
                        <input type="text" id="new-link" name="new-link"/>
                        <input type="submit" id="add-link" name="add-link" value="Dodaj"/>
                        <p class="user-error" id="link-error"></p>
                    </form>
                </div>
                @if(session()->has('success'))
                    <div id="success-subject" class="element-center">
                        <p>Uspešno ste dodali novi koristan link.</p><a href="#" id="close-success"><i class="fa fa-window-close"></i></a>
                    </div>
                @endif
            </div>
            @if(count($links))
            <div id="links">
               <ul id="links-list" class="flex-element">
                   @foreach($links as $link)
                   <li>
                       <a href="{{$link->link}}" class="link-a">{{$link->link}}</a>
                       <a href="#" class="link-trash" data-id="{{$link->important_id}}">
                           <i class="fa fa-trash" aria-hidden="true"></i>
                       </a>
                   </li>
                   @endforeach
               </ul>
            </div>
            <div id="pagination-block">
                <ul class="flex-element">
                    @for($i = 0; $i < $total; $i++)
                        <li>
                            @if($i == 0)
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" class="link-pagination active">{{$i+1}}</a>
                            @else
                                <a href="#"  id = "link{{$i}}" data-offset="{{$i}}" class="link-pagination">{{$i+1}}</a>
                            @endif
                        </li>
                    @endfor </ul>
            </div>
                @else
                <p id="none-subjects">Trenutno nemate dodatih korisnih linkova</p>
            @endif
        </div>
    </div>
   </div>
@endsection

