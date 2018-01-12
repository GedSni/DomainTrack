<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alexa</title>
    <link rel="stylesheet" type="text/css" href={{ URL::asset('css/style.css') }}>
    <link rel="favicon" href="{{{ asset('img/favicon.ico') }}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.floatThead.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/methods.js') }}"></script>
</head>
<body>
<div class="content">
    @yield('content')
</div>
</body>
</html>