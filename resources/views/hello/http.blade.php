@extends('layout.base')

@section('content1')
    @isset($collection)
        <h1 class="text-center1"><a href="{{route('get_raw_http')}}">Show RAW data</a></h1>
        <h1 class="text-center1">User List:</h1>
        <table class="table table-primary">
            @foreach($collection as $item)
                <tr>
                    <td>{{$item['id']}}</td>
                    <td>{{$item['first_name']}}</td>
                    <td>{{$item['last_name']}}</td>
                    <td>{{$item['email']}}</td>
                    <td><img src="{{$item['avatar']}}"/></td>
                </tr>
            @endforeach
        </table>
        <div class="big text-center1">
            <a href='/'>Return to the main page</a>
        </div>
    @endisset
    @isset($raw_http)
        {{$raw_http}}
    @endisset
@endsection
