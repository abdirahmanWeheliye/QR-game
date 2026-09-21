<?php
$total = Question::where('is_active', true)->count();
$done = $student->submissions()->whereNotNull('submitted_at')->count();
$points = $student->totalPoints();
$pending = $student->submissions()->where('status', 'pending')->count();
