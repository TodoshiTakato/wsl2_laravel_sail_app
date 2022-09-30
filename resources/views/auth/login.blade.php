@extends('layout.base')
@push('header')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>    {{-- reCaptcha --}}
@endpush
@push('footer')
    {{-- Auth System JavaScript --}}
    <script src="{{ asset("js/auth/auth.js")}}"></script>
@endpush
@section('content1')
    <?php error_reporting(E_ALL); ?>
    <div class="grid-container h-100">
        <div></div> {{-- 1 --}}
        <div></div> {{-- 2 --}}
        <div></div> {{-- 3 --}}
        <div></div> {{-- 4 --}}
        <div> {{-- 5 - center-start --}}
            <div class="d-block w-100-1 h-25">
                @if (Route::has('getLogin'))   <!-- Authentication -->
                    <div class="d-flex justify-content-between">
                        @auth
                            <div><a href="{{ route('home') }}">Home</a></div>
                        @else
                            <div><a href="{{ route('getLogin') }}">Login</a></div>

                            @if (Route::has('getRegister'))
                                <div><a href="{{ route('getRegister') }}">Register</a></div>
                            @endif
                        @endauth
                    </div>
                @endif   <!-- Authentication -->
                </div>
            <div class="w-50 flex-grow-1 align-items-center">
                <div class="text-center"><h1>Login page</h1></div>
                <br>

                @include('auth.auth_errors')

                <form action="{{route('postLogin')}}" method="POST" id="login_form">
                    @csrf
                    @method('POST')
                    <div class="form-group row align-items-center">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required
                                   data-href="{{route('check_username_unique')}}" placeholder="Username or E-mail" autofocus
                                   autocomplete="username" class="form-control text-center1 @error('username') is-invalid @enderror">
                            @error('username') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                        <div class="col-md-6">
                            <input type="password" id="password" name="password" value="{{ old('password') }}" required
                                   placeholder="Password" class="form-control text-center1">
                            @error('password') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <div class="col-3"></div>
                        <div class="col-7">
                            <div class="g-recaptcha" data-sitekey="{{config('recapcha.GOOGLE_CAPTCHA_KEY')}}"
                                 data-callback="recaptchaDataCallbackLogin"
                                 data-expired-callback="recaptchaExpireCallbackLogin">
                            </div>
                        <input type="hidden" name="grecaptcha" id="hiddenInputRecaptchaLogin">
                        @error('grecaptcha')
                            <div class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                        <strong id="LoginRecaptchaErrorDiv"></strong>
                        </div>
                        <div class="col-2"></div>
                    </div>

                    <div class="row align-items-center text-nowrap w-100 h-100">

                        <div class="col">
                            <a href="#">Forgot password?</a>
                        </div>

                        <div class="col text-center1">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>

                        <div class="col text-right">
                            <a href="{{ route('getRegister') }}">Register</a>
                        </div>
                    </div>

                </form>
            </div>
            <div class="h-25">
            </div>
        </div> {{-- 5 - center-end --}}
        <div></div> {{-- 6 --}}
        <div></div> {{-- 7 --}}
        <div></div> {{-- 8 --}}
        <div></div> {{-- 9 --}}
    </div>

@endsection
