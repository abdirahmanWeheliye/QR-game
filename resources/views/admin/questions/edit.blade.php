<?php
@use(SimpleSoftwareIO\QrCode\Facades\QrCode)

<div class="qr">
    {!! QrCode::size(240)->margin(1)->generate($question->playUrl()) !!}
    <p><code>{{ $question->playUrl() }}</code></p>
    <a href="{{ route('admin.questions.qr', $question) }}">Download als SVG (printen)</a>
</div>

<h1>{{ $question->title }}</h1>
