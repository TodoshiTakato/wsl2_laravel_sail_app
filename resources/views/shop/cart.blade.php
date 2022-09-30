@extends('shop.layout.base')

@section('content')
<div class="w-100-1 h-100-1">
    <section class="bg-success py-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5><a href="{{route('shop.index')}}" class="text-dark">Home</a> › Cart</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">

            @if(isset($cart_data))
                <div class="table-responsive">
                    <div class="col-12 text-right py-3">
                        <button type="button" id="clear_cart">
                            <i class="fa fa-trash-o"></i> Clear Cart
                        </button>
                    </div>
                    <table class="table table-bordered text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th class="cart-description">Image</th>
                                <th class="cart-product-name">Product Name</th>
                                <th class="cart-price">Price</th>
                                <th class="cart-qty">Quantity</th>
                                <th class="cart-total">Grandtotal</th>
                                <th class="cart-romove">Remove</th>
                            </tr>
                        </thead>
                        <tbody class="my-auto">
                            @foreach ($cart_data as $key => $value)@if($key != "total")
                                <tr id="cart_item_row">
                                    <td><a class="img-thumbnail" href="#">
                                        <img src="../assets/images/products/product_01.jpg" width="70px" alt="">
                                    </a></td>
                                    <td><h4>
                                        <a href="#">{{ $value["product_name"] }}</a>
                                    </h4></td>
                                    <td><span>
                                        {{ number_format($value["product_price"]/100, 2, ",", " ")." UZS" }}
                                    </span></td>
                                    <td>
                                        <input type="hidden" id="product_id" value="{{$value["product_id"]}}">
                                        <input type="number" min=1 max=100 step=1
                                               id="quantity" class="form-control"
                                               value="{{$value["item_quantity"]}}">
                                    </td>
                                    <td><span id="item_price">
                                        {{number_format($value["item_price"]/100, 2, ",", " ")." UZS" }}
                                    </span></td>
                                    <td style="font-size: 20px;">
                                        <button type="button" id="delete_from_cart_btn">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </button>
                                    </td>
                                </tr>@endif
                            @endforeach
                        </tbody>
                    </table><!-- /table -->
                </div>
                <div class="row mt-4">

                    <div class="col-8">
                        <div>
                            <a href="{{route("shop.products")}}" class="btn btn-upper btn-warning outer-left-xs">Continue Shopping</a>
                        </div>
                    </div><!-- /.estimate-ship-tax -->

                    <div class="col-4">
                        <div class="row">
                            <div class="col-6">
                                Subtotal
                            </div>
                            <div class="col-6">
                                <span id="subtotal_price">
                                    {{ number_format($cart_data["total"]/100, 2, ",", " ")." UZS" }}
                                </span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                Grand Total
                            </div>
                            <div class="col-6">
                                <span id="grand_price">
                                    {{ number_format($cart_data['total']/100, 2, ",", " ")." UZS" }}
                                </span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    @if (Auth::user())
                                        <a href="#" class="btn btn-success btn-block checkout-btn">
                                            PROCCED TO CHECKOUT
                                        </a>
                                    @else
                                        <a href="{{ route("getLogin") }}" class="btn btn-success btn-block checkout-btn">
                                            PROCCED TO CHECKOUT
                                        </a>
                                        {{-- you add a pop modal for making a login --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 mycard py-5 text-center">
                        <div class="mycards">
                            <h4>Your cart is currently empty.</h4>
                            <a href="{{route('shop.products')}}" class="btn btn-upper btn-primary outer-left-xs mt-5">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            @endif
        </div><!-- /.container -->
    </section>
</div>
@endsection
