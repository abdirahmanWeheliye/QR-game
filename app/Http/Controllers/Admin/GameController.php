<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function update(Request $request)
    {
        $request->validate(['status'=> ['required', 'in:draft,paused,finished']]);
        Setting::put('game_status', $request->input('status'));
        return back();
    }
}
