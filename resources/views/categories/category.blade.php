@extends('layout.base')

@section('content1')
    <div class="flex-center position-ref full-height">
            @if($category->parent_id == null)
        <div>
                <h3>{{$category->name}}: </h3>
                <ul>
                    @php $counter = 1; @endphp
                    @for($i = 0; $i < count($categories); $i++)
                        @if($category->id == $categories[$i]->parent_id)
                            <li>
                                <a href="{{route('user.get_category', $categories[$i]->id)}}">
                                {{ $counter }} {{$categories[$i]->name}}</a>
                                <br>
                            </li>
                            @php $counter=$counter; $counter++; @endphp
                        @endif
                    @endfor
                </ul>
                <h3><a href="{{route('user.get_categories')}}">Назад</a></h3>
            @else
        <div class="text-center1">
                <h3>{{ $category->name }}</h3>
                <ul>
                    <li>
                        Сategory_id: {{ $category->id }}
                    </li>
                    <li>
                        Parent_id: {{ $category->parent_id }}
                    </li>
                    <li>
                        Сategory_name: {{ $category->name }}
                    </li>
                    <li>
                        created_at: {{ $category->created_at }}
                    </li>
                    <li>
                        updated_at: {{ $category->updated_at }}
                    </li>
                </ul>
                <h3><a href="{{route('user.get_category', $category->parent_id)}}">Назад</a></h3>
            @endif
            <div class="big text-center1">
                <a href='{{route('main_page')}}'>Return to the main page</a>
            </div>
        </div>
    </div>
@endsection
