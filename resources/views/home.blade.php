@extends('layouts.app')

@section('content')
    @include('layouts.overlay')
    <div id='mainDiv' class='container'>
        <div class="row container">
            <div class="col-auto">
                <form method='get' action='{{ action('DomainController@index') }}'>
                    <button type='button' class='btn btn-outline-primary' id='datePickerButton'>
                        <input id='datePicker' name='date' type='text' onchange='this.form.submit()'/>
                        Pick a date
                    </button>
                </form>
            </div>
            <div class="col-auto ">
                @if($action === "UserController@favorites")
                    <button class="btn btn-outline-primary" id="multipleFavoriteButton">Add favorites</button>
                    <form id="multipleFavoritesForm" method='post' action='{{ action('UserController@multiple') }}'>
                        {{ csrf_field() }}
                        <div class="form-group" id="addFavoritesForm">
                            <label for="multipleFavorites">Specify domain names separated by newlines.</label>
                            <textarea name="multipleDomains" placeholder="E.g. google.com" class="form-control" id="multipleFavorites" rows="3"></textarea>
                            <button type='submit' class='btn btn-outline-primary' id='multipleFavoritesSubmit'>Add</button>
                        </div>
                    </form>
                @endif
            </div>
            <div class="col-auto mr-auto">
                <select id='tables' class='form-control'>
                    <option value='Day'>Day</option>
                    <option value='Week'>Week</option>
                    <option selected value='Month'>Month</option>
                </select>
            </div>
            <div class="col-auto order-first order-lg-last">
                <form method='post' action='{{ action('DomainController@search') }}'>
                    {{ csrf_field() }}
                    <div class="input-group" id="searchDomainForm">
                        <input name="name" type="text" class="form-control" placeholder="Search for domain" aria-label="Search for domain" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button type='submit' class='btn btn-outline-primary' id='searchButton'>Search</button>
                        </div>
                    </div>
                </form>
            </div>
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
                                    </tr>
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