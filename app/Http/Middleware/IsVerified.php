<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\User_meta;

class IsVerified
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->status == 'pending') {
            return redirect('pending ')->withInput();
        } elseif (Auth::user()->status == 'blocked') {
            return redirect('blocked')->withInput();
        }
        return $next($request);

    }
}
