<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'QR-game')</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            color: #111827;
            background: #f9fafb;
        }

        nav {
            background: #1f2937;
            padding: 12px 20px;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: center;
        }

        nav a {
            color: #e5e7eb;
            text-decoration: none;
            font-size: 14px;
        }

        nav a:hover {
            color: white;
            text-decoration: underline;
        }

        nav .divider {
            color: #4b5563;
        }

        main {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .status {
            background: #d1fae5;
            color: #065f46;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<nav>
    <strong style="color:white;">QR-game</strong>
    <span class="divider">|</span>
    <a href="{{ route('progress') }}">Voortgang</a>
    <a href="{{ route('leaderboard') }}">Leaderboard</a>

    @if (session('is_admin'))
        <span class="divider">|</span>
        <a href="{{ route('admin.questions.index') }}">Vragen</a>
        <a href="{{ route('admin.questions.print') }}" target="_blank">Printvel</a>
        <a href="{{ route('admin.review.index') }}">Nakijken</a>
        <a href="{{ route('admin.game.show') }}">Spelbesturing</a>
        <a href="{{ route('admin.export.download') }}">Export</a>

        <form method="POST" action="{{ route('admin.logout') }}" style="margin:0 0 0 auto;">
            @csrf
            <button type="submit"
                    style="background:none; border:none; color:#e5e7eb; font-size:14px; cursor:pointer; padding:0;">
                Uitloggen
            </button>
        </form>
    @endif
</nav>

<main>
    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    @yield('content')
</main>

</body>
</html>
