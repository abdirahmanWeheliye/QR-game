<textarea name="answer_text" id="answer">{{ $submission->answer_text }}</textarea>

<script>
    const url = @json(route('play.draft', $question));
    const token = @json(csrf_token());
    const field = document.getElementById('answer');
    let timer;

    function save(useBeacon = false) {
        const body = new FormData();
        body.append('answer_text', field.value);
        body.append('_token', token);
        if (useBeacon && navigator.sendBeacon) {
            navigator.sendBeacon(url, body);
        } else {
            fetch(url, { method: 'POST', body, keepalive: true });
        }
    }

    field.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(save, 800);
    });

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') save(true);
    });
</script>
