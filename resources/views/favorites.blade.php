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
            <div>
                <p class='tableHead'>Your Favorites</p>
                <div>
                    <table align="center" style=" width: 40%;" class='table'>
                        <thead>
                        <tr>
                            <th>Domain</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td class='name'>
                                    <a class='linkDate' href='{{ action('DomainController@show', [$row->name]) }}'>{{$row->name}}</a>
                                    @if (isset($row->status) && !$row->status)
                                        <a class='domainTooltip' data-toggle='tooltip' data-placement='right' title='Domain might not be available'>
                                            <img class='statusImg' alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                                        </a>
                                    @endif
                                </td>
                                <td style="text-align: right">
                                    <a class='preview' href='#'>Preview</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection