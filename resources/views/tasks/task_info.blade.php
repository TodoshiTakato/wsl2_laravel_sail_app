@extends('layout.base')

@section('content1')
    <?php error_reporting(E_ALL); ?>
    @isset($task)
        <div class="card">
            <div class="card-header">
                Task info:
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">

                    <thead class="thead-dark">
                        <th class="col-3">Fields:</th>
                        <th class="col-9">Values:</th>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                id:
                            </td>
                            <td>
                                {{$task->id}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                name:
                            </td>
                            <td>
                                "{{$task->name}}"
                            </td>
                        </tr>
                        <tr>
                            <td>
                                details:
                            </td>
                            <td class="text-break">
                                "{{$task->details}}"
                            </td>
                        </tr>
                        <tr>
                            <td>
                                status:
                            </td>
                            <td>
                                {{$task->status}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                priority:
                            </td>
                            <td>
                                {{$task->priority}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                start_time:
                            </td>
                            <td>
                                {{$task->start_time}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                finish_time:
                            </td>
                            <td>
                                {{$task->finish_time}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                time_spent:
                            </td>
                            <td>
                                {{$task->time_spent}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                created_at:
                            </td>
                            <td>
                                {{$task->created_at}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                updated_at:
                            </td>
                            <td>
                                {{$task->updated_at}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Rating:
                            </td>
                            <td>
                                <div class="rate">
                                    <i id="star1" class="bi bi-star text-warning"></i>
                                    <i id="star2" class="bi bi-star text-warning"></i>
                                    <i id="star3" class="bi bi-star text-warning"></i>
                                    <i id="star4" class="bi bi-star text-warning"></i>
                                    <i id="star5" class="bi bi-star text-warning"></i>

                                @if($task->rating())
                                    {{$task->rating()}}
                                    <script>
                                        switch(Math.round({{$task->rating()}})) {
                                            case 1:
                                                star1.setAttribute('class', 'bi-star-fill text-warning');
                                                star2.setAttribute('class', 'bi-star text-warning');
                                                star3.setAttribute('class', 'bi-star text-warning');
                                                star4.setAttribute('class', 'bi-star text-warning');
                                                star5.setAttribute('class', 'bi-star text-warning');
                                                break;
                                            case 2:
                                                star1.setAttribute('class', 'bi-star-fill text-warning');
                                                star2.setAttribute('class', 'bi-star-fill text-warning');
                                                star3.setAttribute('class', 'bi-star text-warning');
                                                star4.setAttribute('class', 'bi-star text-warning');
                                                star5.setAttribute('class', 'bi-star text-warning');
                                                break;
                                            case 3:
                                                star1.setAttribute('class', 'bi-star-fill text-warning');
                                                star2.setAttribute('class', 'bi-star-fill text-warning');
                                                star3.setAttribute('class', 'bi-star-fill text-warning');
                                                star4.setAttribute('class', 'bi-star text-warning');
                                                star5.setAttribute('class', 'bi-star text-warning');
                                                break;
                                            case 4:
                                                star1.setAttribute('class', 'bi-star-fill text-warning');
                                                star2.setAttribute('class', 'bi-star-fill text-warning');
                                                star3.setAttribute('class', 'bi-star-fill text-warning');
                                                star4.setAttribute('class', 'bi-star-fill text-warning');
                                                star5.setAttribute('class', 'bi-star text-warning');
                                                break;
                                            case 5:
                                                star1.setAttribute('class', 'bi-star-fill text-warning');
                                                star2.setAttribute('class', 'bi-star-fill text-warning');
                                                star3.setAttribute('class', 'bi-star-fill text-warning');
                                                star4.setAttribute('class', 'bi-star-fill text-warning');
                                                star5.setAttribute('class', 'bi-star-fill text-warning');
                                                break;
                                            default:
                                                break;
                                        }
                                    </script>
                                @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="w-100 d-flex justify-content-around">
                                    @can('delete_task', $task)
                                    <form action="{{route('user.delete_a_task', $task->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        {{--                                        {{method_field('delete')}}--}}
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                            Delete
                                        </button>
                                    </form>
                                    @endcan
                                    @can('update_task', $task)
                                    <form action="{{route('user.task_form_page', $task->id)}}" method="GET">
                                        @csrf
                                        @method('GET')
                                        {{--                                        {{method_field('get')}}--}}
                                        <button type="submit" class="btn btn-dark">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
@endsection
