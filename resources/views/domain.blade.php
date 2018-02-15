@extends('layouts.app')

@section('content')
    <div class='container'>
        @if (isset($data[0]))
            <div>
                @auth
                    @if (isset($data[0]))
                        @if($data->isFavorited)
                            <button class="btn btn-primary following followButton">Following</button>
                        @else
                            <button class="btn btn-outline-primary followButton">+ Follow</button>
                        @endif
                    @endif
                @endauth
                <h1>Domain information</h1>
                <table class='table'>
                    <tbody>
                    <tr>
                        <th>Id</th>
                        <td id="domainId">{{ $data[0]->domain_id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><a rel='noreferrer noopener nofollow' href='http://{{ $data[0]->name }}'>{{ $data[0]->name }}</a></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        @if (!isset($data[0]->status))
                            <td>
                                <span class='badge badge-pill badge-warning'>N/A</span>
                            </td>
                        @elseif ($data[0]->status == 1)
                            <td>
                                <span class='badge badge-pill badge-success'>✓</span>
                            </td>
                        @elseif ($data[0]->status == 0)
                            <td>
                                <img alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
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
                    <tr>
                        <th>Links</th>
                        <td>
                            <a class='similarwebLink' rel='noreferrer noopener nofollow' href='https://www.similarweb.com/website/{{$data[0]->name}}'>
                                <img alt='SimilarWeb' src={{ asset('img/similarweb.ico') }} width='25' height='25'></a>
                            <a class='alexaLink' rel='noreferrer noopener nofollow' href='https://www.alexa.com/siteinfo/{{$data[0]->name}}'>
                                <img alt='Alexa' src={{ asset('img/alexa2.ico') }} width='25' height='25'></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
                <hr>
            <div>
                <h1>Rank history</h1>
                <table class='table'>
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
                                    <td><span class='badge badge-pill badge-success'>+{{$domain->delta}}</span></td>
                                @elseif ($domain->delta < 0)
                                    <td><span class='badge badge-pill badge-danger'>{{$domain->delta}}</span></td>
                                @else
                                    <td><span class='badge badge-pill badge-primary'>{{$domain->delta}}</span></td>
                                @endif
                            @else
                                <td><span class='badge badge-pill badge-warning'>N/A</span></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                <hr>
            <div id='historyChart'>
                @linechart('History', 'historyChart')
            </div>
                <hr>
            <div>
                <h1>WhoIs Information</h1>
                <div class="card">
                    <ul class="list-group list-group-flush">
                        @if (!isset($whoIs) || $whoIs !== 'Not available')
                            @foreach($whoIs as $line)
                                <li class="list-group-item">{{ $line }}</li>
                            @endforeach
                        @else
                            <li class="list-group-item">Not available</li>
                        @endif
                    </ul>
                </div>
            </div>
        @else
            <h1 align="center">Not available</h1>
        @endif
    </div>
@endsection