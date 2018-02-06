@extends('layouts.app')

@section('content')
    <div class="overlay">
        <div class="section1 layout">
            <div class="tableCell topLeft">
                <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                    <img id="topStatus" alt='Status' style="vertical-align: top;" height="20px" width="20px"  src={{ asset('img/exclamation.png') }}>
                </a>
            </div>
            <div class="tableCell cell">
                <a style="margin-left: 5px" id="topName" rel="noreferrer noopener nofollow"></a>
            </div>
            <div class="tableCell cell">
                <p id="topRank"></p>
            </div>
            <div class="tableCell cell">
                <span id="topDiff" class="badge badge-pill"></span>
            </div>
            <div class="tableCell right">
                <button style="margin-right: 15px" class="btn btn-outline-primary exit" href="#">Close</button>
            </div>
        </div>
        <div class="section2">
            <div class="loader" id="loader"></div>
            <iframe id="mainFrame" frameborder="0" sandbox="allow-same-origin allow-scripts allow-popups allow-forms"
                    style="width: 100%; height: 100%" src="" onerror="error('Failed to load');">
            </iframe>
        </div>
        <div class="section3 layout">
            <div class="tableCell bottomLeft">
                <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                    <img id="bottomStatus" alt='Status' style="vertical-align: top;" height="20px" width="20px"  src={{ asset('img/exclamation.png') }}>
                </a>
            </div>
            <div class="tableCell middle">
                <a id="bottomName" rel="noreferrer noopener nofollow"></a>
            </div>
            <div class="tableCell right">
                <button style="margin-right: 15px" class="btn btn-outline-primary nextRow">Next</button>
            </div>
        </div>
    </div>
    <div id="mainDiv" class="container" style="margin-top: 50px">
        <div>
            <form method="get" action="{{ action('DomainController@index') }}">
                <button type="button" class="btn btn-outline-primary" id="datePickerButton">
                    <input id="datePicker" name="date" type="text" onchange="this.form.submit()" style="height: 0; width: 0; border: 0;"/>
                    Pick a date
                </button>
            </form>
        </div>
        <div id="tablesDiv">
            <div>
                @if (isset($data[0]->diff))
                    <p class="tableHead">Since {{ $date }}</p>
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
                            @foreach($data as $row)
                                <tr>
                                    <td class="name">
                                        <a class="linkDate" href="{{ action('DomainController@show', [$row->name]) }}">{{$row->name}}</a>
                                        @if (isset($row->status) && !$row->status)
                                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                                <img alt='Status' style="vertical-align: top;" height="20px" width="20px"  src={{ asset('img/exclamation.png') }}>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="rank">{{$row->rank}}</td>
                                    @if (isset($row->diff))
                                        @if ($row->diff > 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-success">+{{$row->diff}}</span></td>
                                        @elseif ($row->diff < 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-danger">{{$row->diff}}</span></td>
                                        @elseif ($row->diff == 0)
                                            <td class="diff" align="left"><span class="badge badge-pill badge-primary">{{$row->diff}}</span></td>
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