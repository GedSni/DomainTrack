<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alexa</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href={{ URL::asset('css/style.css') }}>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.floatThead.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('table.table').floatThead();
        });
    </script>
    <script type="text/javascript">
        function changeTable(value) {

            if (value == 'Month') {
                document.getElementById("dayTableDiv").style.display = "none";
                document.getElementById("weekTableDiv").style.display = "none";
                document.getElementById("monthTableDiv").style.display = "inline-table";
                document.getElementById("monthTableDiv").style.width = "100%";
                document.getElementById("floatingHeader").style.width = "100%";
            } else if (value == 'Week') {
                document.getElementById("dayTableDiv").style.display = "none";
                document.getElementById("weekTableDiv").style.display = "inline-table";
                document.getElementById("weekTableDiv").style.width = "100%";
                document.getElementById("floatingHeader").style.width = "100%";
                document.getElementById("monthTableDiv").style.display = "none";
            } else if (value == 'Day') {
                document.getElementById("dayTableDiv").style.display = "inline-table";
                document.getElementById("dayTableDiv").style.width = "100%";
                document.getElementById("floatingHeader").style.width = "100%";
                document.getElementById("weekTableDiv").style.display = "none";
                document.getElementById("monthTableDiv").style.display = "none";
            }
            var $table = $('table.table');
            $table.floatThead('reflow');
        }
    </script>
</head>
<body>
<div class="content">
    @yield('content')
</div>
</body>
</html>