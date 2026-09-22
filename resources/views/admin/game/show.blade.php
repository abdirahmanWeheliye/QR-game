@extends('layouts.app')

@section('title', 'Spelbesturing')

@section('content')

    <h1>Spelbesturing</h1>

    <p style="margin-bottom:20px;">
        Huidige status:
        <strong>
            @if ($status === 'running') Actief
            @elseif ($status === 'paused') Gepauzeerd
            @elseif ($status === 'finished') Afgelopen
            @else Nog niet gestart
            @endif
        </strong>
    </p>

    <form method="POST" action="{{ route('admin.game.update') }}" style="display:flex; gap:10px; flex-wrap:wrap;">
        @csrf
        @method('PATCH')

        <button type="submit" name="status" value="running"
                style="padding:10px 18px; background:#059669; color:white; border:none; border-radius:6px; cursor:pointer;">
            ▶ Starten
        </button>

        <button type="submit" name="status" value="paused"
                style="padding:10px 18px; background:#d97706; color:white; border:none; border-radius:6px; cursor:pointer;">
            ⏸ Pauzeren
        </button>

        <button type="submit" name="status" value="finished"
                style="padding:10px 18px; background:#dc2626; color:white; border:none; border-radius:6px; cursor:pointer;">
            ⏹ Stoppen
        </button>
    </form>

@endsection
