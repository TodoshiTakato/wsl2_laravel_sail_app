@extends('layout.base')

@section('content1')
    <?php error_reporting(E_ALL); ?>

    <div class="col">

        <div class="row">
            <div class="card-body">
                @include('tasks.errors')
            </div>
        </div>

        <div class="row">

            <div class="col-2">
                <a href="{{route('user.task_form_page')}}">
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-plus-square"></i>
                        Add task
                    </button>
                </a>
            </div>

        </div>

        @isset($tasks)
            <div class="card">
                <div class="card-header">
                    All tasks:
                </div>
                <div class="card-body">
                    <table class="table table-hover task-table table-bordered">

                        <thead class="thead-dark">
                            <th>Task:</th>
                            <th>Rate:</th>
                            <th>Rating:</th>
                            <th>Deletion:</th>
                            <th>Editing:</th>
                        </thead>

                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td class="col-md-4 text-break">
                                    <a href="{{route('user.task_info_page', $task->id)}}">{{$task->name}}</a>
                                </td>
                                <td class="col-md-2 text-break">
                                    <form action="{{route('user.rate_a_task', $task->id)}}" method="POST">
                                        @csrf @method('POST')
                                        <input type="radio" id="rating-1" name="rating" value=1>
                                        <input type="radio" id="rating-2" name="rating" value=2>
                                        <input type="radio" id="rating-3" name="rating" value=3>
                                        <input type="radio" id="rating-4" name="rating" value=4>
                                        <input type="radio" id="rating-5" name="rating" value=5>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-thumbs-up"></i>
                                            Rate
                                        </button>
                                    </form>
                                </td>
                                <td class="col-md-2">
                                    <div class="rate d-flex justify-content-between">
                                        <div>
                                        <i id="star_{{$loop->iteration=1}}" class="bi bi-star text-warning"></i>
                                        <i id="star_{{$loop->iteration+1}}" class="bi bi-star text-warning"></i>
                                        <i id="star_{{$loop->iteration+2}}" class="bi bi-star text-warning"></i>
                                        <i id="star_{{$loop->iteration+3}}" class="bi bi-star text-warning"></i>
                                        <i id="star_{{$loop->iteration+4}}" class="bi bi-star text-warning"></i>
                                        </div>
                                        @isset($task)
                                            <div>{{$rat = $task->rating()}}</div>

                                            <script>
                                                let rating = Math.round({{$rat}})
                                                function setStarRating(rating) {
                                                    switch(rating) {
                                                        case 1:
                                                            star_{{$loop->iteration}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+1}}.setAttribute('class', 'bi-star text-warning');
                                                            star_{{$loop->iteration+2}}.setAttribute('class', 'bi-star text-warning');
                                                            star_{{$loop->iteration+3}}.setAttribute('class', 'bi-star text-warning');
                                                            star_{{$loop->iteration+4}}.setAttribute('class', 'bi-star text-warning');
                                                            break;
                                                        case 2:
                                                            star_{{$loop->iteration}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+1}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+2}}.setAttribute('class', 'bi-star text-warning');
                                                            star_{{$loop->iteration+3}}.setAttribute('class', 'bi-star text-warning');
                                                            star_{{$loop->iteration+4}}.setAttribute('class', 'bi-star text-warning');
                                                            break;
                                                        case 3:
                                                            star_{{$loop->iteration}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+1}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+2}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+3}}.setAttribute('class', 'bi-star text-warning');
                                                            star_{{$loop->iteration+4}}.setAttribute('class', 'bi-star text-warning');
                                                            break;
                                                        case 4:
                                                            star_{{$loop->iteration}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+1}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+2}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+3}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+4}}.setAttribute('class', 'bi-star text-warning');
                                                            break;
                                                        case 5:
                                                            star_{{$loop->iteration}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+1}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+2}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+3}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            star_{{$loop->iteration+4}}.setAttribute('class', 'bi-star-fill text-warning');
                                                            break;
                                                        default:
                                                            break;
                                                    }
                                                }
                                                window.onload = function () {setStarRating(rating)};
                                            </script>
                                        @endisset
                                    </div>
                                </td>
                                <td class="col-md-2">
                                    @can('delete_task', $task)
                                    <form action="{{route('user.delete_a_task', $task->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
{{--                                        {{method_field('delete')}}--}}
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                            Delete
                                        </button>
                                    </form>
                                    @endcan
                                </td>

                                <td class="col-md-2">
                                    @can('update_task', $task)
                                    <form action="{{route('user.task_form_page', $task->id)}}" method="GET">
                                        <button type="submit" class="btn btn-dark">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$tasks->links()}}
                </div>
            </div>
        @endisset
    </div>
@endsection
