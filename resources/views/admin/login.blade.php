@extends('layouts.app')

@section('title', 'Admin login')

@section('content')
    <h1>Organisator-login</h1>

    <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf

        <label for="password" style="display:block; font-size:14px; font-weight:600; margin-bottom:6px;">Wachtwoord</label>
        <input type="password" id="password" name="password" required autofocus
               style="width:100%; padding:10px 12px; font-size:16px; border:1px solid #d1d5db; border-radius:6px; margin-bottom:16px;">
        @error('password')
        <div style="color:#dc2626; font-size:13px; margin-top:-12px; margin-bottom:16px;">{{ $message }}</div>
        @enderror

        <button type="submit"
                style="width:100%; padding:12px; font-size:16px; font-weight:600; background:#4f46e5; color:white; border:none; border-radius:6px; cursor:pointer;">
            Inloggen
        </button>
    </form>
@endsection
