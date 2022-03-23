<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        li{
            font-size: 15px;
            list-style: none;
        }
        .col-md-12{
            flex:0 0 100%;
            max-width:100%;
        }
        .col-md-6{
            flex:0 0 50%;
            max-width:50%;
        }
    </style>
</head>
<body>
@yield('content')
</body>
</html>
