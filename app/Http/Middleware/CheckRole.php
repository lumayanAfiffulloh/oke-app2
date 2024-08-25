<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check() && in_array(Auth::user()->akses, $roles)) {
            return $next($request);
        }

        // Jika pengguna tidak memiliki peran yang diizinkan, redirect ke halaman beranda atau error
        return redirect('/')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
    }
}
