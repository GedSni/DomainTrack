@extends('layouts.app')

@section('content')
    <div class='overlay'>
        <div class='section1 layout'>
            <div class="container">
                <div class="row">
                    <div>
                        <img style="float: right" id='topStatus' alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                    </div>
                    <div class="col-4">
                        <a id='topName' rel='noreferrer noopener nofollow'></a>
                    </div>
                    <div class="col-2">
                        <p id='topRank'></p>
                    </div>
                    <div class="col-2">
                        <span id='topDiff' class='badge badge-pill'></span>
                    </div>
                    <div class="col">
                        <button class='btn btn-outline-primary exit' href='#'>Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class='section2'>
            <div id='loader'></div>
            <iframe id='mainFrame' frameborder='0' sandbox='allow-same-origin allow-scripts allow-popups allow-forms'
                    src='' onerror="error('Failed to load');">
            </iframe>
        </div>
        <div class='section3 layout'>
            <div class="container">
                <div class="row justify-content-end">
                    <div>
                        <img style="float: right" id='bottomStatus' alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                    </div>
                    <div class="col-4">
                        <a id='bottomName' rel='noreferrer noopener nofollow'></a>
                    </div>
                    <div class="col-6">
                        <button class='btn btn-outline-primary nextRow'>Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='mainDiv' class='container'>
        <div id='tablesDiv'>
            <div>
                @if (isset($data[0]->diff))
                    <p class='tableHead'>Since {{ $date }}</p>
                    <div>
                        <table class='table'>
                            <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Rank</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td class='name'>
                                        <a class='linkDate' href='{{ action('DomainController@show', [$row->name]) }}'>{{$row->name}}</a>
                                        @if (isset($row->status) && !$row->status)
                                            <img class='statusImg' alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                        @endif
                                    </td>
                                    <td class='rank'>{{$row->rank}}</td>
                                    @if (isset($row->diff))
                                        @if ($row->diff > 0)
                                            <td class='diff' align='left'><span class='badge badge-pill badge-success'>+{{$row->diff}}</span></td>
                                        @elseif ($row->diff < 0)
                                            <td class='diff' align='left'><span class='badge badge-pill badge-danger'>{{$row->diff}}</span></td>
                                        @elseif ($row->diff == 0)
                                            <td class='diff' align='left'><span class='badge badge-pill badge-primary'>{{$row->diff}}</span></td>
                                        @endif
                                    @else
                                        <td class='diff' align='left'><span class='badge badge-pill badge-warning'>N/A</span></td>
                                    @endif
                                    <td>
                                        <a class='preview' href='#'>Preview</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class='tableHead' >Not Available</p>
                @endif
            </div>
        </div>
    </div>
@endsection