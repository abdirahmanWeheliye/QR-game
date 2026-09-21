<?php
$ranking = Student::query()
    ->withSum('submissions as points', 'points_awarded')
    ->orderByDesc('points')
    ->orderBy('id')
    ->get();
