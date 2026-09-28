<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $students = Student::query()
            ->withSum('submissions as points', 'points_awarded')
            ->orderByDesc('points')
            ->orderBy('id')
            ->get();

        $position = 0;
        $rank = 0;
        $previous = null;

        // Gelijke score = gelijke plaats (1, 2, 2, 4)
        $ranking = $students->map(function (Student $s) use (&$position, &$rank, &$previous) {
            $position++;
            $points = (int) $s->points;

            if ($points !== $previous) {
                $rank = $position;
                $previous = $points;
            }

            $s->rank = $rank;
            $s->points = $points;

            return $s;
        });

        return view('leaderboard', compact('ranking'));
    }
}
