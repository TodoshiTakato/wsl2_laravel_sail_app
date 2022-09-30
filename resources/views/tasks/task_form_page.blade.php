@extends('layout.base')

@section('content1')
    <?php error_reporting(E_ALL); ?>

    <div class="col">

        <div class="row">
            <div class="card-body">
                @include('tasks.errors')
            </div>
        </div>
    @isset($found_task)
        <div class="row big text-center1">
            TASK UPDATE PAGE
        </div>
    @endisset
    @if(!isset($found_task))
        <div class="row big text-center1">
            TASK CREATE PAGE
        </div>
    @endif

        <div class="row">
            @isset($found_task)
            <form action="{{route('user.update_a_task', $found_task->id)}}" method="POST"
                  id="task_info" class="col">
                @method('PUT') {{--  {{method_field('put')}}  --}}
            @endisset
            @if(!isset($found_task))
            <form action="{{route('user.post_a_task')}}" method="POST"
                  id="task_info" class="col">
                @method('POST') {{--  {{method_field('put')}}  --}}
            @endif
                @csrf
                <div class="row form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" @isset($found_task) value="{{$found_task->name}}" @endisset
                           class="form-control @error('name') is-invalid @enderror">
                    @error('task')<div class="invalid-feedback"><strong>{{$message}}</strong></div>@enderror
                </div>
                <div class="row form-group">
                    <label for="details">Details:</label>
                    <input type="text" id="details" name="details" @isset($found_task) value="{{$found_task->details}}" @endisset
                           class="form-control @error('details') is-invalid @enderror">
                    @error('details')<div class="invalid-feedback"><strong>{{$message}}</strong></div>@enderror
                </div>
                <div class="row"> {{-- Status / Priority / Rating / Hello (Start) --}}
                    <div class="w-30 input-group justify-content-between align-items-center"> {{-- Status (Start) --}}
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="status">Status:</label>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" id="status" name="status" value=1
                                   class="form-control @error('status') is-invalid @enderror">
                            @isset($found_task->status)
                                <script>
                                    if( {{$found_task->status}} === 1) {
                                        document.getElementById("status").checked = true;
                                    } else if ( typeof {{$found_task->status}} !== "undefined" && {{$found_task->status}} !== null || {{$found_task->status}} === 0) {
                                        document.getElementById("status").checked = false;
                                    }
                                </script>
                            @endisset
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                (<i class="fas fa-check-square text-primary"></i> - Done,
                                &nbsp;<i class="far fa-square"></i> - Not Done)
                            </span>
                        </div>
                        @error('status')<div class="invalid-feedback"><strong>{{$message}}</strong></div>@enderror
                    </div>  {{-- Status (End) --}}
                    <div class="w-2">
                    </div>
                    <div class="w-25 input-group justify-content-between align-items-center"> {{-- Priority (Start) --}}
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="priority">Priority:</label>
                        </div>
                        <div class="px-2">
                            <input type="range" id="priority" name="priority"
                                   min=0 max=5 step=1 oninput="priority_output.value = this.value"
                                   class="form-control @error('priority') is-invalid @enderror">
                            @isset($found_task)
                                <script>
                                    document.getElementById("priority").value = "{{$found_task->priority}}";
                                </script>
                            @endisset
                            @if(!isset($found_task))
                                <script>
                                    document.getElementById("priority").value = 0;
                                </script>
                            @endif
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <output id="priority_output" name="priority_output" for="priority" style="font-size: 24px;">
                                    @isset($found_task){{$found_task->priority}}@endisset
                                    @if(!isset($found_task)) 0 @endif
                                </output>
                            </span>
                        </div>
                        @error('priority')<div class="invalid-feedback"><strong>{{$message}}</strong></div>@enderror
                    </div> {{-- Priority (End) --}}
                    <div class="w-2">
                    </div>
                    <div class="w-20 input-group justify-content-between align-items-center"> {{-- Rating (Start) --}}
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="rating">
                                Rating: @isset($found_task){{$rat = $found_task->rating()}}@endisset
                            </label>
                        </div>
                        <table class="table table-bordered">
                            <thead><tr><th class="p-0">1</th><th class="p-0">2</th><th class="p-0">3</th><th class="p-0">4</th><th class="p-0">5</th></tr></thead>
                            <tbody>
                            <tr>
                                <td class="p-0"><input type="radio" id="rating-1" name="rating" value=1
                                                       onclick="setStarRating(this.value);"></td>
                                <td class="p-0"><input type="radio" id="rating-2" name="rating" value=2
                                                       onclick="setStarRating(this.value);"></td>
                                <td class="p-0"><input type="radio" id="rating-3" name="rating" value=3
                                                       onclick="setStarRating(this.value);"></td>
                                <td class="p-0"><input type="radio" id="rating-4" name="rating" value=4
                                                       onclick="setStarRating(this.value);"></td>
                                <td class="p-0"><input type="radio" id="rating-5" name="rating" value=5
                                                       onclick="setStarRating(this.value);">
                                @error('rating')<div class="invalid-feedback"><strong>{{$message}}</strong></div>@enderror
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0"><i id="star1" class="bi bi-star text-warning"></i></td>
                                <td class="p-0"><i id="star2" class="bi bi-star text-warning"></i></td>
                                <td class="p-0"><i id="star3" class="bi bi-star text-warning"></i></td>
                                <td class="p-0"><i id="star4" class="bi bi-star text-warning"></i></td>
                                <td class="p-0"><i id="star5" class="bi bi-star text-warning"></i></td>
                            </tr>
                            </tbody>

                        </table>
                        <script>
                            @isset($found_task)
                                let rating = Math.round({{$rat}});
                                document.getElementById("rating-"+rating).checked = true;
                            @endisset
                            function setStarRating(rating) {
                                switch(parseInt(rating)) {
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
                            }
                            @isset($found_task)
                                window.onload = function () {setStarRating(rating)};
                            @endisset
                        </script>
                    </div>  {{-- Rating (End) --}}
                    <div class="w-1">
                    </div>
                    <div class="w-20 text-center1">
                        Hello
                    </div>
                </div>  {{-- Status / Priority / Rating / Hello (End) --}}
                <div class="row row-cols-3">   {{-- Start_time (Start) --}}
                    <div class="col-6 pl-0">
                        <div class="row input-group">
                            <div class="col-3 px-0 input-group-prepend">
                                <label class="input-group-text" for="start_time">Start time:</label>
                            </div>
                            <div class="col-9 px-0">
                                <input type="datetime-local" id="start_time" name="start_time" @isset($found_task) value="{{$found_task->start_time}}" @endisset
                                       class="form-control @error('start_time') is-invalid @enderror" step="1">
                                @error('start_time')<div class="invalid-feedback"><strong>{{$message}}</strong></div>@enderror
                            </div>
                        </div>   {{-- Start_time (End) --}}
                        <div class="row input-group">   {{-- Finish_time (Start) --}}
                            <div class="col-3 px-0 input-group-prepend">
                                <label class="input-group-text" for="finish_time">Finish time:</label>
                            </div>
                            <div class="col-9 px-0">
                                <input type="datetime-local" id="finish_time" name="finish_time" @isset($found_task) value="{{$found_task->finish_time}}" @endisset
                                       class="form-control @error('finish_time') is-invalid @enderror"  step="1">
                                @error('finish_time')<div class="invalid-feedback"><strong>{{$message}}</strong></div>@enderror
                            </div>
                        </div>   {{-- Finish_time (End) --}}
                        <div class="row input-group">   {{-- Time_spent (Start) --}}
                            <div class="col-3 px-0 input-group-prepend">
                                <label class="input-group-text" for="time_spent">Time spent:</label>
                            </div>
                            <div class="col-9 px-0">
                                <input type="number" id="time_spent" name="time_spent" @isset($found_task) value="{{$found_task->time_spent}}" @endisset
                                       step="1" class="form-control @error('time_spent') is-invalid @enderror">
                                @error('time_spent')<div class="invalid-feedback"><strong>{{$message}}</strong></div>@enderror
                            </div>
                        </div>   {{-- Time_spent (End) --}}
                    </div>
                    <div class="col-6 p-1">
                        <textarea id="comment" name="comment" rows="8" cols="65"
                                  placeholder="Write Some Nice Comment">@isset($found_task) @isset($found_task->ratings->first()->comment){{$found_task->ratings->first()->comment}} @endisset @endisset</textarea>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col text-center1">
                        @isset($found_task)
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i>
                                Save changes
                            </button>
                        @endisset
                        @if(!isset($found_task))
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                Add task
                            </button>
                        @endif
                    </div>
                </div>
            @isset($found_task)</form>@endisset
            @if(!isset($found_task))</form>@endif
        </div>

    </div>

@endsection
