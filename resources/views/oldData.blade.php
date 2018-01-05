@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 50px">
    <div class="container">
        <form action="/" method="GET">
            <button type="submit" class="btn"  style="float: right; margin-right: 30px">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                Recent Data
            </button>
        </form>
    </div>
    <div class="col-xs-4">
        <p class="tableHead" >3 Months</p>
        @if (isset($dataMonths3))
            <p class="tableHead2">Updated {{ $dataMonths3[0]->date }}</p>
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
                    @for($i = 0; $i < count($dataMonths3); $i++)
                        <tr>
                            <td>{{$dataMonths3[$i]->name}}</td>
                            <td align="right">{{$dataMonths3[$i]->day_rank}}</td>
                            <td align="right">{{$dataMonths3[$i]->day_rank - $dataMonths3[$i]->value}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @else
            <p class="tableHead" >Not Available</p>
        @endif
    </div>
    <div class="col-xs-4">
        <p class="tableHead" >6 Months</p>
        @if (isset($dataMonths6))
            <p class="tableHead2">Updated {{ $dataMonths6[0]->date }}</p>
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
                    @for($i = 0; $i < count($dataMonths6); $i++)
                        <tr>
                            <td>{{$dataMonths6[$i]->name}}</td>
                            <td align="right">{{$dataMonths6[$i]->day_rank}}</td>
                            <td align="right">{{$dataMonths6[$i]->day_rank - $dataMonths6[$i]->value}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @else
            <p class="tableHead" >Not Available</p>
        @endif
    </div>
    <div class="col-xs-4">
        <p class="tableHead" >12 Months</p>
        @if (isset($dataMonths12))
            <p class="tableHead2">Updated {{ $dataMonths12[0]->date }}</p>
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
                    @for($i = 0; $i < count($dataMonths12); $i++)
                        <tr>
                            <td>{{$dataMonths12[$i]->name}}</td>
                            <td align="right">{{$dataMonths12[$i]->day_rank}}</td>
                            <td align="right">{{$dataMonths12[$i]->day_rank - $dataMonths12[$i]->value}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @else
            <p class="tableHead" >Not Available</p>
        @endif
    </div>
</div>
@endsection