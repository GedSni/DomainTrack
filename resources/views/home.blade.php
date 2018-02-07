@extends('layouts.app')

@section('content')
    <div class='overlay'>
        <div class='section1 layout'>
            <div class='tableCell topLeft'>
                <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Domain might not be available'>
                    <img id='topStatus' alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                </a>
            </div>
            <div class='tableCell cell'>
                <a id='topName' rel='noreferrer noopener nofollow'></a>
            </div>
            <div class='tableCell cell'>
                <p id='topRank'></p>
            </div>
            <div class='tableCell cell'>
                <span id='topDiff' class='badge badge-pill'></span>
            </div>
            <div class='tableCell right'>
                <button class='btn btn-outline-primary exit' href='#'>Close</button>
            </div>
        </div>
        <div class='section2'>
            <div id='loader'></div>
            <iframe id='mainFrame' frameborder='0' sandbox='allow-same-origin allow-scripts allow-popups allow-forms'
                    src='' onerror="error('Failed to load');">
            </iframe>
        </div>
        <div class='section3 layout'>
            <div class='tableCell bottomLeft'>
                <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Domain might not be available'>
                    <img id='bottomStatus' alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                </a>
            </div>
            <div class='tableCell middle'>
                <a id='bottomName' rel='noreferrer noopener nofollow'></a>
            </div>
            <div class='tableCell right'>
                <button class='btn btn-outline-primary nextRow'>Next</button>
            </div>
        </div>
    </div>
    <div id='mainDiv' class='container'>
        <div>
            <select id='tables' class='form-control'>
                <option value='Day'>Day</option>
                <option value='Week'>Week</option>
                <option selected value='Month'>Month</option>
            </select>
            <form method='get' action='{{ action('DomainController@index') }}'>
                <button type='button' class='btn btn-outline-primary' id='datePickerButton'>
                    <input id='datePicker' name='date' type='text' onchange='this.form.submit()'/>
                    Pick a date
                </button>
            </form>
        </div>
        <div id='tablesDiv'>
            <div class='dayTableDiv'>
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
                                            <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Domain might not be available'>
                                                <img alt='Status' class='statusImg' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                            </a>
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
            <div class='weekTableDiv'>
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
                                            <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Domain might not be available'>
                                                <img alt='Status' class='statusImg' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                            </a>
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
            <div class='monthTableDiv'>
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
                                            <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Domain might not be available'>
                                                <img alt='Status' class='statusImg' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                            </a>
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
        </div>
    </div>
@endsection