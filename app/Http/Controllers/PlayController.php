<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function show(Request $request,Question $question)
    {
        abort_unless($question->is_active, 404);
        $student = $request->attributes->get('student');

        $submission = Submission::firstOrCreate(
            ['student_id' => $student->id, 'question_id' => $question->id],
            ['status' => 'draft']
        );

        if ($submission->submitted_at) {
            return view('pay.result', compact('question', 'submission'));
        }


        return view('play.show', ['question' => $question]);
    }
}
