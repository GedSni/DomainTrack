<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>DomainTrack</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="content">
            <div class="container" style="margin-top: 50px">
                <div class="col-xs-4">
                    <p style="font-size:36px;">Day</p>
                    <div class="table-responsive">
                        <table class="table" id="mainTable">
                            <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Rank</th>
                                <th>Rank diff</th>
                                <th>Updated</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i = 0; $i < count($dataDay); $i++)
                                <tr>
                                    <td>{{$dataDay[$i]->name}}</td>
                                    <td>{{$dataDay[$i]->day_rank}}</td>
                                    <td>{{$dataDay[$i]->day_diff}}</td>
                                    <td>{{$dataDay[$i]->day_update_date}}</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-4">
                    <p style="font-size:36px;">Week</p>
                    <div class="table-responsive">
                        <table class="table" id="mainTable">
                            <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Rank</th>
                                <th>Rank diff</th>
                                <th>Updated</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i = 0; $i < count($dataWeek); $i++)
                                <tr>
                                    <td>{{$dataWeek[$i]->name}}</td>
                                    <td>{{$dataWeek[$i]->week_rank}}</td>
                                    <td>{{$dataWeek[$i]->week_diff}}</td>
                                    <td>{{$dataWeek[$i]->week_update_date}}</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-4">
                    <p style="font-size:36px;">Month</p>
                    <div class="table-responsive">
                        <table class="table" id="mainTable">
                            <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Rank</th>
                                <th>Rank diff</th>
                                <th>Updated</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i = 0; $i < count($dataMonth); $i++)
                                <tr>
                                    <td>{{$dataMonth[$i]->name}}</td>
                                    <td>{{$dataMonth[$i]->month_rank}}</td>
                                    <td>{{$dataMonth[$i]->month_diff}}</td>
                                    <td>{{$dataMonth[$i]->month_update_date}}</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>