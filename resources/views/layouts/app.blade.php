<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Alexa</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ mix('js/methods.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ mix('css/style.css') }}">
    <link rel="favicon" href="{{{ asset('img/favicon.ico') }}}">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
<div class="content">
    <div class="container">
        <div style="text-align:center;" class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
            <h4 class="my-0 mr-md-auto font-weight-normal"><a href="/">AlexaTrack</a></h4>
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-dark" href="#">Features</a>
                <a class="p-2 text-dark" href="#">Support</a>
            </nav>
            @guest
                <a class="btn btn-outline-primary" href="{{ route('redirect') }}"><span class="fab fa-facebook-square fa-lg"></span> Login with facebook </a>
            @else
                <a id="favButton" class="btn btn-outline-primary" href="{{ route('favorites') }}"><span class="fa fa-heart"></span> Favorites</a>
                <a class="btn btn-outline-primary" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="fa fa-power-off"></span> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endguest
        </div>
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