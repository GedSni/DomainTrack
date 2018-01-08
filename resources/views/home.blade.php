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
    <div class="tableDiv">
        <p class="tableHead">Day</p>
        @if(isset($dataDay[0]))
            <p class="tableHead2">Updated {{ $dataDay[0]->day_update_date }}</p>
            <div class="table-responsive">
                <table class="table">
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
                            <td>
                                <a rel="noreferrer noopener nofollow" href="http://www.{{$dataDay[$i]->name}}">{{$dataDay[$i]->name}}</a>
                                @if (isset($dataDay[$i]->info) && $dataDay[$i]->info['state'] == 'rejected')
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                @endif
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataDay[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataDay[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                            </td>
                            <td align="right">{{$dataDay[$i]->day_rank}}</td>
                            <td align="right">{{$dataDay[$i]->day_diff}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @else
            <p class="tableHead" >Not Available</p>
        @endif
    </div>
    <div class="tableDiv">
        <p class="tableHead" >Week</p>
        @if(isset($dataWeek[0]))
            <p class="tableHead2">Updated {{ $dataWeek[0]->week_update_date }}</p>
            <div class="table-responsive">
                <table class="table">
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
                            <td>
                                <a rel="noreferrer noopener nofollow" href="http://www.{{$dataWeek[$i]->name}}">{{$dataWeek[$i]->name}}</a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataWeek[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataWeek[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                            </td>
                            <td align="right">{{$dataWeek[$i]->day_rank}}</td>
                            <td align="right">{{$dataWeek[$i]->week_diff}}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @else
            <p class="tableHead" >Not Available</p>
        @endif
    </div>
    <div class="tableDiv">
        <p class="tableHead" >Month</p>
        @if(isset($dataMonth[0]))
            <p class="tableHead2">Updated {{ $dataMonth[0]->month_update_date }}</p>
            <div class="table-responsive">
                <table class="table">
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
                            <td>
                                <a rel="noreferrer noopener nofollow" href="http://www.{{$dataMonth[$i]->name}}">{{$dataMonth[$i]->name}}</a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonth[$i]->name}}">
                                    <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"}}></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonth[$i]->name}}">
                                    <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                            </td>
                            <td align="right">{{$dataMonth[$i]->day_rank}}</td>
                            <td align="right">{{$dataMonth[$i]->month_diff}}</td>
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