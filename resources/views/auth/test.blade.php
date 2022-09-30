@extends('layout.base')

@section('content1')
    <?php error_reporting(E_ALL); ?>
    <div style="font-size: 96px; text-align: center; font-weight: 900;">Testing site</div>
    <div id="main" class="border border-dark w-90 h-80" style="margin: 0 auto;">
        <p>Mouse is at coordinates: <span id="spam"></span>.</p>
{{--        <input type="text" id="input">--}}
    </div>

    <script type="text/javascript">
        // function useDebounce(callback, delay) {
        //     let timeout;
        //     return (...args) => {
        //         clearTimeout(timeout);
        //         timeout = setTimeout(function () { callback.apply(this, args); }, delay);
        //     };
        // }
        // //                                                   Write your logic down here
        // window.addEventListener("mousemove", useDebounce(() => { console.log("Hi"); }, 1500) );
        // window.addEventListener("mousemove", () => {console.log("Hi")});
        document.getElementById("main").addEventListener("mousemove", () => {$("span").text(event.pageX + ", " + event.pageY);});

    </script>
@endsection
