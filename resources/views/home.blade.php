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
        Hello
    </div>
@endsection