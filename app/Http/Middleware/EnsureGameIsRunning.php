<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGameIsRunning
{
    public function handle(Request $request, Closure $next): Response
    {
        $status = Setting::get('game_status', 'draft');

        if ($status !== 'running') {
            return response()->view('play.closed', ['status' => $status], 503);
        }

        return $next($request);
    }
}
