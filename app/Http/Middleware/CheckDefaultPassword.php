<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CheckDefaultPassword
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && Hash::check('password', $user->password)) {
            session()->flash('default_password', true);
        }

        return $next($request);
    }
}
