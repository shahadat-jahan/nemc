<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Storage Finder | Login') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Vivacom Solutions Ltd." name="author" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    {{--<link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />--}}
    <link href="{{asset('assets/global/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/login-4.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favi.png') }}"/>
    <style>
        .content {
            -webkit-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.75);
        }
    </style>
</head>
<body class="login">

    @yield('content')

    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
{{--    <script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>--}}
</body>
</html>
