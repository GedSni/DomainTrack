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

    </head>
    <body>
        <div class="content">
            <div class="container" style="margin-top: 50px">
                <p>Data from {{$date}} to {{$today}} was taken into consideration</p>
                <div style="display: inline-block; float: left; margin-right: 10px;">
                    <p>Name filter</p>
                    <input class="form-control" type="text" id="searchInput" onkeyup="searchDomains()" placeholder="Search for domains..">
                </div>
                <p>Date filter</p>
                <form action="{{ action('DomainController@index') }}" method="POST" class="form" role="form">
                    <select class="form-control" name="date" id="date" style="width:auto;" onchange="this.form.submit()">
                        @foreach($date_data as $date)
                            <option value={{$date->date}}>{{$date->date}}</option>
                        @endforeach
                            <option selected  disabled hidden>Choose a date</option>
                    </select>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                <table class="table" id="mainTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>Domain</th>
                        <th>Current rank</th>
                        <th>Rank shift</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($data); $i++)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$data[$i]->id}}</td>
                            <td>{{$data[$i]->name}}</td>
                            <td>{{$data[$i]->value_after}}</td>
                            <td>{{$data[$i]->value_before - $data[$i]->value_after}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

<script>
    function searchDomains() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("mainTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

