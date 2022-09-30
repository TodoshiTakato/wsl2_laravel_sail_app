<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('layout.header')
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
                        @section('content1')
                            This is the master content.
                        @show
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

