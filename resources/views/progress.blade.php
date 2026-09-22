@extends('layouts.app')

@section('title', 'Mijn voortgang')

@section('content')

    <h1>Mijn voortgang</h1>

    <div style="display:flex; gap:16px; margin-bottom:24px; flex-wrap:wrap;">
        <div style="background:white; border:1px solid #d1d5db; border-radius:8px; padding:16px; flex:1; min-width:120px;">
            <div style="font-size:28px; font-weight:700;">{{ $points }}</div>
            <div style="color:#6b7280; font-size:13px;">punten</div>
        </div>
        <div style="background:white; border:1px solid #d1d5db; border-radius:8px; padding:16px; flex:1; min-width:120px;">
            <div style="font-size:28px; font-weight:700;">{{ $done }} / {{ $total }}</div>
            <div style="color:#6b7280; font-size:13px;">vragen beantwoord</div>
        </div>
        @if ($pending > 0)
            <div style="background:#fef3c7; border:1px solid #fbbf24; border-radius:8px; padding:16px; flex:1; min-width:120px;">
                <div style="font-size:28px; font-weight:700;">{{ $pending }}</div>
                <div style="color:#92400e; font-size:13px;">wachten op nakijken</div>
            </div>
        @endif
    </div>

    <h2 style="font-size:16px;">Beantwoorde vragen</h2>

    @if ($submissions->isEmpty())
        <p style="color:#6b7280;">Je hebt nog geen vragen beantwoord. Scan een QR-code om te beginnen.</p>
    @else
        <table style="width:100%; border-collapse:collapse;">
            <thead>
            <tr style="text-align:left; border-bottom:1px solid #d1d5db;">
                <th style="padding:8px 4px;">Vraag</th>
                <th style="padding:8px 4px;">Status</th>
                <th style="padding:8px 4px;">Punten</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($submissions as $submission)
                <tr style="border-bottom:1px solid #e5e7eb;">
                    <td style="padding:8px 4px;">
                        <a href="{{ route('play.show', $submission->question) }}">{{ $submission->question->title }}</a>
                    </td>
                    <td style="padding:8px 4px;">
                        @if ($submission->status === 'pending') Wachtend op nakijken
                        @elseif ($submission->status === 'correct') Goed
                        @elseif ($submission->status === 'wrong') Fout
                        @else {{ $submission->status }}
                        @endif
                    </td>
                    <td style="padding:8px 4px;">{{ $submission->points_awarded }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

@endsection
