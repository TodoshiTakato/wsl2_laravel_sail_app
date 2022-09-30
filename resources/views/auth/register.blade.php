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
    <div class="grid-container">
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
            <div class="w-15"></div>
            <div class="w-85 flex-grow-1 align-items-center">
                <div class="big text-center">Register page</div>
                <br>

                @include('auth.auth_errors')

                <form action="{{route('postRegister')}}" method="POST" class="w-100-1"
                      id="registration_form" data-login-href="{{route("getLogin")}}">
                    @csrf
                    @method('POST')
                    <div class="form-group row align-items-stretch w-100-1">
                        <label for="name" class="col-5 col-form-label text-md-right">
                            {{ __('First name') }}
                        </label>
                        <div class="col-5">
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus
                                   class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name">
                            @error('first_name')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row align-items-stretch w-100-1">
                        <label for="name" class="col-5 col-form-label text-md-right">
                            {{ __('Last name') }}
                        </label>
                        <div class="col-5">
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                                   class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name">
                            @error('last_name')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row align-items-stretch w-100-1">
                        <label for="username" class="col-5 col-form-label text-md-right">
                            {{ __('Username') }}
                        </label>
                        <div class="col-5">
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required
                                   data-href="{{route('check_username_unique')}}" placeholder="Username"
                                   class="form-control @error('username') is-invalid @enderror">
                            @error('username')
                            <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row align-items-stretch w-100-1">
                        <label for="email" class="col-5 col-form-label text-md-right">
                            {{ __('E-Mail Address') }}
                        </label>
                        <div class="col-5">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   data-href="{{route('check_email_unique')}}" placeholder="E-Mail"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row align-items-stretch w-100-1">
                        <label for="password" class="col-5 col-form-label text-md-right">
                            {{ __('Password') }}
                        </label>
                        <div class="col-5">
                            <input type="password" id="password" name="password" value="{{ old('password') }}"
                                   required autocomplete="new-password" placeholder="Password"
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row align-items-stretch w-100-1">
                        <label for="password_confirmation" class="col-5 col-form-label text-md-right">
                            {{ __('Confirm Password') }}
                        </label>
                        <div class="col-5">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   value="{{ old('password_confirmation') }}" autocomplete="new-password"  placeholder="Confirm Password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row align-items-stretch w-100-1">
                        <div class="col-5 text-right">
                            <input type="checkbox" name="terms" id="terms" class="form-check-input" {{ (old('terms')) ? 'checked' : '' }} value=1>
                        </div>
                        <div class="col-5">
                            <label class="form-check-label" for="terms">
                                Check our <a href="#">terms</a> and <a href="#">conditions</a>
                            </label>
                            <strong id="terms_error"></strong>
                            @error('terms')
                            <div class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-stretch w-100-1 justify-content-center">
                        <div class="w-35"></div>
                        <div class="w-40">
                            <div class="g-recaptcha" data-sitekey="{{config('recapcha.GOOGLE_CAPTCHA_KEY')}}"
                                 data-callback="recaptchaDataCallbackRegister"
                                 data-expired-callback="recaptchaExpireCallbackRegister"></div>
                            <input type="hidden" name="grecaptcha" id="hiddenInputRecaptchaRegister">
                            @error('grecaptcha')
                            <div class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                            <strong id="RegisterRecaptchaErrorDiv"></strong>
                        </div>
                        <div class="w-25"></div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col text-center1">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="h-25"></div>
        </div> {{-- 5 - center-end --}}
        <div></div> {{-- 6 --}}
        <div></div> {{-- 7 --}}
        <div></div> {{-- 8 --}}
        <div></div> {{-- 9 --}}
    </div>

@endsection
