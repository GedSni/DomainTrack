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
        <select id="tables" class="form-control" style="width:auto;" onchange="changeTable(this.value);">
            <option value="Day">Day</option>
            <option value="Week">Week</option>
            <option selected value="Month">Month</option>
        </select>
    </div>
    <div class="dayTableDiv" id="dayTableDiv">
        <p class="tableHead" >3 Months</p>
        @if (isset($dataMonths3[0]))
            <p class="tableHead2">Updated {{ $dataMonths3[0]->date }}</p>
            <div>
                <table class="table" id="floatingHeader">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-left">Rank</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataMonths3); $i++)
                        <tr>
                            <td>
                                <a rel="noreferrer noopener nofollow" href="http://{{$dataMonths3[$i]->name}}">{{$dataMonths3[$i]->name}}</a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonths3[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonths3[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataMonths3[$i]->status) && !$dataMonths3[$i]->status)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                @endif

                            </td>
                            <td align="right">{{$dataMonths3[$i]->day_rank}}</td>
                            @if ($dataMonths3[$i]->day_diff > 0)
                                <td align="left"> <span class="label label-success">+{{$dataMonths3[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths3[$i]->day_diff < 0)
                                <td align="left"> <span class="label label-danger">{{$dataMonths3[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths3[$i]->day_diff == 0)
                                <td align="left"> <span class="label label-default">{{$dataMonths3[$i]->day_diff}}</span></td>
                            @endif
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @else
            <p class="tableHead" >Not Available</p>
        @endif
    </div>
    <div class="weekTableDiv" id="weekTableDiv">
        <p class="tableHead" >6 Months</p>
        @if (isset($dataMonths6[0]))
            <p class="tableHead2">Updated {{ $dataMonths6[0]->date }}</p>
            <div>
                <table class="table" id="floatingHeader">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-left">Rank</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataMonths6); $i++)
                        <tr>
                            <td>
                                <a rel="noreferrer noopener nofollow" href="http://{{$dataMonths6[$i]->name}}">{{$dataMonths6[$i]->name}}</a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonths6[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonths6[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataMonths6[$i]->status) && !$dataMonths6[$i]->status)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                @endif

                            </td>
                            <td align="right">{{$dataMonths6[$i]->day_rank}}</td>
                            @if ($dataMonths6[$i]->day_diff > 0)
                                <td align="left"> <span class="label label-success">+{{$dataMonths6[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths6[$i]->day_diff < 0)
                                <td align="left"> <span class="label label-danger">{{$dataMonths6[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths6[$i]->day_diff == 0)
                                <td align="left"> <span class="label label-default">{{$dataMonths6[$i]->day_diff}}</span></td>
                            @endif
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @else
            <p class="tableHead" >Not Available</p>
        @endif
    </div>
    <div class="monthTableDiv" id="monthTableDiv">
        <p class="tableHead" >12 Months</p>
        @if (isset($dataMonths12[0]))
            <p class="tableHead2">Updated {{ $dataMonths12[0]->date }}</p>
            <div>
                <table class="table" id="floatingHeader">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-left">Rank</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataMonths12); $i++)
                        <tr>
                            <td>
                                <a rel="noreferrer noopener nofollow" href="http://{{$dataMonths12[$i]->name}}">{{$dataMonths12[$i]->name}}</a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonths12[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonths12[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataMonths12[$i]->status) && !$dataMonths12[$i]->status)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                @endif

                            </td>
                            <td align="right">{{$dataMonths12[$i]->day_rank}}</td>
                            @if ($dataMonths12[$i]->day_diff > 0)
                                <td align="left"> <span class="label label-success">+{{$dataMonths12[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths12[$i]->day_diff < 0)
                                <td align="left"> <span class="label label-danger">{{$dataMonths12[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths12[$i]->day_diff == 0)
                                <td align="left"> <span class="label label-default">{{$dataMonths12[$i]->day_diff}}</span></td>
                            @endif
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