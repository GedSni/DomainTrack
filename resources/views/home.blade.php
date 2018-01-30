@extends('layouts.app')

@section('content')
    <div id="loading-wrapper">
        <div id="loading-content"></div>
    </div>
    <button class="roundButton" id="toTop" title="Go to top"><span style="color: black; font-size: 20px" class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></button>
    <div class="overlay">
        <div class="section1 layout">
            <div id="topStatus" class="tableCellTopLeft">
                <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                    <span class="glyphicon glyphicon-exclamation-sign statusGlyph" aria-hidden="true"></span>
                </a>
            </div>
            <div class="tableCell">
                <a style="margin-left: 5px" id="topName" rel="noreferrer noopener nofollow"></a>
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
            <div class="tableCellRight">
                <button style="margin-right: 20px" class="button exit"><span class="glyphicon glyphicon-remove exitGlyph" aria-hidden="true"></span></button>
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
            <button class="roundButton" id="toHome" title="Go to top"><span style="color: black; font-size: 20px" class="glyphicon glyphicon-home" aria-hidden="true"></span></button>
        </div>
        <div style="margin-top: 20px" class="container">
            <button style="float:right" type="button" class="btn btn-default" id="datePickerButton">
                <input id="datePicker" disabled="disabled" type="hidden" />
                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                &nbspPick a date
            </button>
            <select id="tables" class="form-control" style="width:auto;">
                <option value="Day">Day</option>
                <option value="Week">Week</option>
                <option selected value="Month">Month</option>
            </select>
        </div>
        <div id="tablesDiv" style="margin-top: 20px">
            <div class="dayTableDiv" id="dayTableDiv">
                <p class="tableHead">Day</p>
                @if (isset($dataDay[0]))
                    <p class="tableHead2">Since {{ $yesterday }}</p>
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
                            @foreach($dataDay as $data)
                                <tr>
                                    <td class="nameAndLinks">
                                        <a class="link" href="{{ action('DomainController@show', [$data->name]) }}">{{$data->name}}</a>
                                        <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$data->name}}">
                                            <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                        <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$data->name}}">
                                            <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                        @if (isset($data->status) && !$data->status)
                                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                                <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="rank">{{$data->rank}}</td>
                                    @if (isset($data->diff))
                                        @if ($data->diff > 0)
                                            <td class="diff" align="left"><span class="label label-success">+{{$data->diff}}</span></td>
                                        @elseif ($data->diff < 0)
                                            <td class="diff" align="left"><span class="label label-danger">{{$data->diff}}</span></td>
                                        @elseif ($data->diff == 0)
                                            <td class="diff" align="left"><span class="label label-default">{{$data->diff}}</span></td>
                                        @endif
                                    @else
                                        <td class="diff" align="left"><span class="label label-warning">Not available</span></td>
                                    @endif
                                </tr>
                            @endforeach
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
                    <p class="tableHead2">Since {{ $lastMonday }}</p>
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
                            @foreach($dataWeek as $data)
                                <tr>
                                    <td class="nameAndLinks">
                                        <a class="link" href={{ action('DomainController@show', [$data->name]) }}>{{$data->name}}</a>
                                        <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$data->name}}">
                                            <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                        <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$data->name}}">
                                            <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                        @if (isset($data->status) && !$data->status)
                                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                                <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="rank">{{$data->rank}}</td>
                                    @if ($data->diff > 0)
                                        <td class="diff" align="left"><span class="label label-success">+{{$data->diff}}</span></td>
                                    @elseif ($data->diff < 0)
                                        <td class="diff" align="left"><span class="label label-danger">{{$data->diff}}</span></td>
                                    @elseif ($data->diff == 0)
                                        <td class="diff" align="left"><span class="label label-default">{{$data->diff}}</span></td>
                                    @endif
                                </tr>
                            @endforeach
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
                    <p class="tableHead2">Since {{ $firstMonthDay }}</p>
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
                            @foreach($dataMonth as $data)
                                <tr>
                                    <td class="nameAndLinks">
                                        <a class="link" href={{ action('DomainController@show', [$data->name]) }}>{{$data->name}}</a>
                                        <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$data->name}}">
                                            <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                        <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$data->name}}">
                                            <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                        @if (isset($data->status) && !$data->status)
                                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                                <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="rank">{{$data->rank}}</td>
                                    @if ($data->diff > 0)
                                        <td class="diff" align="left"><span class="label label-success">+{{$data->diff}}</span></td>
                                    @elseif ($data->diff < 0)
                                        <td class="diff" align="left"> <span class="label label-danger">{{$data->diff}}</span></td>
                                    @elseif ($data->diff == 0)
                                        <td class="diff" align="left"> <span class="label label-default">{{$data->diff}}</span></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="tableHead" >Not Available</p>
                @endif
            </div>
        </div>
    </div>
@endsection