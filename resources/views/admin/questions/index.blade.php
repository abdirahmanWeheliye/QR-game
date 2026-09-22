@extends('layouts.app')

@section('title', 'Vragen beheren')

@section('content')
    <h1>Vragen</h1>

    <p>
        <a href="{{ route('admin.questions.create') }}">+ Nieuwe vraag</a>
        ·
        <a href="{{ route('admin.questions.print') }}" target="_blank">Printvel met alle QR-codes</a>
    </p>

    @if ($questions->isEmpty())
        <p>Nog geen vragen aangemaakt.</p>
    @else
        <table style="width:100%; border-collapse:collapse;">
            <thead>
            <tr style="text-align:left; border-bottom:1px solid #d1d5db;">
                <th style="padding:8px 4px;">Titel</th>
                <th style="padding:8px 4px;">Type</th>
                <th style="padding:8px 4px;">Punten</th>
                <th style="padding:8px 4px;">Actief</th>
                <th style="padding:8px 4px;"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($questions as $question)
                <tr style="border-bottom:1px solid #e5e7eb;">
                    <td style="padding:8px 4px;">{{ $question->title }}</td>
                    <td style="padding:8px 4px;">{{ $question->type === 'open' ? 'Open' : 'Meerkeuze' }}</td>
                    <td style="padding:8px 4px;">{{ $question->points }}</td>
                    <td style="padding:8px 4px;">{{ $question->is_active ? 'Ja' : 'Nee' }}</td>
                    <td style="padding:8px 4px;">
                        <a href="{{ route('admin.questions.edit', $question) }}">Bewerken</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
