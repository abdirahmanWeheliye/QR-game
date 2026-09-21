<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');

    Route::get('/join', [JoinController::class, 'show'])->name('join');
    Route::post('/join', [joinController::class, 'store']);

    Route::get('admin/questions/print', [Admin\QuestionController::class, 'print'])
        ->name('admin.questions.print');

    Route::resource('admin/questions', Admin\QuestionController::class)
        ->except(['show'])
        ->names('admin.questions');

    Route::middleware(['student', 'game.running'])->group(function () {
        Route::get('/play/{question}', [PlayController::class, 'show'])->name('play.show');
        Route::post('/play/{question}', [PlayController::class, 'submit'])->name('play.submit');
        Route::post('/play/{question}/draft', [PlayController::class, 'draft'])->name('play.draft');
    });

    Route::middleware('student')->group(function () {
        Route::get('/voortgang', ProgressController::class)->name('progress');
        Route::get('/leaderboard', LeaderboardController::class)->name('leaderboard');
    });
});
