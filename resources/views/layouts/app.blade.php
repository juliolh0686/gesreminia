<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GesRem') }}</title>

<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="loguin/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" href="{{ asset('loguin/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" href="{{ asset('loguin/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" href="{{ asset('loguin/fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" href="{{ asset('loguin/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" href="{{ asset('loguin/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" href="{{ asset('loguin/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" href="{{ asset('loguin/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" href="{{ asset('loguin/vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" href="{{ asset('loguin/css/util.css') }}">
	<link rel="stylesheet" href="{{ asset('loguin/css/main.css') }}">
<!--===============================================================================================-->

</head>
    <body>
        @yield('content')


<!--===============================================================================================-->
	<script src="{{ asset('loguin/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('loguin/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('loguin/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('loguin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('loguin/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('loguin/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('loguin/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('loguin/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('loguin/js/main.js') }}"></script>
    </body>

</html>
