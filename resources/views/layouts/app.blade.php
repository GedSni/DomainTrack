<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Alexa</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('css/style.css') }}">
    <link rel="favicon" href="{{{ asset('img/favicon.ico') }}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ mix('js/methods.js') }}"></script>
</head>
<body>
<div class="content">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h4 class="my-0 mr-md-auto font-weight-normal"><a href="/">Alexa tracker</a></h4>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="#">Features</a>
            <a class="p-2 text-dark" href="#">Support</a>
        </nav>
        <a class="btn btn-outline-primary" href="#">Sign in</a>
    </div>
    @yield('content')
    <div class="container">
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2018 AlexaTrack</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
</div>
</body>
</html>