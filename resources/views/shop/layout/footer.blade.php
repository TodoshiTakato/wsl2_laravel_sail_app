<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner-content">
                    <p>
                        Copyright &copy; 2020 Sixteen Clothing Co., Ltd.
                        - Design: <a rel="nofollow noopener" href="https://templatemo.com" target="_blank">TemplateMo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset("vendor/jquery/jquery-3.6.0.js")}}"></script>
<script src="{{ asset("vendor/jquery/dist/jquery.validate.js")}}"></script>
<script src="{{ asset("vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>

<!-- Additional Scripts -->
<script src="{{ asset("assets/js/owl.js")}}"></script>
<script src="{{ asset("assets/js/slick.js")}}"></script>
<script src="{{ asset("assets/js/isotope.js")}}"></script>
<script src="{{ asset("assets/js/accordions.js")}}"></script>

<script src="{{ asset("assets/js/alertify.min.js")}}"></script>
<script>
    // global app configuration object GO TO CUSTOM.JS!!!
    var routes = {
        shop: {
            products: "{{route('shop.products')}}", {{-- // $.ajax({ url: routes.shop.products+"/"+product_id })--}}
            cart: {
                cart: "{{route('shop.cart')}}", {{-- // $.ajax({ url: routes.shop.cart.cart+"/update/"+product_id })--}}
                load_cart_data: "{{route('shop.cart.load_cart_data')}}", {{-- // $.ajax({ url: routes.shop.cart.load_cart_data })--}}
                clear_cart: "{{route('shop.cart.clear_cart')}}" {{-- // $.ajax({ url: routes.shop.products+"/"+product_id })--}}
            }
        }
    };
</script>
<script src="{{ asset("assets/js/custom.js")}}"></script>

<script language="text/javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
    function clearField(t){                   //declaring the array outside of the
        if(! cleared[t.id]){                      // function makes it static and global
            cleared[t.id] = 1;  // you could use true and false, but that's more typing
            t.value="";         // with more chance of typos
            t.style.color="#fff";
        }
    }
</script>



