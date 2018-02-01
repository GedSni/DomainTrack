<div>
    @if (isset($data[0]))
        <p class="tableHead">Since {{ $date }}</p>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>Domain</th>
                    <th>Rank</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $row)
                    <tr>
                        <td class="nameAndLinks">
                            <a class="link" href="{{ action('DomainController@show', [$row->name]) }}">{{$row->name}}</a>
                            <a class="similarwebLink" rel="noreferrer noopener nofollow" href="https://www.similarweb.com/website/{{$row->name}}">
                                <img alt="SimilarWeb" align="right" src={{ asset('img/similarweb.ico') }} width="25" height="25"></a>
                            <a class="alexaLink" rel="noreferrer noopener nofollow" href="https://www.alexa.com/siteinfo/{{$row->name}}">
                                <img alt="Alexa" align="right" src={{ asset('img/alexa2.ico') }} width="25" height="25"></a>
                            @if (isset($row->status) && !$row->status)
                                <a class='domainTooltip' data-toggle="tooltip" data-placement="right" title="Domain might not be available">
                                    <img alt='Status' style="vertical-align: top;" height="20px" width="20px"  src={{ asset('img/exclamation.png') }}>
                                </a>
                            @endif
                        </td>
                        <td class="rank">{{$row->rank}}</td>
                        @if (isset($row->diff))
                            @if ($row->diff > 0)
                                <td class="diff" align="left"><span class="badge badge-pill badge-success">+{{$row->diff}}</span></td>
                            @elseif ($row->diff < 0)
                                <td class="diff" align="left"><span class="badge badge-pill badge-danger">{{$row->diff}}</span></td>
                            @elseif ($row->diff == 0)
                                <td class="diff" align="left"><span class="badge badge-pill badge-primary">{{$row->diff}}</span></td>
                            @endif
                        @else
                            <td class="diff" align="left"><span class="badge badge-pill badge-warning">N/A</span></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="tableHead" >Not Available</p>
    @endif
</div>