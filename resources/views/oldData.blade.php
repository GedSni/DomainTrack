@extends('layouts.app')

@section('content')
<div class="overlay">
    <div class="section1 layout">
        <div id="topStatus" class="tableCell">
            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                <span class="glyphicon glyphicon-exclamation-sign statusGlyph" aria-hidden="true"></span>
            </a>
        </div>
        <div class="tableCell">
            <a id="topName" rel="noreferrer noopener nofollow"></a>
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
            <button class="button exit"><span class="glyphicon glyphicon-remove exitGlyph" aria-hidden="true"></span></button>
        </div>
    </div>
    <div class="section2">
        <div class="loader" id="loader"></div>
        <iframe id="mainFrame" frameborder="0" sandbox="allow-same-origin allow-scripts allow-popups allow-forms"
                style="width: 100%; height: 100%" src="" onerror="error('Failed to load');">
        </iframe>
    </div>
    <div class="section3 layout">
        <div class="tableCellLeft">
            <a id="bottomStatus" class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                <span style="margin-left: 40px" class="glyphicon glyphicon-exclamation-sign statusGlyphBottom" aria-hidden="true"></span>
            </a>
        </div>
        <div class="tableCellMiddle">
            <a id="bottomName" rel="noreferrer noopener nofollow"></a>
        </div>
        <div class="tableCellRight">
            <button style="margin-right: 20px" class="button nextRow"><span class="glyphicon glyphicon-play nextRowGlyph" aria-hidden="true"></span></button>
        </div>
    </div>
</div>
<div id="mainDiv" class="container" style="margin-top: 50px">
    <div class="container">
        <form action="/" method="GET">
            <button type="submit" class="btn"  style="width:auto; float:right">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                Recent Data
            </button>
        </form>
        <select id="tables" class="form-control" style="width:auto;" onchange="changeTable(this.value);">
            <option value="Day">3 Months</option>
            <option value="Week">6 Months</option>
            <option selected value="Month">12 Months</option>
        </select>
    </div>
    <div class="dayTableDiv" id="dayTableDiv">
        <p class="tableHead">3 Months</p>
        @if (isset($dataMonths3[0]))
            <p class="tableHead2">Updated {{ $dataMonths3[0]->date }}</p>
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
                    @for($i = 0; $i < count($dataMonths3); $i++)
                        <tr>
                            <td class="nameAndLinks">
                                <a class="link" rel="noreferrer noopener nofollow" href="http://{{$dataMonths3[$i]->name}}">{{$dataMonths3[$i]->name}}</a>
                                <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataDay[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonths3[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataMonths3[$i]->status) && !$dataMonths3[$i]->status)
                                    <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                        <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                    </a>
                                @endif
                            </td>
                            <td class="rank">{{$dataMonths3[$i]->day_rank}}</td>
                            @if ($dataMonths3[$i]->day_diff > 0)
                                <td class="diff" align="left"><span class="label label-success">+{{$dataMonths3[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths3[$i]->day_diff < 0)
                                <td class="diff" align="left"><span class="label label-danger">{{$dataMonths3[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths3[$i]->day_diff == 0)
                                <td class="diff" align="left"> <span class="label label-default">{{$dataMonths3[$i]->day_diff}}</span></td>
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
        <p class="tableHead">6 Months</p>
        @if(isset($dataMonths6[0]))
            <p class="tableHead2">Updated {{ $dataMonths6[0]->date }}</p>
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
                    @for($i = 0; $i < count($dataMonths6); $i++)
                        <tr>
                            <td class="nameAndLinks">
                                <a class="link" rel="noreferrer noopener nofollow" href="http://{{$dataMonths6[$i]->name}}">{{$dataMonths6[$i]->name}}</a>
                                <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonths6[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonths6[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataMonths6[$i]->status) && !$dataMonths6[$i]->status)
                                    <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                        <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                    </a>
                                @endif
                            </td>
                            <td class="rank">{{$dataMonths6[$i]->day_rank}}</td>
                            @if ($dataMonths6[$i]->day_diff > 0)
                                <td class="diff" align="left"><span class="label label-success">+{{$dataMonths6[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths6[$i]->day_diff < 0)
                                <td class="diff" align="left"><span class="label label-danger">{{$dataMonths6[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths6[$i]->day_diff == 0)
                                <td class="diff" align="left"><span class="label label-default">{{$dataMonths6[$i]->day_diff}}</span></td>
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
        <p class="tableHead">12 Months</p>
        @if (isset($dataMonths12[0]))
            <p class="tableHead2">Updated {{ $dataMonths12[0]->date }}</p>
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
                    @for($i = 0; $i < count($dataMonths12); $i++)
                        <tr>
                            <td class="nameAndLinks">
                                <a class="link" rel="noreferrer noopener nofollow" href="http://{{$dataMonths12[$i]->name}}">{{$dataMonths12[$i]->name}}</a>
                                <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonths12[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonths12[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                @if (isset($dataMonths12[$i]->status) && !$dataMonths12[$i]->status)
                                    <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                        <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                    </a>
                                @endif
                            </td>
                            <td class="rank">{{$dataMonths12[$i]->day_rank}}</td>
                            @if ($dataMonths12[$i]->day_diff > 0)
                                <td class="diff" align="left"><span class="label label-success">+{{$dataMonths12[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths12[$i]->day_diff < 0)
                                <td class="diff" align="left"> <span class="label label-danger">{{$dataMonths12[$i]->day_diff}}</span></td>
                            @elseif ($dataMonths12[$i]->day_diff == 0)
                                <td class="diff" align="left"> <span class="label label-default">{{$dataMonths12[$i]->day_diff}}</span></td>
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