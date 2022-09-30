{{--@if($errors->any())--}}
{{--@endif--}}
@if(session('error_rate_a_task'))
    <div class="alert alert-danger">
        <strong>
            Произошёл большой взрыв...
        </strong>
        <ul>
            <li>{{session('error_rate_a_task')}}</li>
        </ul>
    </div>
@endif
@if(count($errors)>0)
    <div class="alert alert-danger">
        <strong>
            Произошёл большой взрыв...
        </strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
