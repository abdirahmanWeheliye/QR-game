<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function show()
    {
        $status = Setting::get('game_status', 'draft');

        return view('admin.game.show', compact('status'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'status' => ['required', 'in:draft,running,paused,finished'],
        ]);

        Setting::put('game_status', $data['status']);

        return back()->with('status', 'Spelstatus bijgewerkt naar: '.$data['status']);
    }
}
