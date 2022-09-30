@extends('layout.base')

@section('content1')
    <?php error_reporting(E_ALL); ?>
    <div class="grid-container">
        <div></div> {{-- 1 --}}
        <div></div> {{-- 2 --}}
        <div></div> {{-- 3 --}}
        <div></div> {{-- 4 --}}
        <div> {{-- 5 - center --}}

            <div class="h-100-1 w-100-1">
                <ul class="nav-bar justify-content-between" style="background-color: #4691d5;">
                    <li class="nav-item1">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a></li>
                    <li class="nav-item1">
                        <div class="dropdown1">
                            <a href="#" class="dropbtn">{{Auth::user()->username}}</a>
                            <div class="dropdown1-content">
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
                        </div>
                    </li>
                </ul>
            </div>

            @isset(Auth::user()->id)

                <div class="container">
                    <h2>Welcome, {{Auth::user()->first_name}}!</h2>
                    <div class="card">

                        <div class="card-header">
                            Username: {{Auth::user()->username}}
                        </div>

                        <div class="card-body">
                            <table class="table table-hover task-table table-bordered">

                                <thead class="thead-dark">
                                <th>Key:</th>
                                <th>Value:</th>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>ID</td><td>{{Auth::user()->id}}</td>
                                    </tr>
                                    <tr>
                                        <td>First Name</td><td>{{Auth::user()->first_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Username</td><td>{{Auth::user()->username}}</td>
                                    </tr>
                                    <tr>
                                        <td>E-Mail</td><td>{{Auth::user()->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>E-Mail verified at</td><td>{{Auth::user()->email_verified_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Password:</td><td>{{Auth::user()->password}}</td>
                                    </tr>
                                    <tr>
                                        <td>Remember Token:</td><td>{{Auth::user()->remember_token}}</td>
                                    </tr>
                                    <tr>
                                        <td>Created at:</td><td>{{Auth::user()->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Updated at:</td><td>{{Auth::user()->updated_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Auth::viaRemember():</td><td>@dump(\Illuminate\Support\Facades\Auth::viaRemember())</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                                @method('POST')
                            </form>
                        </div>
                    </div>
                </div>

            @else
                <script>
                    {{--window.location = "{{route('getLogin')}}";--}}
                </script>
            @endisset

            @isset($data)
            @foreach($data as $key => $value)
                {{$key}}: {{$value}}<br>
            @endforeach
            @endisset

        </div> {{-- 5 - center --}}
        <div></div> {{-- 6 --}}
        <div></div> {{-- 7 --}}
        <div></div> {{-- 8 --}}
        <div></div> {{-- 9 --}}
    </div>

@endsection
