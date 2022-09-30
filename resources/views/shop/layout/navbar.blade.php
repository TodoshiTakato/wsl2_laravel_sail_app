<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- Header -->
<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{route('shop.index')}}"><h2>Sixteen <em>Clothing</em></h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{(request()->route()->getName()=='shop.index')?'active':''}}">
                        <a class="nav-link" href="{{route('shop.index')}}">Home</a>
                    </li>
                    <li class="nav-item {{(request()->route()->getName()=='shop.products')?'active':''}}">
                        <a class="nav-link" href="{{route('shop.products')}}">Our Products</a>
                    </li>
                    <li class="nav-item {{(request()->route()->getName()=='shop.cart')?'active':''}}">
                        <a class="nav-link" href="{{route('shop.cart')}}">Shopping Cart</a>
                    </li>
                    <li class="nav-item {{(request()->route()->getName()=='shop.about')?'active':''}}">
                        <a class="nav-link" href="{{route('shop.about')}}">About Us</a>
                    </li>
                    <li class="nav-item {{(request()->route()->getName()=='shop.contact')?'active':''}}">
                        <a class="nav-link" href="{{route('shop.contact')}}">Contact Us</a>
                    </li>
                    <a class="nav-link" href="{{route('main_page')}}">Back</a>
                </ul>
            </div>
        </div>
    </nav>
</header>
