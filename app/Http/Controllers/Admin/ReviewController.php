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
            ->paginate(20);
        return view('admin.review.index', compact('submissions'));
    }

    public function update(Request $request, Submission $submission)
    {
        $data = $request->validate([
            'points_awarded' => ['required', 'integer', 'min:0', 'max:' .$submission->question->points],
            'feedback' => ['nullable', 'string', 'max:1000'],
            'descision' => ['required', 'in:correct,wrong'],
        ]);
        $submission->update([
            'status' => $data['descision'],
            'points_awarded' => $data['descision' === 'correct' ? $data['points_awarded'] : 0],
            'feedback' => $data['feedback'],
        ]);
        return back()->with('status', 'Beoordeeld');
    }
}
