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
        <div>
            <form method='get' action='{{ action($action) }}'>
                <button type='button' class='btn btn-outline-primary' id='datePickerButton'>
                    <input id='datePicker' name='date' type='text' onchange='this.form.submit()'/>
                    Pick a date
                </button>
            </form>
        </div>
        <div>
            <select id='tables' class='form-control'>
                <option value='Day'>Day</option>
                <option value='Week'>Week</option>
                <option selected value='Month'>Month</option>
            </select>
        </div>
        <div class="row justify-content-center" id='tablesDiv'>
            @if (isset($dataDay[0]->diff) && isset($dataDay[0]->diff) && isset($dataDay[0]->diff))
                <div class='dayTableDiv col-4'>
                    <p class='tableHead'>Day</p>
                    @if (isset($dataDay[0]->diff))
                        <p class='tableHead2'>Since {{ $yesterday }}</p>
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
                                @foreach($dataDay as $data)
                                    <tr>
                                        <td class='name'>
                                            <a class='link' href='{{ action('DomainController@show', [$data->name]) }}'>{{$data->name}}</a>
                                            @if (isset($data->status) && !$data->status)
                                                <img alt='Status' class='statusImg' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                            @endif
                                        </td>
                                        <td class='rank'>{{$data->rank}}</td>
                                        @if (isset($data->diff))
                                            @if ($data->diff > 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-success'>+{{$data->diff}}</span></td>
                                            @elseif ($data->diff < 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-danger'>{{$data->diff}}</span></td>
                                            @elseif ($data->diff == 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-primary'>{{$data->diff}}</span></td>
                                            @endif
                                        @else
                                            <td class='diff' align='left'><span class='badge badge-pill badge-warning'>N/A</span></td>
                                        @endif
                                    <td>
                                        <a class='preview' href='#'>Preview</a>
                                    </td>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class='tableHead' >Not Available</p>
                    @endif
                </div>
                <div class='weekTableDiv col-4'>
                    <p class='tableHead'>Week</p>
                    @if (isset($dataWeek[0]->diff))
                        <p class='tableHead2'>Since {{ $lastMonday }}</p>
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
                                @foreach($dataWeek as $data)
                                    <tr>
                                        <td class='name'>
                                            <a class='link' href='{{ action('DomainController@show', [$data->name]) }}'>{{$data->name}}</a>
                                            @if (isset($data->status) && !$data->status)
                                                <img alt='Status' class='statusImg' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                            @endif
                                        </td>
                                        <td class='rank'>{{$data->rank}}</td>
                                        @if (isset($data->diff))
                                            @if ($data->diff > 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-success'>+{{$data->diff}}</span></td>
                                            @elseif ($data->diff < 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-danger'>{{$data->diff}}</span></td>
                                            @elseif ($data->diff == 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-primary'>{{$data->diff}}</span></td>
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
                <div class='monthTableDiv col-4'>
                    <p class='tableHead'>Month</p>
                    @if (isset($dataMonth[0]->diff))
                        <p class='tableHead2'>Since {{ $firstMonthDay }}</p>
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
                                @foreach($dataMonth as $data)
                                    <tr>
                                        <td class='name'>
                                            <a class='link' href='{{ action('DomainController@show', [$data->name]) }}'>{{$data->name}}</a>
                                            @if (isset($data->status) && !$data->status)
                                                <img alt='Status' class='statusImg' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                            @endif
                                        </td>
                                        <td class='rank' align='left'>{{$data->rank}}</td>
                                        @if (isset($data->diff))
                                            @if ($data->diff > 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-success'>+{{$data->diff}}</span></td>
                                            @elseif ($data->diff < 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-danger'>{{$data->diff}}</span></td>
                                            @elseif ($data->diff == 0)
                                                <td class='diff' align='left'><span class='badge badge-pill badge-primary'>{{$data->diff}}</span></td>
                                            @endif
                                        @else
                                            <td class='diff' align='left'><span class='badge badge-pill badge-warning'>N/A</span></td>
                                        @endif
                                        <td class='preview'>
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
            @else
                <p class='tableHead' >No data to display</p>
            @endif
        </div>
    </div>
@endsection