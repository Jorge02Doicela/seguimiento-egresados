<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmployerIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole('employer')) {
            $employer = Auth::user()->employer;

            if (!$employer || !$employer->is_verified) {
                // Muestra una vista bonita de "pendiente de verificación"
                return response()->view('auth.pending_verification');
            }
        }

        return $next($request);
    }
}
