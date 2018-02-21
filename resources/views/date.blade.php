@extends('layouts.app')

@section('content')
    @include('layouts.overlay')
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