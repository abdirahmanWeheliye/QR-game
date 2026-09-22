<?php

namespace App\Http\Middleware;

use App\Models\Student;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('play_token');
        $student = $token ? Student::where('play_token', $token)->first() : null;

        if (! $student) {
            return redirect()->route('join', ['next' => $request->fullUrl()]);
        }

        $request->attributes->set('student', $student);
        view()->share('student', $student);

        return $next($request);
    }
}
