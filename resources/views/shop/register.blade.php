@extends('layout.main-layout')
@section('body')
    <div class="row mb-3">
        <form action="{{route('postRegister')}}" method="POST" id="registration_form"
              class="col-md-6 col-xs-12 offset-md-3 auth-form">
            @csrf
            <div class="form-title">
                SIGN UP
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control"
                               placeholder="First Name" value="{{old('first_name')}}">
                        @if($errors->any('first_name'))
                            <span class="text-danger">
                                {{$errors->first('first_name')}}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control"
                               placeholder="Last Name" value="{{old('last_name')}}">
                        @if($errors->any('last_name'))
                            <span class="text-danger">
                                {{$errors->first('last_name')}}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" id="email" class="form-control"
                       placeholder="Enter email" value="{{old('email')}}">
                <small id="emailHelp" class="form-text text-muted">
                    We'll never share your email with anyone else.
                </small>
                @if($errors->any('email'))
                    <span class="text-danger">
                        {{$errors->first('email')}}
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                       placeholder="Password" autocomplete="false">
                @if($errors->any('password'))
                    <span class="text-danger">
                        {{$errors->first('password')}}
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                       placeholder="Confirm Password" autocomplete="false">
{{--                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"--}}
{{--                       placeholder="Confirm Password" autocomplete="false">--}}
                @if($errors->any('confirm_password'))
                    <span class="text-danger">
                        {{$errors->first('confirm_password')}}
                    </span>
                @endif
            </div>
            <div class="form-check">
                <input type="checkbox" name="terms" id="terms"
                       {{(old('terms'))?'checked':''}} class="form-check-input">
                <label class="form-check-label" for="terms_check">
                    Check our <a href="#">terms</a> and <a href="#">conditions</a>
                </label>
            </div>
            <div id="terms_error"></div>
            @if($errors->any('terms'))
                <span class="text-danger">{{$errors->first('terms')}}</span>
            @endif
            <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_CAPTCHA_KEY')}}"
                 data-callback="recaptchaDataCallbackRegister"
                 data-expired-callback="recaptchaExpireCallbackRegister"></div>
            <input type="hidden" name="grecaptcha" id="hiddenRecaptchaRegister">
            <div id="hiddenRecaptchaRegisterError"></div>
            @if($errors->any('grecaptcha'))
                <span class="text-danger">{{$errors->first('grecaptcha')}}</span>
            @endif
            <div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                &nbsp; Already have an account <a href="">sign in</a> here
            </div>
        </form>
    </div>
@endsection
