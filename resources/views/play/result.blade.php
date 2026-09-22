@extends('layouts.app')

@section('title', $question->title)

@section('content')

    <h1>{{ $question->title }}</h1>
    <p>{{ $question->body }}</p>

    <div style="margin-top:20px; padding:16px; border-radius:8px; background:{{ $submission->status === 'wrong' ? '#fee2e2' : '#d1fae5' }};">
        @if ($submission->status === 'pending')
            <p>Je antwoord is ingeleverd en wacht op beoordeling door de organisatie.</p>
            <p><strong>Jouw antwoord:</strong> {{ $submission->answer_text }}</p>
        @elseif ($submission->status === 'correct')
            <p><strong>Goed!</strong> +{{ $submission->points_awarded }} punten.</p>
        @else
            <p><strong>Helaas, dat was niet het juiste antwoord.</strong></p>
        @endif

        @if ($submission->feedback)
            <p style="margin-top:10px; font-style:italic;">{{ $submission->feedback }}</p>
        @endif
    </div>

    <p style="margin-top:20px;">
        <a href="{{ route('progress') }}">← Terug naar je voortgang</a>
    </p>

@endsection
