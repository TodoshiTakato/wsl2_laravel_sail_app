<ul class="nav-bar">
    <li class="nav-item1"><a href="{{route('home')}}">Home</a></li>
    <li class="nav-item1"><a href="{{route('main_page')}}">Main page</a></li>
    <li class="nav-item1">
        <div class="dropdown1">
            @guest
                <a href="#" class="dropbtn">Guest</a>
                <div class="dropdown1-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                    <a href="#">Link 4</a>
                    <a href="#">Link 5</a>
                    <a href="#">Link 6</a>
                </div>
            @elseif (Auth::check())
                <a href="#" class="dropbtn">{{Auth::user()->username}}</a>
                <div class="dropdown1-content">
                    <a href="#">id: {{Auth::user()->id}}</a>
                    <a href="#">name: {{Auth::user()->name}}</a>
                    <a href="#">username: {{Auth::user()->username}}</a>
                    <a href="#">email: {{Auth::user()->email}}</a>
                    <a href="#">email_verified_at: {{Auth::user()->email_verified_at}}</a>
                    <a href="#">created_at: {{Auth::user()->created_at}}</a>
                    <a href="#">updated_at: {{Auth::user()->updated_at}}</a>
                    <div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                            @method('POST')
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </li>
</ul>
