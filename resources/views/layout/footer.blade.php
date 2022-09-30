<ul class="nav-bar">
    <li class="nav-item1"><a href="{{route('home')}}">Home</a></li>
    <li class="nav-item1"><a href="{{url()->previous()}}">Back</a></li>
    <li class="nav-item1">
        <div class="dropup1">
            <a href="#dropup" class="dropbtn">Dropup</a>
            <div class="dropup1-content">
                <a href="#">Link 1</a>
                <a href="#">Link 2</a>
                <a href="#">Link 3</a>
            </div>
        </div>
    </li>
</ul>

{{-- Alertify Notifications --}}
<script src="{{ asset("assets/js/alertify.min.js")}}"></script>

<script type="text/javascript">
    alertify.set("notifier","position","top-right");

    @if (session("success"))
    alertify.success("{{session("success")}}");
    @endif
    @if (session("error"))
    alertify.error("{{session("error")}}");
    @endif
</script>

{{-- Core JavaScript --}}
<script src="{{ asset("vendor/jquery/jquery-3.6.0.js")}}"></script>
<script src="{{ asset("vendor/jquery/dist/jquery.validate.js")}}"></script>

{{-- Auth System JavaScript --}}
<script src="{{ asset("js/auth/profile.js")}}"></script>

@stack('footer')
