@extends('layouts.app')

@section('title')
    {{ $player->full_name }}
@endsection

@section('content')
    @if($player->clan)
        <div class="clear" xmlns="http://www.w3.org/1999/html"></div>
    <p><strong>{{ $player->name }}</strong> is a member of <a href="{{ $player->clan->getLink() }}">{{ $player->clan->name }}</a> clan, and its members are:</p>
    <table align="center">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Total score</th>
                <th>Total kills</th>
                <th>Total deaths</th>
            </tr>
        </thead>
        <tbody>
    <?php $nr = 1; ?>
    @foreach($clanPlayers as $clanPlayer)
        <tr class=" @if($clanPlayer->id == $player->id) highlight @endif ">
            <td>{{ $nr++ }}</td>
            <td><a href="{{ $clanPlayer->getLink() }}">{{ $clanPlayer->name }}</a></td>
            <td>{!! $clanPlayer->formatScoreHtml('total_score') !!}</td>
            <td>{!! $clanPlayer->formatScoreHtml('total_kills') !!}</td>
            <td>{!! $clanPlayer->formatScoreHtml('total_deaths') !!}</td>
        </tr>
    @endforeach

        </tbody>
    </table>
    @else
        <p>This player does not belong to any clan.</p>
    @endif
@endsection

@section('right')
    <h2>{{ $player->name }} stats</h2>
    <div class="clear"></div>

    <p>
        <img data-hash="{{ md5($player->name) }}" src="https://vanillicon.com/{{ md5($player->name) }}.png" alt="{{ $player->name }}'s avatar" class="avatar">
        Total score: <strong>{!! $player->formatScoreHtml('total_score') !!}</strong><br />
        Total kills: <strong>{!! $player->formatScoreHtml('total_kills') !!}</strong><br />
        Total deaths: <strong>{!! $player->formatScoreHtml('total_deaths') !!}</strong><br />
        K/D ratio: <strong>{{ $player->total_deaths == 0 ? $player->total_kills : round($player->total_kills/$player->total_deaths, 2) }}</strong><br />
        Total played: <abbr title="{{ round($player->minutes_played / 60, 1) }} hour(s)"><strong>~{{ Carbon\Carbon::now()->addMinutes($player->minutes_played)->diffForHumans(null, true) }}</strong></abbr><br />
        Games played: <strong>{{ $player->games_played }}</strong><br />
        First seen <abbr title="{{ $player->created_at->format('Y-m-d') }}"><strong>{{ $player->created_at->diffForHumans() }}</strong></abbr><br />
        @if(!$player->wasSeenRecently())
            Last seen <abbr title="{{ $player->updated_at->format('Y-m-d') }}"><strong>{{ $player->updated_at->diffForHumans() }}</strong></abbr> on
            <a href="{{ $player->server->getLink() }}">{{ $player->server->name }}</a><br />
        @endif
    </p>

    @if($player->wasSeenRecently())
        <hr />

        <h3>Currently playing</h3>
        <p>
            <img src="{{ $player->server->getLastMapImageUrl() }}" class="pr-map" alt="{{ $player->server->last_map }}" title="{{ $player->server->last_map }}"><br />
            Server: <strong><a href="{{ $player->server->getLink() }}">{{ $player->server->name }}</a></strong><br />
            Map: <strong>{{ $player->server->last_map }}</strong><br />
            Players (free): <strong>{{ $player->server->num_players }}</strong> (<strong>{{ ($player->server->max_players-$player->server->reserved_slots)-$player->server->num_players }}</strong>)<br />
            Team 1: <strong>{{ $player->server->team1_name }}</strong> (<abbr title="score / kills / deaths">{{ $player->server->team1_score }}/{{ $player->server->team1_kills }}/{{ $player->server->team1_deaths }}</abbr>)<br />
            Team 2: <strong>{{ $player->server->team2_name }}</strong> (<abbr title="score / kills / deaths">{{ $player->server->team2_score }}/{{ $player->server->team2_kills }}/{{ $player->server->team2_deaths }}</abbr>)<br />
        </p>
    @endif

    <div class="clear"></div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            cheet('u n i c o r n', function () {
                $('.avatar').each(function() {
                    var $this = $(this);
                    var hash = $this.data('hash');
                    $this.attr('src', 'http://unicornify.appspot.com/avatar/'+hash+'?s=100');
                });
            });
        });

    </script>
@endsection