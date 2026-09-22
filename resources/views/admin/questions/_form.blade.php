<form method="POST" action="{{ $question ? route('admin.questions.update', $question) : route('admin.questions.store') }}">
    @csrf
    @if ($question) @method('PUT') @endif

    <label style="display:block; font-weight:600; margin-bottom:6px;">Titel</label>
    <input type="text" name="title" value="{{ old('title', $question->title ?? '') }}" required
           style="width:100%; padding:8px; margin-bottom:14px;">

    <label style="display:block; font-weight:600; margin-bottom:6px;">Vraag / opdracht</label>
    <textarea name="body" rows="3" required
              style="width:100%; padding:8px; margin-bottom:14px;">{{ old('body', $question->body ?? '') }}</textarea>

    <label style="display:block; font-weight:600; margin-bottom:6px;">Type</label>
    <select name="type" required style="width:100%; padding:8px; margin-bottom:14px;">
        <option value="multiple_choice" {{ old('type', $question->type ?? '') === 'multiple_choice' ? 'selected' : '' }}>Meerkeuze</option>
        <option value="open" {{ old('type', $question->type ?? '') === 'open' ? 'selected' : '' }}>Open vraag</option>
    </select>

    <label style="display:block; font-weight:600; margin-bottom:6px;">Opties (één per regel, alleen voor meerkeuze)</label>
    <textarea name="options_raw" rows="4" placeholder="Optie A&#10;Optie B&#10;Optie C"
              style="width:100%; padding:8px; margin-bottom:14px;">{{ old('options_raw', isset($question) && $question->options ? implode("\n", $question->options) : '') }}</textarea>

    <label style="display:block; font-weight:600; margin-bottom:6px;">Index juiste antwoord (0 = eerste optie, alleen meerkeuze)</label>
    <input type="number" name="correct_option" min="0" value="{{ old('correct_option', $question->correct_option ?? '') }}"
           style="width:100%; padding:8px; margin-bottom:14px;">

    <label style="display:block; font-weight:600; margin-bottom:6px;">Punten</label>
    <input type="number" name="points" min="1" max="100" value="{{ old('points', $question->points ?? 10) }}" required
           style="width:100%; padding:8px; margin-bottom:14px;">

    <label style="display:block; font-weight:600; margin-bottom:6px;">Feedback / uitleg bij het antwoord</label>
    <textarea name="explanation" rows="2"
              style="width:100%; padding:8px; margin-bottom:14px;">{{ old('explanation', $question->explanation ?? '') }}</textarea>

    <label style="display:block; margin-bottom:14px;">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $question->is_active ?? true) ? 'checked' : '' }}>
        Actief (zichtbaar/speelbaar)
    </label>

    <button type="submit" style="padding:10px 20px; background:#4f46e5; color:white; border:none; border-radius:6px; cursor:pointer;">
        Opslaan
    </button>
</form>
