<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Submission;
use App\Services\Scoring;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function show(Request $request, Question $question)
    {
        abort_unless($question->is_active, 404);

        $student = $request->attributes->get('student');

        $submission = Submission::firstOrCreate(
            ['student_id' => $student->id, 'question_id' => $question->id],
            ['status' => 'draft']
        );

        if ($submission->submitted_at) {
            return view('play.result', compact('question', 'submission'));
        }

        return view('play.show', compact('question', 'submission'));
    }

    public function submit(Request $request, Question $question, Scoring $scoring)
    {
        $student = $request->attributes->get('student');

        $submission = Submission::where('student_id', $student->id)
            ->where('question_id', $question->id)
            ->firstOrFail();

        abort_if($submission->submitted_at, 403, 'Je hebt deze vraag al beantwoord.');

        $input = $request->validate($question->isOpen()
            ? ['answer_text' => ['required', 'string', 'max:2000']]
            : ['selected_option' => ['required', 'integer', 'min:0']]
        );

        $scoring->grade($submission, $question, $input);

        return redirect()->route('play.show', $question);
    }

    public function draft(Request $request, Question $question)
    {
        $student = $request->attributes->get('student');

        $submission = Submission::where('student_id', $student->id)
            ->where('question_id', $question->id)
            ->firstOrFail();

        if (! $submission->submitted_at) {
            $submission->update(['answer_text' => $request->input('answer_text')]);
        }

        return response()->noContent();
    }
}
