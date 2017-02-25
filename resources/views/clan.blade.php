@extends('layouts.app')

@section('title')
    {{ $clan->name }}
@endsection

@section('content')
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
    @foreach($players as $player)
        <tr>
            <td>{{ $nr++ }}</td>
            <td><a href="{{ $player->getLink() }}">{{ $player->name }}</a></td>
            <td>{{ $player->total_score }}</td>
            <td>{{ $player->total_kills }}</td>
            <td>{{ $player->total_deaths }}</td>
        </tr>
    @endforeach

        </tbody>
    </table>
@endsection

@section('right')
    <h2>{{ $clan->name }} clan stats</h2>
    <p>
        Members: <strong>{{ $clan->players->count() }}</strong><br />
        Total score: <strong>{{ $clan->players->sum('total_score') }}</strong><br />
        Total kills: <strong>{{ $clan->players->sum('total_kills') }}</strong><br />
        Total deaths: <strong>{{ $clan->players->sum('total_deaths') }}</strong><br />
        First seen <abbr title="{{ $clan->created_at->format('Y-m-d') }}"><strong>{{ $clan->created_at->diffForHumans() }}</strong></abbr><br />
    </p>
@endsection