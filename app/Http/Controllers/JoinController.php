<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JoinController extends Controller
{
    public function show(Request $request){
        return view('join', ['next' => $request->query('next')]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'student_number' => ['required', 'regex:/^\d{6,8}$/'],
            'name' => [ 'nullable', 'string', 'max:60'],
            'next' => ['nullable', 'string'],
        ]);

        $student = Student::firstOrCreate(
            ['student_number' => $data['student_number']],
             ['name' => $data['name'] ?? null]
            );

        return redirect($data['next'] ?? route('progress'))
            ->cookie('player_token', $student->play_token, 60 * 24 * 365);
    }

}
