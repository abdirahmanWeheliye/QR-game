<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function store(Request $request)
    {
        if($request->input('password') !== config('app.admin_password')) {
            return back()->withErrors(['password' => 'Onjuist wachtwoord']);
        }
        $request->session()->put('is_admin', true);
        return redirect()->route('admin.index');
    }
}
