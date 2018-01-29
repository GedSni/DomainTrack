@extends('layouts.app')

@section('content')
    <div id="loading-wrapper">
        <div id="loading-content"></div>
    </div>
    <div class="container">
        <div>
            <h1>Domain information</h1>
            <table class="table">
                <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $data[0]->name }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    @if ($data[0]->status == 1)
                        <td>
                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain is working properly">
                                <span class="glyphicon glyphicon-ok status" aria-hidden="true"></span>
                            </a>
                        </td>
                    @else
                        <td>
                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                <span class="glyphicon glyphicon-exclamation-sign status" aria-hidden="true"></span>
                            </a>
                        </td>
                    @endif
                </tr>
                <tr>
                    <th>Tracking since</th>
                    <td>{{ $data->startDate }}</td>
                </tr>
                <tr>
                    <th>Current rank</th>
                    <td>{{ $data[0]->rank }}</td>
                </tr>
                <tr>
                    <th>Highest rank</th>
                    <td>{{ $data->minRank }}</td>
                </tr>
                <tr>
                    <th>Lowest rank</th>
                    <td>{{ $data->maxRank }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h1>Rank history</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Rank</th>
                        <th>Delta</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $domain)
                    <tr>
                        <td>{{ $domain->date }}</td>
                        <td>{{ $domain->rank }}</td>
                        @if ($domain->delta > 0)
                            <td><span class="label label-success">+{{$domain->delta}}</span></td>
                        @elseif ($domain->delta < 0)
                            <td><span class="label label-danger">{{$domain->delta}}</span></td>
                        @else
                            <td><span class="label label-default">{{$domain->delta}}</span></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id="historyChart">@linechart('History', 'historyChart')</div>
    </div>
@endsection