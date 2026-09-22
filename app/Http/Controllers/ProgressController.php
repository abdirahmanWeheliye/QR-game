<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function __invoke(Request $request)
    {
        $student = $request->attributes->get('student');

        $total = Question::where('is_active', true)->count();
        $done = $student->submissions()->whereNotNull('submitted_at')->count();
        $points = $student->totalPoints();
        $pending = $student->submissions()->where('status', 'pending')->count();

        $submissions = $student->submissions()
            ->with('question')
            ->whereNotNull('submitted_at')
            ->latest('submitted_at')
            ->get();

        return view('progress', compact('total', 'done', 'points', 'pending', 'submissions'));
    }
}
