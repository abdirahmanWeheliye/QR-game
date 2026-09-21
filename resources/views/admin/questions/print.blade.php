<?php
{{-- //<a href="{{ route('admin.questions.print') }}" target="_blank">Printvel met alle QR-codes</a>// --}}
    <!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>QR-tegels — printvel</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            padding: 24px;
            background: #f3f4f6;
            color: #111827;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .toolbar h1 {
            font-size: 18px;
            margin: 0;
        }

        .toolbar button {
            padding: 10px 18px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            background: #4f46e5;
            color: white;
            cursor: pointer;
        }

        .toolbar a {
            font-size: 14px;
            color: #4f46e5;
            text-decoration: none;
        }

        .sheet {
            background: white;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 12mm;
            box-shadow: 0 1px 6px rgba(0,0,0,0.15);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8mm;
        }

        .tile {
            border: 1px dashed #9ca3af;
            border-radius: 8px;
            padding: 6mm;
            text-align: center;
            break-inside: avoid;
        }

        .tile .qr {
            display: flex;
            justify-content: center;
            margin-bottom: 4mm;
        }

        .tile .qr svg {
            width: 100%;
            height: auto;
            max-width: 45mm;
        }

        .tile h2 {
            font-size: 12pt;
            margin: 0 0 2mm;
            line-height: 1.2;
        }

        .tile .points {
            font-size: 9pt;
            color: #6b7280;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .toolbar {
                display: none;
            }

            .sheet {
                box-shadow: none;
                margin: 0;
                width: auto;
                min-height: auto;
                padding: 0;
            }

            .tile {
                border: 1px solid #d1d5db;
            }

            @page {
                size: A4;
                margin: 12mm;
            }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <h1>{{ $questions->count() }} actieve vraag/vragen — QR-tegels</h1>
    <div style="display:flex; gap:16px; align-items:center;">
        <a href="{{ route('admin.questions.index') }}">← Terug naar vragenlijst</a>
        <button onclick="window.print()">Printen</button>
    </div>
</div>

<div class="sheet">
    @if ($questions->isEmpty())
        <p class="empty">Er zijn nog geen actieve vragen om te printen.</p>
    @else
        <div class="grid">
            @foreach ($questions as $question)
                <div class="tile">
                    <div class="qr">{!! $question->qrSvg !!}</div>
                    <h2>{{ $question->title }}</h2>
                    <div class="points">{{ $question->points }} punten · {{ $question->type === 'open' ? 'open vraag' : 'meerkeuze' }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>
