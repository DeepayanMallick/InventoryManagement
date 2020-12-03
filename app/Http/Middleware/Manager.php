<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Manager
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Manager') {
            return $next($request);
        }

        return redirect('/')->with('Unauthorized', 401);
    }
}
