<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function show()
    {
        return view('admin.login');
    }

    public function store(Request $request)
    {
        $request->validate(['password' => ['required', 'string']]);

        if ($request->input('password') !== config('app.admin_password')) {
            return back()->withErrors(['password' => 'Onjuist wachtwoord']);
        }

        $request->session()->put('is_admin', true);

        return redirect()->route('admin.questions.index');
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('is_admin');
        return redirect()->route('admin.login');
    }
}
