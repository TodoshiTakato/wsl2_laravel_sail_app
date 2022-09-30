@extends('layout.base')

@section('content1')
    <div class="flex-center position-ref full-height">
        <div class="text-center1">
            <h1>{{ $product->name }}</h1>
            <ul>
                <li>
                    Product_id: {{ $product->id }}
                </li>
                <li>
                    Product_name: {{ $product->name }}
                </li>
                <li>
                    Product_description: {{ $product->description }}
                </li>
                <li>
                    Product_price: {{ $product->price }}
                </li>
                <li>
                    Product_status: {{ $product->status }}
                </li>
                <li>
                    Category_id: {{ $product->category_id }}
                </li>
                <li>
                    updated_at: {{ $product->updated_at }}
                </li>
                <li>
                    updated_at: {{ $product->updated_at }}
                </li>
            </ul>
            <h1><a href="{{route('user.get_products')}}">Назад</a></h1>
            <div class="big text-center1">
                <a href='{{route('main_page')}}'>Return to the main page</a>
            </div>
        </div>
    </div>
@endsection
