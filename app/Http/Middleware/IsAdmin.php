<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class IsAdmin
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
        if (!in_array($request->user()->type, ['staff', 'admin'])) {
            return new Response (view('errors.600'));
        }

        return $next ($request);
    }
}
