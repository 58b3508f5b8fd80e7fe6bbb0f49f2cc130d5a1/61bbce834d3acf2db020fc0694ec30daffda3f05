<?php

namespace App\Http\Middleware;

use Closure;

class CheckMaintenance
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
        if (config('app.maintenance') == true) {
            return redirect('/maintenance');
        }
        return $next($request);
    }
}
