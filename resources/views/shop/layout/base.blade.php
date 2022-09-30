<!DOCTYPE html>
<html lang="en">

  <head>
    @include('shop.layout.header')
  </head>

  <body>
    @include('shop.layout.navbar')

    <!-- Page Content -->
    @yield('content')

    @include('shop.layout.footer')
  </body>

</html>
