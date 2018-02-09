@extends('layouts.app')

@section('content')
    <div class='container buttons'>
        <button id='back' class='btn btn-outline-primary' >Back</button>
        @auth
            @if($data->isFavorited)
                <svg class="heart filled" width="45" height="30" id="heart" viewBox="-5 0 50 30">
                    <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2
            c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z"/><a href='{{ action('DomainController@unfavorite', [$data[0]->name]) }}'></a>
                </svg>
            @else
                <svg class="heart" width="45" height="30" id="heart" viewBox="-5 0 50 30">
                    <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2
            c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z"/><a href='{{ action('DomainController@favorite', [$data[0]->name]) }}'></a>
                </svg>
            @endif
        @endauth
    </div>
    <div class='container'>
        @if (isset($data[0]))
        <div>
            <h1>Domain information</h1>
            <table class='table'>
                <tbody>
                <tr>
                    <th>Name</th>
                    <td><a rel='noreferrer noopener nofollow' href='http://{{ $data[0]->name }}'>{{ $data[0]->name }}</a></td>
                </tr>
                <tr>
                    <th>Status</th>
                    @if (!isset($data[0]->status))
                        <td>
                            <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Status is unknown'>
                                <span class='badge badge-pill badge-warning'>N/A</span>
                            </a>
                        </td>
                    @elseif ($data[0]->status == 1)
                        <td>
                            <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Domain is working properly'>
                                <span class='badge badge-pill badge-success'>✓</span>
                            </a>
                        </td>
                    @elseif ($data[0]->status == 0)
                        <td>
                            <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Domain might not be available'>
                                <img alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
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
        <div id='historyChart'>
            @linechart('History', 'historyChart')
        </div>
        <div>
            <h1>WhoIs Information</h1>
            @if (isset($keys))
            <table class='table'>
                <tbody>
                @for($i = 0; $i < count($keys); $i++)
                    <tr>
                        <th>{{ $keys[$i] }}</th>
                        <td>{{ $values[$i] }}</td>
                    </tr>
                @endfor
                </tbody>
            </table>
            @else
                <h3>Not available</h3>
            @endif
        </div>
        @else
            <h1>Not available</h1>
        @endif
    </div>
@endsection