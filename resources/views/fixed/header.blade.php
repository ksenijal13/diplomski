    <div id="header" class="flex-element">
        <div id="logo" class="flex-element">
            <a href="{{url('/pocetna')}}"><div id="logo-image"><img src="{{asset('assets/img/logo.png')}}" alt="Logo"/></div></a>
            <a href="{{url('/pocetna')}}" id="logo-text">studentski planer</a>
        </div>
        @if(session()->has("user"))
          <div id="username-block" class="flex-element">
            <p>{{session('user')->username}}</p>
            <a id="sign-out" href="{{url("/logout")}}"><li class="fa fa-sign-out" id="sign-out" aria-hidden="true"></li></a>
          </div>
        @endif
    </div>
