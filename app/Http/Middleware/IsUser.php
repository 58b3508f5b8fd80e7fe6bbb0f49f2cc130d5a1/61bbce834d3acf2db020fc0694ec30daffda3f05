<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class IsUser
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
        if ($request->user()->type != 'user') {
            return new Response(view('errors.600'));
        }

        return $next ($request);
    }
}
