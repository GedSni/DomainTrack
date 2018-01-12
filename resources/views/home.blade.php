@extends('layouts.app')

@section('content')
<div class="overlay">
    <div class="section1">
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align: center" align="center">
                        twitch.tv
                        <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/http://twitch.tv">
                            <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                        <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/http://twitch.tv">
                            <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                    </th>
                    <th style="text-align: center; " align="center">12</th>
                    <th style="text-align: center" align="center"><span class="label label-success">+100</span></th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="section2">
        <iframe style="width: 100%; height: 100%" src="https://www.w3schools.com">
            <p>Your browser does not support iframes.</p>
        </iframe>
    </div>
    <div class="section3">
        <table class="table">
            <thead>
            <tr>
                <th style="text-align: center" align="center">
                    reddit.com
                </th>
                <th style="text-align: center" align="center">13</th>
                <th style="text-align: center" align="center"><span class="label label-success">+156</span></th>
                <th>
                    <form action="/" method="GET">
                        <button type="submit" class="btn"  style="float: right; margin-right: 30px">Next</button>
                    </form>
                </th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<div class="container" style="margin-top: 50px">
    <div class="container">
        <form action="/old" method="GET">
            <button type="submit" class="btn"  style="float: right; margin-right: 30px">
                Older Data
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
            </button>
        </form>
        <select id="tables" class="form-control" style="width:auto;" onchange="changeTable(this.value);">
            <option value="Day">Day</option>
            <option value="Week">Week</option>
            <option selected value="Month">Month</option>
        </select>
    </div>
    <div class="dayTableDiv" id="dayTableDiv">
        <p class="tableHead">Day</p>
        @if(isset($dataDay[0]))
            <p class="tableHead2">Updated {{ $dataDay[0]->day_update_date }}</p>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th>Rank</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataDay); $i++)
                        <tr>
                            <td style="max-width:100%;  overflow: hidden; white-space:nowrap">
                                <a rel="noreferrer noopener nofollow" href="http://{{$dataDay[$i]->name}}">{{$dataDay[$i]->name}}</a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataDay[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataDay[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataDay[$i]->status) && !$dataDay[$i]->status)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                @endif
                            </td>
                            <td>{{$dataDay[$i]->day_rank}}</td>
                            @if ($dataDay[$i]->day_diff > 0)
                                <td align="left"><span class="label label-success">+{{$dataDay[$i]->day_diff}}</span></td>
                            @elseif ($dataDay[$i]->day_diff < 0)
                                <td align="left"><span class="label label-danger">{{$dataDay[$i]->day_diff}}</span></td>
                            @elseif ($dataDay[$i]->day_diff == 0)
                                <td align="left"> <span class="label label-default">{{$dataDay[$i]->day_diff}}</span></td>
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
        <p class="tableHead" >Week</p>
        @if(isset($dataWeek[0]))
            <p class="tableHead2">Updated {{ $dataWeek[0]->week_update_date }}</p>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th align="left" class="text-left">Rank</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataWeek); $i++)
                        <tr>
                            <td>
                                <a rel="noreferrer noopener nofollow" href="http://{{$dataWeek[$i]->name}}">{{$dataWeek[$i]->name}}</a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataWeek[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataWeek[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataWeek[$i]->status) && !$dataWeek[$i]->status)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                @endif
                            </td>
                            <td>{{$dataWeek[$i]->day_rank}}</td>
                            @if ($dataWeek[$i]->week_diff > 0)
                                <td align="left"><span class="label label-success">+{{$dataWeek[$i]->week_diff}}</span></td>
                            @elseif ($dataWeek[$i]->week_diff < 0)
                                <td align="left"><span class="label label-danger">{{$dataWeek[$i]->week_diff}}</span></td>
                            @elseif ($dataWeek[$i]->week_diff == 0)
                                <td align="left"><span class="label label-default">{{$dataWeek[$i]->week_diff}}</span></td>
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
        <p class="tableHead" >Month</p>
        @if (isset($dataMonth[0]))
            <p class="tableHead2">Updated {{ $dataMonth[0]->month_update_date }}</p>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th align="left" class="text-left">Rank</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataMonth); $i++)
                        <tr>
                            <td>
                                <a rel="noreferrer noopener nofollow" href="http://{{$dataMonth[$i]->name}}">{{$dataMonth[$i]->name}}</a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonth[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonth[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataMonth[$i]->status) && !$dataMonth[$i]->status)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                @endif
                            </td>
                            <td>{{$dataMonth[$i]->day_rank}}</td>
                            @if ($dataMonth[$i]->month_diff > 0)
                                <td align="left"><span class="label label-success">+{{$dataMonth[$i]->month_diff}}</span></td>
                            @elseif ($dataMonth[$i]->month_diff < 0)
                                <td align="left"> <span class="label label-danger">{{$dataMonth[$i]->month_diff}}</span></td>
                            @elseif ($dataMonth[$i]->month_diff == 0)
                                <td align="left"> <span class="label label-default">{{$dataMonth[$i]->month_diff}}</span></td>
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