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
            <a class="p-2 text-dark" href="#">1</a>
            <a class="p-2 text-dark" href="#">2</a>
            <a class="p-2 text-dark" href="#">3</a>
            <a class="p-2 text-dark" href="#">4</a>
        </nav>
        <a class="btn btn-outline-primary" href="#">Sign up</a>
    </div>
    @yield('content')
    <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    <img class="mb-2" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="24" height="24">
                    <small class="d-block mb-3 text-muted">© 2017-2018</small>
                </div>
                <div class="col-6 col-md">
                    <h5>1</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">1.1</a></li>
                        <li><a class="text-muted" href="#">1.2</a></li>
                        <li><a class="text-muted" href="#">1.3</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>2</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">2.1</a></li>
                        <li><a class="text-muted" href="#">2.2</a></li>
                        <li><a class="text-muted" href="#">2.3</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>3</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">3.1</a></li>
                        <li><a class="text-muted" href="#">3.2</a></li>
                        <li><a class="text-muted" href="#">3.3</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
</body>
</html>