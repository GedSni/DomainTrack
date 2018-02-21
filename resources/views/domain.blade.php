@extends('layouts.app')

@section('content')

    <div class="container">
        @if (isset($data[0]))
            <div class="row">
                <nav class="col-md-2 d-none d-md-block sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column nav-pills ">
                            <li class="nav-item">
                                <a class="nav-link" href="#domainInformation">Domain information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#rankHistory">Rank history</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#whoIs">WhoIs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#dnsInformation">DNS information</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    @auth
                        @if($data->isFavorited)
                            <button data-id="{{ $data[0]->domain_id }}" class="btn btn-primary following followButton">Following</button>
                        @else
                            <button data-id="{{ $data[0]->domain_id }}" class="btn btn-outline-primary followButton">+ Follow</button>
                        @endif
                    @endauth
                    <hr>
                    <h1 id="domainInformation">Domain information</h1>
                    <table class='table'>
                        <tbody>
                        <tr>
                            <th>Name</th>
                            <td><a rel='noreferrer noopener nofollow' href='http://{{ $data[0]->name }}'>{{ $data[0]->name }}</a></td>
                        </tr>
                        <tr>
                            <th>Is it down</th>
                            @if (!isset($data[0]->status))
                                <td>
                                    <span class='badge badge-pill badge-warning'>N/A</span>
                                </td>
                            @elseif ($data[0]->status == 1)
                                <td>
                                    <span class='badge badge-pill badge-success'>✓</span>
                                    Online
                                </td>
                            @elseif ($data[0]->status == 0)
                                <td>
                                    <img alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                    Offline
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
                    <hr>
                    <h1 id="rankHistory">Rank history</h1>
                    <div id='historyChart'>
                        @linechart('History', 'historyChart')
                    </div>
                    <hr>
                    <div>
                        <h1 id="whoIs">WhoIs Information</h1>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                @if (isset($whoIs) && $whoIs !== 'Not available')
                                    @foreach($whoIs as $line)
                                        <li class="list-group-item">{{ $line }}</li>
                                    @endforeach
                                @else
                                    <li class="list-group-item">Not available</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <h1 id="dnsInformation">DNS information</h1>
                        @if (isset($data->dns))
                            <table class='table'>
                                <thead>
                                <tr>
                                    <th>Host</th>
                                    <th>Class</th>
                                    <th>TTL</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->dns as $array)
                                        <tr>
                                            <td>
                                                @if(isset($array['host']))
                                                    {{$array['host']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($array['class']))
                                                    {{$array['class']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($array['ttl']))
                                                    {{$array['ttl']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($array['type']))
                                                    {{$array['type']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($array['target']))
                                                    {{$array['target']}}
                                                @elseif(isset($array['ip']))
                                                    {{$array['ip']}}
                                                @elseif(isset($array['mname']) && isset($array['rname']))
                                                    {{$array['mname']}}, {{$array['rname']}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4>Not available</h4>
                        @endif
                        </ul>
                    </div>
                </main>
            </div>
        @else
            <h4 align="center">Not available</h4>
        @endif
    </div>
@endsection