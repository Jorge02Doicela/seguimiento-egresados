<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_blocked) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Tu cuenta está bloqueada. Contacta al administrador.']);
        }

        return $next($request);
    }
}
