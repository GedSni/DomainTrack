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
    <div class="col-xs-4">
        <p class="tableHead">Day</p>
        @if(isset($dataDay[0]))
            <p class="tableHead2">Updated {{ $dataDay[0]->day_update_date }}</p>
            <div class="table-responsive">
                <table class="table table-bordered table-curved table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-right">Rank</th>
                        <th class="text-right">Diff</th>
                        <th class="text-center">Links</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataDay); $i++)
                        <tr>
                            <td style="max-width: 100px; overflow-wrap: break-word;"><a rel="noreferrer noopener nofollow" href="http://www.{{$dataDay[$i]->name}}">{{$dataDay[$i]->name}}</a></td>
                            <td align="right">{{$dataDay[$i]->day_rank}}</td>
                            <td align="right">{{$dataDay[$i]->day_diff}}</td>
                            <td align="center">
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataDay[$i]->name}}">
                                    <img alt="Alexa" src={{ asset('img/alexa.ico') }} width="25" height="25"></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataDay[$i]->name}}">
                                    <img alt="SimilarWeb" src={{ asset('img/similarweb.ico') }} width="20" height="20"}}></a>
                            </td>
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
        <p class="tableHead" >Week</p>
        @if(isset($dataWeek[0]))
            <p class="tableHead2">Updated {{ $dataWeek[0]->week_update_date }}</p>
            <div class="table-responsive">
                <table class="table table-bordered table-curved table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-right">Rank</th>
                        <th class="text-right">Diff</th>
                        <th class="text-center">Links</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataWeek); $i++)
                        <tr>
                            <td style="max-width: 100px; overflow-wrap: break-word;"><a rel="noreferrer noopener nofollow" href="http://www.{{$dataWeek[$i]->name}}">{{$dataWeek[$i]->name}}</a></td>
                            <td align="right">{{$dataWeek[$i]->week_rank}}</td>
                            <td align="right">{{$dataWeek[$i]->week_diff}}</td>
                            <td align="center">
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataWeek[$i]->name}}">
                                    <img alt="Alexa" src={{ asset('img/alexa.ico') }} width="25" height="25"></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataWeek[$i]->name}}">
                                    <img alt="SimilarWeb" src={{ asset('img/similarweb.ico') }} width="20" height="20"}}></a>
                            </td>
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
        <p class="tableHead" >Month</p>
        @if(isset($dataMonth[0]))
            <p class="tableHead2">Updated {{ $dataMonth[0]->month_update_date }}</p>
            <div class="table-responsive">
                <table class="table table-bordered table-curved table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Domain</th>
                        <th class="text-right">Rank</th>
                        <th class="text-right">Diff</th>
                        <th class="text-center">Links</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($dataMonth); $i++)
                        <tr>
                            <td style="max-width: 100px; overflow-wrap: break-word;"><a rel="noreferrer noopener nofollow" href="http://www.{{$dataMonth[$i]->name}}">{{$dataMonth[$i]->name}}</a></td>
                            <td align="right">{{$dataMonth[$i]->month_rank}}</td>
                            <td align="right">{{$dataMonth[$i]->month_diff}}</td>
                            <td align="center">
                                <a rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$dataMonth[$i]->name}}">
                                    <img alt="Alexa" src={{ asset('img/alexa.ico') }} width="25" height="25"></a>
                                <a rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$dataMonth[$i]->name}}">
                                    <img alt="SimilarWeb" src={{ asset('img/similarweb.ico') }} width="20" height="20"}}></a>
                            </td>
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