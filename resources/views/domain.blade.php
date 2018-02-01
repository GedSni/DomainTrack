@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 20px; margin-bottom: 20px">
        <button class="btn btn-outline-primary" id="back" title="Back">Back</button>
    </div>
    <div class="container">
        <div>
            <h1>Domain information</h1>
            <table class="table">
                <tbody>
                <tr>
                    <th>Name</th>
                    <td><a rel="noreferrer noopener nofollow" href="http://{{ $data[0]->name }}">{{ $data[0]->name }}</a></td>
                </tr>
                <tr>
                    <th>Status</th>
                    @if ($data[0]->status == 1)
                        <td>
                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain is working properly">
                                STATUS
                            </a>
                        </td>
                    @else
                        <td>
                            <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                               STATUS
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
                        @if (isset($domain->delta))
                            @if ($domain->delta > 0)
                                <td><span class="badge badge-pill badge-success">+{{$domain->delta}}</span></td>
                            @elseif ($domain->delta < 0)
                                <td><span class="badge badge-pill badge-danger">{{$domain->delta}}</span></td>
                            @else
                                <td><span class="badge badge-pill badge-primary">{{$domain->delta}}</span></td>
                            @endif
                        @else
                            <td><span class="badge badge-pill badge-warning">Not available</span></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id="historyChart">@linechart('History', 'historyChart')</div>
    </div>
@endsection