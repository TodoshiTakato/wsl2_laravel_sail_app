@extends('layout.base')

@section('content1')
<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Структура страницы</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="wrapper">
    <div id="navbar">
        <div id="inner-navbar">
            @include('layout.nav-bar')
        </div>
    </div>

    <div class="clearfix flex-grow-1">
        <div id="sidebar1">
            <div id="inner-sidebar">
                <ul><li>The Flight</li><li>The City</li><li>The Island</li><li>The Food</li></ul>
            </div>
        </div>

        <div id="content">
            <div id="inner-content">
                <div class="title text-center1">
                    <h1>Content!!!</h1>
                </div>
                <table class="table table-bordered table-hover1">
                    <thead>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                    </thead>
                    <tbody>
                    <tr><td>5</td><td>4</td><td>3</td><td>2</td><td>1</td></tr>
                    <tr><td>4</td><td>5</td><td>4</td><td>3</td><td>2</td></tr>
                    <tr><td>3</td><td>4</td><td>5</td><td>4</td><td>3</td></tr>
                    <tr><td>2</td><td>3</td><td>4</td><td>5</td><td>4</td></tr>
                    <tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>
                    </tbody>
                </table>
                <div class="title text-center1">
                    <h1>Content!!!</h1>
                </div>
                <table class="table table-bordered table-hover1">
                    <thead>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    </thead>
                    <tbody>
                    <tr><td>5</td><td>4</td><td>3</td><td>2</td><td>1</td></tr>
                    <tr><td>4</td><td>5</td><td>4</td><td>3</td><td>2</td></tr>
                    <tr><td>3</td><td>4</td><td>5</td><td>4</td><td>3</td></tr>
                    <tr><td>2</td><td>3</td><td>4</td><td>5</td><td>4</td></tr>
                    <tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>
                    </tbody>
                </table>
                <div class="big text-center1">
                    <h1>Content!!!</h1>
                    <a href='/'>Return to the main page</a>
                </div>
            </div>
        </div>

        <div id="sidebar2">
            <div id="inner-sidebar">
                <ul><li>The Flight</li><li>The City</li><li>The Island</li><li>The Food</li></ul>
            </div>
        </div>
    </div>

    <div id="footer">
        <div id="inner-footer">
            @include('layout.footer')
        </div>
    </div>
</div>
</body>
</html>

@endsection
