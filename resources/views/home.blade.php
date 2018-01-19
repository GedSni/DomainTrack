@extends('layouts.app')

@section('content')
<div class="overlay">
    <div class="section1 layout">
        <div id="topStatusDiv" class="tableCell">
            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                <span class="glyphicon glyphicon-exclamation-sign statusGlyph" aria-hidden="true"></span>
            </a>
        </div>
        <div class="tableCell">
            <a class="domainName" id="topName" rel="noreferrer noopener nofollow"></a>
        </div>
        <div class="tableCell">
            <a id='topSimilar' rel='noreferrer noopener nofollow' href='https://www.similarweb.com/website/'>
                <img class="similarImg" alt='SimilarWeb' align='right' src={{ asset('img/similarweb.ico') }}></a>
            <a id="topAlexa" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/">
                <img class="alexaImg" alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }}></a>
        </div>
        <div class="tableCell">
            <p id="topRank"></p>
        </div>
        <div class="tableCell">
            <span id="topDiff" class="label"></span>
        </div>
        <div class="tableCell">
            <button class="btn btn-link exit"><span class="glyphicon glyphicon-remove exitGlyph" aria-hidden="true"></span></button>
        </div>

    </div>
    <div class="section2">
        <div class="loader" id="loader"></div>
        <iframe id="mainFrame" frameborder="0" sandbox="allow-same-origin allow-scripts allow-popups allow-forms"
                style="width: 100%; height: 100%" src="" onerror="error('Failed to load');">
        </iframe>
    </div>
    <div class="section3 layout">
        <div id="bottomStatusDiv" class="tableCell">
            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                <span class="glyphicon glyphicon-exclamation-sign statusGlyph" aria-hidden="true"></span>
            </a>
        </div>
        <div class="tableCell">
            <a class="domainName" id="bottomName" rel="noreferrer noopener nofollow"></a>
        </div>
        <div class="tableCell">
            <a id='bottomSimilar' rel='noreferrer noopener nofollow' href='https://www.similarweb.com/website/'>
                <img class="similarImg" alt='SimilarWeb' align='right' src={{ asset('img/similarweb.ico') }}></a>
            <a id="bottomAlexa" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/">
                <img class="alexaImg" alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }}></a>
        </div>
        <div class="tableCell">
            <p id="bottomRank"></p>
        </div>
        <div class="tableCell">
            <span id="bottomDiff" class="label"></span>
        </div>
        <div class="tableCell">
            <button class="btn btn-link nextRow"><span class="glyphicon glyphicon-play nextRowGlyph" aria-hidden="true"></span></button>
        </div>
    </div>
</div>
<div id="mainDiv" class="container" style="margin-top: 50px">
    <div class="container">
        <form action="/old" method="GET">
            <button type="submit" class="btn"  style="width:auto; float:right">
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
        @if (isset($dataDay[0]))
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
                            <td class="nameAndLinks">
                                <a class="link" rel="noreferrer noopener nofollow" href="http://{{$dataDay[$i]->name}}">{{$dataDay[$i]->name}}</a>
                                <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataDay[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataDay[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataDay[$i]->status) && !$dataDay[$i]->status)
                                    <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                        <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                    </a>
                                @endif
                            </td>
                            <td class="rank">{{$dataDay[$i]->day_rank}}</td>
                            @if ($dataDay[$i]->day_diff > 0)
                                <td class="diff" align="left"><span class="label label-success">+{{$dataDay[$i]->day_diff}}</span></td>
                            @elseif ($dataDay[$i]->day_diff < 0)
                                <td class="diff" align="left"><span class="label label-danger">{{$dataDay[$i]->day_diff}}</span></td>
                            @elseif ($dataDay[$i]->day_diff == 0)
                                <td class="diff" align="left"> <span class="label label-default">{{$dataDay[$i]->day_diff}}</span></td>
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
                        <th>Rank</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataWeek); $i++)
                        <tr>
                            <td class="nameAndLinks">
                                <a class="link" rel="noreferrer noopener nofollow" href="http://{{$dataWeek[$i]->name}}">{{$dataWeek[$i]->name}}</a>
                                <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataWeek[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataWeek[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataWeek[$i]->status) && !$dataWeek[$i]->status)
                                    <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                        <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                    </a>
                                @endif
                            </td>
                            <td class="rank">{{$dataWeek[$i]->day_rank}}</td>
                            @if ($dataWeek[$i]->week_diff > 0)
                                <td class="diff" align="left"><span class="label label-success">+{{$dataWeek[$i]->week_diff}}</span></td>
                            @elseif ($dataWeek[$i]->week_diff < 0)
                                <td class="diff" align="left"><span class="label label-danger">{{$dataWeek[$i]->week_diff}}</span></td>
                            @elseif ($dataWeek[$i]->week_diff == 0)
                                <td class="diff" align="left"><span class="label label-default">{{$dataWeek[$i]->week_diff}}</span></td>
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
                        <th>Rank</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataMonth); $i++)
                        <tr>
                            <td class="nameAndLinks">
                                <a class="link" rel="noreferrer noopener nofollow" href="http://{{$dataMonth[$i]->name}}">{{$dataMonth[$i]->name}}</a>
                                <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonth[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonth[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataMonth[$i]->status) && !$dataMonth[$i]->status)
                                    <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                        <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                    </a>
                                @endif
                            </td>
                            <td class="rank">{{$dataMonth[$i]->day_rank}}</td>
                            @if ($dataMonth[$i]->month_diff > 0)
                                <td class="diff" align="left"><span class="label label-success">+{{$dataMonth[$i]->month_diff}}</span></td>
                            @elseif ($dataMonth[$i]->month_diff < 0)
                                <td class="diff" align="left"> <span class="label label-danger">{{$dataMonth[$i]->month_diff}}</span></td>
                            @elseif ($dataMonth[$i]->month_diff == 0)
                                <td class="diff" align="left"> <span class="label label-default">{{$dataMonth[$i]->month_diff}}</span></td>
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