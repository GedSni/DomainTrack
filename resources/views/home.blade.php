@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px">
    <div class="container">
        <form action="/old" method="GET">
            <button type="submit" class="btn"  style="float: right; margin-right: 30px">
                Older Data
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
            </button>
        </form>
    </div>
    <div class="col-xs-4">
        <p class="tableHead">Day</p>
        @if(isset($dataDay[0]))
            <p class="tableHead2">Updated {{ $dataDay[0]->day_update_date }}</p>
            <div class="table-responsive">
                <table class="table table-bordered table-curved table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-right">Rank</th>
                        <th class="text-right">Diff</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataDay); $i++)
                        <tr>
                            <td>{{$dataDay[$i]->name}}</td>
                            <td align="right">{{$dataDay[$i]->day_rank}}</td>
                            <td align="right">{{$dataDay[$i]->day_diff}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="col-xs-4">
        <p class="tableHead" >Week</p>
        @if(isset($dataWeek[0]))
            <p class="tableHead2">Updated {{ $dataWeek[0]->week_update_date }}</p>
            <div class="table-responsive">
                <table class="table table-bordered table-curved table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-right">Rank</th>
                        <th class="text-right">Diff</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataWeek); $i++)
                        <tr>
                            <td>{{$dataWeek[$i]->name}}</td>
                            <td align="right">{{$dataWeek[$i]->week_rank}}</td>
                            <td align="right">{{$dataWeek[$i]->week_diff}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="col-xs-4">
        <p class="tableHead" >Month</p>
        @if(isset($dataMonth[0]))
            <p class="tableHead2">Updated {{ $dataMonth[0]->month_update_date }}</p>
            <div class="table-responsive">
                <table class="table table-bordered table-curved table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-right">Rank</th>
                        <th class="text-right">Diff</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataMonth); $i++)
                        <tr>
                            <td>{{$dataMonth[$i]->name}}</td>
                            <td align="right">{{$dataMonth[$i]->month_rank}}</td>
                            <td align="right">{{$dataMonth[$i]->month_diff}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @ekse
        @endif

    </div>
</div>
@endsection