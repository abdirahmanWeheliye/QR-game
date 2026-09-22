@extends('layouts.app')

@section('title', 'Spel niet actief')

@section('content')

    <h1>Het spel is momenteel niet actief</h1>

    @if ($status === 'paused')
        <p>Het spel is tijdelijk gepauzeerd door de organisatie. Probeer het straks opnieuw.</p>
    @elseif ($status === 'finished')
        <p>Het spel is afgelopen. Bedankt voor het meedoen!</p>
    @else
        <p>Het spel is nog niet gestart. Wacht tot de organisatie begint.</p>
    @endif

    <p><a href="{{ route('progress') }}">← Terug naar je voortgang</a></p>

@endsection
