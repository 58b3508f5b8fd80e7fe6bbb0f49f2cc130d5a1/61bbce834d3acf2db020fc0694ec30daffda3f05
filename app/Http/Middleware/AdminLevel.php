<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AdminLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->access_level < 2) {
            return new Response(view('errors.600'));
        }

        return $next($request);
    }
}
