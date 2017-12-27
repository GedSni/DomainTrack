<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ASDASD</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;

            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="content">
    <div class="container">
        <h2>Ranks</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Domain</th>
                <th>Rank shift</th>
                @foreach($date_data as $var)
                    <th>{{ $var->date }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $domain->name }}</td>
                    <td>{{ $shift }}</td>
                    @foreach($ranks as $var2)
                        @if($var2->domain_id == $domain->id)
                            @if($var2->value)
                                <td>{{ $var2->value }}</td>
                            @else
                                <td>---</td>
                            @endif
                        @endif
                    @endforeach
                </tr>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
