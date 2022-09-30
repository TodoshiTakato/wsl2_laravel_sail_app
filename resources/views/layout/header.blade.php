<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">   {{-- CSRF Token --}}
<title>{{ config('app.name', 'Laravel') }}</title>

{{-- CSS Styles --}}
<link href="{{ asset('css/app.css') }}" rel="stylesheet">   {{-- Bootstrap (Customized) --}}
<link href="{{ asset('css/all.css') }}" rel="stylesheet">   {{-- FontAwesome Icons --}}
<link rel="stylesheet" href="{{ asset('assets/css/alertify.min.css') }}">   {{-- alertify Icons --}}
<link rel="stylesheet" href="{{ asset('assets/css/themes/default.min.css') }}">   {{-- alertify themes --}}


{{-- Fonts --}}


{{-- Scripts --}}
{{--<script src="https://www.google.com/recaptcha/api.js" async defer></script>    --}}{{-- reCaptcha --}}
{{-- Look at the login and register blades for recaptcha and auth js --}}
@stack('header')
