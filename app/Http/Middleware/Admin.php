<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role == 'Admin') {
            return $next($request);
        }

        return redirect('/')->with('Unauthorized', 401);
    }
}
