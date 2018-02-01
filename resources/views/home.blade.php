@extends('layouts.app')

@section('content')
    <div class="overlay">
        <div class="section1 layout">
            <div id="topStatus" class="tableCellTopLeft">
                <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                    STATUS
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
                <span id="topDiff" class="badge badge-pill"></span>
            </div>
            <div class="tableCellRight">
                <button class="btn btn-outline-primary exit" href="#">Close</button>
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
                    STATUS
                </a>
            </div>
            <div class="tableCellMiddle">
                <a id="bottomName" rel="noreferrer noopener nofollow"></a>
            </div>
            <div class="tableCellRight">
                <button class="btn btn-outline-primary nextRow">Next</button>
            </div>
        </div>
    </div>
    <div id="mainDiv" class="container" style="margin-top: 50px">
        <div>
            <button type="button" class="btn btn-outline-primary" id="datePickerButton">
                <input id="datePicker" type="text" style="height: 0; width: 0; border: 0;" />
                Pick a date
            </button>
            <select id="tables" class="form-control" style="width:auto; float:right">
                <option value="Day">Day</option>
                <option value="Week">Week</option>
                <option selected value="Month">Month</option>
            </select>
        </div>
        <div id="tablesDiv">
            <div class="dayTableDiv">
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
                                                <span style="vertical-align: top" class="badge badge-pill badge-warning">!</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="rank">{{$data->rank}}</td>
                                    @if (isset($data->diff))
                                        @if ($data->diff > 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-success">+{{$data->diff}}</span></td>
                                        @elseif ($data->diff < 0)
                                            <td class="diff" align="left"><span class="lbadge badge-pill badge-danger">{{$data->diff}}</span></td>
                                        @elseif ($data->diff == 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-primary">{{$data->diff}}</span></td>
                                        @endif
                                    @else
                                        <td class="diff" align="left"><span class="badge badge-pill badge-warning">N/A</span></td>
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
            <div class="weekTableDiv">
                <p class="tableHead">Week</p>
                @if (isset($dataWeek[0]))
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
                                        <a class="link" href="{{ action('DomainController@show', [$data->name]) }}">{{$data->name}}</a>
                                        <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$data->name}}">
                                            <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                        <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$data->name}}">
                                            <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                        @if (isset($data->status) && !$data->status)
                                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                                <span style="vertical-align: top" class="badge badge-pill badge-warning">!</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="rank">{{$data->rank}}</td>
                                    @if (isset($data->diff))
                                        @if ($data->diff > 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-success">+{{$data->diff}}</span></td>
                                        @elseif ($data->diff < 0)
                                            <td class="diff" align="left"><span class="lbadge badge-pill badge-danger">{{$data->diff}}</span></td>
                                        @elseif ($data->diff == 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-primary">{{$data->diff}}</span></td>
                                        @endif
                                    @else
                                        <td class="diff" align="left"><span class="badge badge-pill badge-warning">N/A</span></td>
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
            <div class="monthTableDiv">
                <p class="tableHead">Month</p>
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
                                        <a class="link" href="{{ action('DomainController@show', [$data->name]) }}">{{$data->name}}</a>
                                        <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$data->name}}">
                                            <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                                        <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$data->name}}">
                                            <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                                        @if (isset($data->status) && !$data->status)
                                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                                <span style="vertical-align: top" class="badge badge-pill badge-warning">!</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="rank">{{$data->rank}}</td>
                                    @if (isset($data->diff))
                                        @if ($data->diff > 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-success">+{{$data->diff}}</span></td>
                                        @elseif ($data->diff < 0)
                                            <td class="diff" align="left"><span class="lbadge badge-pill badge-danger">{{$data->diff}}</span></td>
                                        @elseif ($data->diff == 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-primary">{{$data->diff}}</span></td>
                                        @endif
                                    @else
                                        <td class="diff" align="left"><span class="badge badge-pill badge-warning">N/A</span></td>
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