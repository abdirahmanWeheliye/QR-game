<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;

// Bekende student -> voortgang, onbekende -> /join (via de student-middleware)
Route::get('/', fn () => redirect()->route('progress'));

/* ---------- Speler ---------- */
Route::get('/join', [JoinController::class, 'show'])->name('join');
Route::post('/join', [JoinController::class, 'store'])->name('join.store');

Route::middleware(['student', 'game.running'])->group(function () {
    Route::get('/play/{question}', [PlayController::class, 'show'])->name('play.show');
    Route::post('/play/{question}', [PlayController::class, 'submit'])->name('play.submit');
    Route::post('/play/{question}/draft', [PlayController::class, 'draft'])->name('play.draft');
});

Route::middleware('student')->group(function () {
    Route::get('/voortgang', ProgressController::class)->name('progress');
    Route::get('/leaderboard', LeaderboardController::class)->name('leaderboard');
});

/* ---------- Organisator ---------- */
Route::get('admin/login', [AuthController::class, 'show'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'store'])->name('admin.login.store');
Route::post('admin/logout', [AuthController::class, 'destroy'])->name('admin.logout');

Route::middleware('admin')->group(function () {
    Route::get('admin/questions/print', [QuestionController::class, 'print'])->name('admin.questions.print');
    Route::resource('admin/questions', QuestionController::class)
        ->except(['show'])
        ->names('admin.questions');

    Route::get('admin/game', [GameController::class, 'show'])->name('admin.game.show');
    Route::patch('admin/game', [GameController::class, 'update'])->name('admin.game.update');

    Route::get('admin/review', [ReviewController::class, 'index'])->name('admin.review.index');
    Route::patch('admin/review/{submission}', [ReviewController::class, 'update'])->name('admin.review.update');

    Route::get('admin/export', ExportController::class)->name('admin.export.download');
});
