@extends('layout.base')

@section('content1')
    <div class="flex-center position-ref full-height">

        <div class="text-center1">   <!-- Wrapper -->


        @if (Route::has('getLogin'))   <!-- Authentication -->
            <div class="links d-flex justify-content-end">
                @auth
                    <a href="{{ route('home') }}">Home</a>
                @else
                    <a href="{{ route('getLogin') }}">Login</a>

                    @if (Route::has('getRegister'))
                        <a href="{{ route('getRegister') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif   <!-- Authentication -->


            <div class="cards">   <!-- Main Card in the center -->
                <div class="title m-b-md"> First Laravel App </div>   <!-- Logo Title -->

                <div class="links m-b-md"> <!-- Laravel Links -->
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> <!-- Laravel Links -->

                <div class="grid-container1 text-left1" style="grid-template-columns: auto auto auto auto auto;">    <!-- Hello world Links -->
                    <div><a href="/hello0000">1. /hello0000</a></div>
                    <div><a href="/hello0001">2. /hello0001</a></div>
                    <div><a href="/hello0002">3. /hello0002 Alex</a></div>
                    <div><a href="/hello0003">4. /hello0003 Smith</a></div>
                    <div><a href="/hello0004">5. /hello0003 John</a></div>
                    <div><a href="/hello_user">6. /hello_user</a></div>
                    <div><a href="/hello_user/some_variable">7. /hello_user/some_variable</a></div>
                    <div> {{-- style="grid-column: 2 / 4" --}}
                        <form action="/index.php" method="GET" autocomplete="on" id="var_form"
                              oninput=" let new_link = '/hello_user/'.concat(variable.value)
                                    link.value = new_link
                                    let myAnchor = document.getElementById('myAnchor');
                                    myAnchor.href = new_link">
                            @csrf
                            @method('GET')
                            <label for="variable">8. </label>
                            <input type="text" name="variable" id="variable" placeholder="Variable"
                                   size="10">

                            <a id="myAnchor" style="color: deeppink;"><output name="link" for="variable" form="var_form"></output></a>
                        </form>
                    </div>
                    <div><a href="{{route('layout')}}">layout page</a></div>
                    <div><a href="{{route('get_parsed_http')}}">HTTP Parser</a></div>
                    <div><a href="{{route('test')}}">Page for Testings</a></div>
                    <div><a href="{{route('getLogin')}}">Login Page</a></div>
                    <div><a href="{{route('user.tasks.tasks_main_page')}}">/tasks</a></div>
                    <div><a href="{{route('shop.index')}}">/shop</a></div>
                </div>  <!-- Hello world Links -->

                <br>
                <br>

                <div>
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <div class="h-100">
                                    <a class="big no-decoration d-block1" href="{{route('user.get_categories')}}">
                                        Categories:
                                    </a></div>
                            </td>
                            <td rowspan="2">
                                <a class="big no-decoration d-block1" href="{{route('user.get_products')}}">
                                    Products
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex1 justify-content-center align-items-center">
                                    <ul class="text-left1" style="line-height: 200%">
                                        @foreach($categories as $category)
                                            @if($category->parent_id == null)
                                                <li>
                                                    <a class="big no-decoration" href="http://127.0.0.1:8000/categories/{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>   <!-- Main Card in the center -->
        </div>   <!-- Wrapper -->
    </div>


@endsection
