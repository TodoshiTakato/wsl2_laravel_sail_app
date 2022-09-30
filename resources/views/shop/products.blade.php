@extends('shop.layout.base')

@section('content')
    <div class="page-heading products-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>new arrivals</h4>
                        <h2>our market's products</h2>
                        <h2 id="demo"></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="filters">
                        <ul>
                            <li class="active" data-filter="*">All Products</li>
                            <li data-filter=".des">Featured</li>
                            <li data-filter=".dev">Flash Deals</li>
                            <li data-filter=".gra">Last Minute</li>
{{--                            <li>Cart({{$order->order_items->count()}})</li>--}}
                            <li data-filter="*">
                                <a href="{{route('shop.cart')}}">Cart</a>
                                <span class="basket-item-count">
                                    <span class="badge badge-pill badge-danger"> (0) </span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="filters-content">
                        <div class="row grid">
                            {{--  des = FEATURED  --}}{{--  dev = FLASH DEALS  --}}{{--  gra = LAST MINUTE  --}}
                            @foreach($products as $product)
                                <div class="col-lg-4 col-md-4 all {{$class_array[array_rand($class_array)]}}">
                                    <div class="product-item">
                                        <a href="#">
                                            <img src={{$images_array[array_rand($images_array)]}} alt=""
                                                 style="max-height: 180px; min-height: 180px; object-fit: fill;">
                                        </a>
                                        <div class="down-content">
                                            <a href="#"><h4>{{$product->name}}</h4></a>
                                            <h6>{{number_format((($product->price)/100), 2, ",", " ") . " UZS"}}</h6>
                                            <p style="display: -webkit-box; max-width: 100%; height: 120px;
                                                      overflow: hidden; -webkit-line-clamp: 5; -webkit-box-orient: vertical; ">
                                                {{$product->description}}
                                            </p>
                                            <div class="buttons">
                                                {{--  @if ($order->order_items->where('product_id', $product->id)->count())--}}
                                                @if (isset($prod_id_list) && in_array($product->id, $prod_id_list))
                                                    <div class="d-flex justify-content-between item">
                                                        <button class="btn btn-primary btn-vsm disabled">
                                                            <i class="fas fa-shopping-cart fa-1x"></i>
                                                            Уже в корзине(
                                                                <div id="qty" class="d-inline">
                                                                    {{$cart_data[$product->id]["item_quantity"]}} штук
                                                                </div>
                                                            )
                                                        </button>
    {{--                                                    <button class="btn btn-primary btn-vsm disabled">--}}
    {{--                                                        <i class="fas fa-shopping-cart fa-1x"></i>--}}
    {{--                                                        Уже в корзине(--}}
    {{--                                                        <div id="qty" class="d-inline">--}}
    {{--                                                            {{$order->order_items->where('product_id', $product->id)->first()->quantity}}--}}
    {{--                                                        </div>--}}
    {{--                                                        )--}}
    {{--                                                    </button>--}}
                                                        {{--<form action="{{route('shop.add_to_cart', $product->id)}}" method="POST">--}}
                                                        {{--    @csrf()--}}
                                                        {{--    @method('POST')--}}
                                                        {{--    <button class="btn btn-success btn-vsm">--}}
                                                        {{--        <i class="fas fa-plus-square"></i>--}}
                                                        {{--    </button>--}}
                                                        {{--</form>--}}
                                                        <div id="product_data">
                                                            <input type="hidden" id="product_id" value="{{$product->id}}"> <!-- Your Product ID -->
                                                            {{--<input type="text" id="qty-input" value="1"> <!-- Your Number of Quantity -->--}}
                                                            <button id="add_another_one_btn" class="btn btn-success btn-vsm">
                                                                <i class="fas fa-plus-square"></i>
                                                            </button>
                                                        </div>
                                                        {{--<form action="{{route('shop.subtract_one_from_cart', $product->id)}}" method="POST">--}}
                                                        {{--    @csrf()--}}
                                                        {{--    @method('PUT')--}}
                                                        {{--    <button class="btn btn-danger btn-vsm">--}}
                                                        {{--        <i class="fas fa-minus-square"></i>--}}
                                                        {{--    </button>--}}
                                                        {{--</form>--}}
                                                        <div id="product_data">
                                                            <input type="hidden" id="product_id" value="{{$product->id}}"> <!-- Your Product ID -->
                                                            {{--<input type="text" id="qty-input" value="1"> <!-- Your Number of Quantity -->--}}
                                                            <button id="subtract_one_from_cart_btn" class="btn btn-danger btn-vsm">
                                                                <i class="fas fa-minus-square"></i>
                                                            </button>
                                                        </div>
                                                        {{--<form action="{{route('shop.remove_from_cart', $product->id)}}" method="POST">--}}
                                                        {{--    @csrf()--}}
                                                        {{--    @method('DELETE')--}}
                                                        {{--    <button class="btn btn-danger btn-vsm">--}}
                                                        {{--        <i class="fas fa-shopping-cart fa-1x"></i> Удалить--}}
                                                        {{--    </button>--}}
                                                        {{--</form>--}}
                                                        <div id="product_data">
                                                            <input type="hidden" id="product_id" value="{{$product->id}}"> <!-- Your Product ID -->
                                                            {{--<input type="text" id="qty-input" value="1"> <!-- Your Number of Quantity -->--}}
                                                            <button id="remove_from_cart_btn" class="btn btn-danger btn-vsm">
                                                                <i class="fas fa-shopping-cart fa-1x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{--<form action="{{route('shop.add_to_cart', $product->id)}}" method="POST">--}}
                                                    {{--    @csrf()--}}
                                                    {{--    @method('POST')--}}
                                                    {{--    <button class="btn btn-success">--}}
                                                    {{--        <i class="fas fa-cart-plus fa-1x"></i> Добавить в корзину--}}
                                                    {{--    </button>--}}
                                                    {{--</form>--}}
                                                    <div id="product_data">
                                                        <input type="hidden" id="product_id" value="{{$product->id}}"> <!-- Your Product ID -->
                                                        {{--<input type="text" id="qty-input" value="1"> <!-- Your Number of Quantity -->--}}
                                                        <button id="add_to_cart_btn" class="btn btn-success">
                                                            <i class="fas fa-cart-plus fa-1x"></i> Добавить в корзину
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <ul class="stars">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                            </ul>
                                            <span>Reviews (12)</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    {{$products->onEachSide(2)->links('layout.pagination-links')}}
                </div>
            </div>
        </div>
    </div>
@endsection
