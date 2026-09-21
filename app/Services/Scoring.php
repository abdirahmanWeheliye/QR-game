<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Submission;

class Scoring
{
    public function grade(Submission $submission, Question $question, array $input): void
    {
        if ($question->isOpen()) {
            $submission->fill([
                'answer_text' => $input['answer_text'],
                'status' => 'pending',
                'points_awarded' => 0,
                'feedback' => null,
                'submitted_at' => now(),
            ]);
        } else {
            $correct = (int) $input['selected_option'] === (int) $question->correct_option;
            $submission->fill([
                'selected_option' => (int) $input['selected_option'],
                'status' => $correct ? 'correct' : 'wrong',
                'points_awarded' => $correct ? $question->points : 0,
                'feedback' => $question->explanation,
                'submitted_at' => now(),
            ]);
        }

        $submission->save();
    }
}
