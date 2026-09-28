@extends('layouts.app')

@section('title', 'Nakijken')

@section('content')

    <h1>Nakijken</h1>

    @if ($errors->any())
        <div style="background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:6px; margin-bottom:16px; font-size:14px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if ($submissions->isEmpty())
        <p style="color:#6b7280;">Er zijn geen antwoorden die op beoordeling wachten.</p>
    @else
        <p style="color:#6b7280;">{{ $submissions->count() }} antwoord(en) wachten op beoordeling.</p>

        @foreach ($submissions as $submission)
            <div style="background:white; border:1px solid #d1d5db; border-radius:8px; padding:16px; margin-bottom:16px;">
                <div style="font-size:13px; color:#6b7280;">
                    {{ $submission->student->name ?: 'Student' }} ({{ $submission->student->student_number }})
                    · {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d-m H:i') }}
                </div>

                <h2 style="font-size:16px; margin:6px 0;">{{ $submission->question->title }}</h2>
                <p style="margin:0 0 10px; color:#374151;">{{ $submission->question->body }}</p>

                <blockquote style="margin:0 0 14px; padding:10px 12px; background:#f3f4f6; border-left:4px solid #4f46e5; white-space:pre-wrap;">{{ $submission->answer_text }}</blockquote>

                <form method="POST" action="{{ route('admin.review.update', $submission) }}">
                    @csrf
                    @method('PATCH')

                    <label style="font-size:13px; font-weight:600;">Punten (max {{ $submission->question->points }})</label>
                    <input type="number" name="points_awarded" min="0" max="{{ $submission->question->points }}"
                           value="{{ $submission->question->points }}"
                           style="width:80px; padding:6px; margin:0 0 10px 6px;">

                    <textarea name="feedback" rows="2" placeholder="Feedback voor de student (optioneel)"
                              style="width:100%; padding:8px; margin-bottom:10px;"></textarea>

                    <button type="submit" name="decision" value="correct"
                            style="padding:8px 16px; background:#059669; color:white; border:none; border-radius:6px; cursor:pointer;">
                        ✓ Goedkeuren
                    </button>
                    <button type="submit" name="decision" value="wrong"
                            style="padding:8px 16px; background:#dc2626; color:white; border:none; border-radius:6px; cursor:pointer;">
                        ✗ Afkeuren
                    </button>
                </form>
            </div>
        @endforeach
    @endif

@endsection
