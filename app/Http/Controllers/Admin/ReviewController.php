<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $submissions = Submission::with(['student', 'question'])
            ->where('status', 'pending')
            ->oldest('submitted_at')
            ->get();

        return view('admin.review.index', compact('submissions'));
    }

    public function update(Request $request, Submission $submission)
    {
        $max = $submission->question->points;

        $data = $request->validate([
            'decision' => ['required', 'in:correct,wrong'],
            'points_awarded' => ['nullable', 'integer', 'min:0', 'max:'.$max],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        $correct = $data['decision'] === 'correct';

        $submission->update([
            'status' => $data['decision'],
            'points_awarded' => $correct ? ($data['points_awarded'] ?? $max) : 0,
            'feedback' => $data['feedback'] ?? null,
        ]);

        return back()->with('status', 'Beoordeeld: '.$submission->student->student_number);
    }
}
