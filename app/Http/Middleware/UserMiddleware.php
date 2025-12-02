<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['user', 'department_head', 'admin'])) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}