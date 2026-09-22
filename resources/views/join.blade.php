@extends('layouts.app')

@section('title', 'Meedoen')

@section('content')

    <h1>Welkom bij het spel</h1>
    <p style="color:#6b7280; margin-bottom:24px;">Vul je studentnummer in om mee te doen.</p>

    <form method="POST" action="{{ route('join.store') }}">
        @csrf

        <label for="student_number" style="display:block; font-size:14px; font-weight:600; margin-bottom:6px;">Studentnummer</label>
        <input type="text" id="student_number" name="student_number"
               value="{{ old('student_number') }}" inputmode="numeric" required autofocus
               style="width:100%; padding:10px 12px; font-size:16px; border:1px solid #d1d5db; border-radius:6px; margin-bottom:16px;">
        @error('student_number')
        <div style="color:#dc2626; font-size:13px; margin-top:-12px; margin-bottom:16px;">{{ $message }}</div>
        @enderror

        <label for="name" style="display:block; font-size:14px; font-weight:600; margin-bottom:6px;">Naam (optioneel)</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}"
               style="width:100%; padding:10px 12px; font-size:16px; border:1px solid #d1d5db; border-radius:6px; margin-bottom:16px;">

        <input type="hidden" name="next" value="{{ $next }}">

        <button type="submit"
                style="width:100%; padding:12px; font-size:16px; font-weight:600; background:#000000; color:white; border:none; border-radius:6px; cursor:pointer;">
            Meedoen
        </button>
    </form>

@endsection
