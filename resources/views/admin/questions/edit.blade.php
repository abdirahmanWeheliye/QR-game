@extends('layouts.app')

@section('title', 'Vraag bewerken')

@section('content')
    <div style="text-align:center; margin-bottom:24px;">
        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(220)->margin(1)->generate($question->playUrl()) !!}
        <p><code>{{ $question->playUrl() }}</code></p>
    </div>

    <h1>{{ $question->title }}</h1>

    @include('admin.questions._form', ['question' => $question])
@endsection
