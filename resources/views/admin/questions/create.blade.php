@extends('layouts.app')

@section('title', 'Nieuwe vraag')

@section('content')
    <h1>Nieuwe vraag</h1>

    @include('admin.questions._form', ['question' => null])
@endsection
