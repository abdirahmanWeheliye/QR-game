@extends('layouts.app')

@section('title', $question->title)

@section('content')

    <h1>{{ $question->title }}</h1>
    <p>{{ $question->body }}</p>
    <p style="color:#6b7280; font-size:14px;">Waard: {{ $question->points }} punten</p>

    @if ($question->type === 'multiple_choice')

        <form method="POST" action="{{ route('play.submit', $question) }}">
            @csrf

            @foreach ($question->options as $index => $option)
                <label style="display:block; margin-bottom:10px; padding:10px; border:1px solid #d1d5db; border-radius:6px; cursor:pointer;">
                    <input type="radio" name="selected_option" value="{{ $index }}" required>
                    {{ $option }}
                </label>
            @endforeach

            <button type="submit"
                    style="margin-top:10px; padding:10px 20px; background:#4f46e5; color:white; border:none; border-radius:6px; cursor:pointer;">
                Antwoord versturen
            </button>
        </form>

    @else

        <form method="POST" action="{{ route('play.submit', $question) }}">
            @csrf

            <textarea name="answer_text" id="answer" rows="6" required
                      placeholder="Typ hier je antwoord..."
                      style="width:100%; padding:10px; font-size:15px; border:1px solid #d1d5db; border-radius:6px; margin-bottom:10px;">{{ $submission->answer_text }}</textarea>

            <button type="submit"
                    style="padding:10px 20px; background:#4f46e5; color:white; border:none; border-radius:6px; cursor:pointer;">
                Antwoord definitief versturen
            </button>
        </form>

        <script>
            const draftUrl = @json(route('play.draft', $question));
            const token = @json(csrf_token());
            const field = document.getElementById('answer');
            let timer;

            function saveDraft(useBeacon = false) {
                const body = new FormData();
                body.append('answer_text', field.value);
                body.append('_token', token);
                if (useBeacon && navigator.sendBeacon) {
                    navigator.sendBeacon(draftUrl, body);
                } else {
                    fetch(draftUrl, { method: 'POST', body, keepalive: true });
                }
            }

            field.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(saveDraft, 800);
            });

            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'hidden') saveDraft(true);
            });
        </script>

    @endif

@endsection
