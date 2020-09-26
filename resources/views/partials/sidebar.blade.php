<div id="sidebar-content" class="flex-element">
    <div id="sidebar">
        <div id="profile" class="flex-element">
            <a href="{{url('/pocetna')}}">{{session('user')->first_name}} {{session('user')->last_name}}</a>
            <span id="profile-image"><a href="{{url('/pocetna')}}"><img src="{{asset('assets/img/student.png')}}" alt="Student image"/></a></span>
            <ul id="navigation">
                @foreach($menu as $link)
                    <li class="flex-element"><a href="{{url(''.$link->href)}}"><i class="{{$link->icon}}"></i><i class="link-text">{{$link->text}}</i></a></li>
                @endforeach
            </ul>
            <a href="{{url('/pocetna')}}" id="sidebar-logo">
                <div id="sidebar-image-logo">
                    <img src="{{asset('assets/img/logo.png')}}" alt="Logo"/>
                </div>
            </a>
            <span id="copyright">Copyright &copy; <a href="{{url('/pocetna')}}">Studentski planer</a></span>
        </div>
    </div>
