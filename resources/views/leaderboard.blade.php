@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')

    <h1>Leaderboard</h1>

    @if ($ranking->isEmpty())
        <p style="color:#6b7280;">Nog geen deelnemers.</p>
    @else
        <table style="width:100%; border-collapse:collapse; background:white;">
            <thead>
            <tr style="text-align:left; border-bottom:1px solid #d1d5db;">
                <th style="padding:10px;">#</th>
                <th style="padding:10px;">Deelnemer</th>
                <th style="padding:10px; text-align:right;">Punten</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($ranking as $row)
                @php $isMe = $row->id === $student->id; @endphp
                <tr style="border-bottom:1px solid #e5e7eb; {{ $isMe ? 'background:#eef2ff; font-weight:700;' : '' }}">
                    <td style="padding:10px;">{{ $row->rank }}</td>
                    <td style="padding:10px;">{{ $row->display_name }}{{ $isMe ? ' (jij)' : '' }}</td>
                    <td style="padding:10px; text-align:right;">{{ $row->points }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    {{-- Ververst zichzelf, handig als je hem tijdens de demo open laat staan --}}
    <script>setTimeout(() => location.reload(), 15000);</script>

@endsection
