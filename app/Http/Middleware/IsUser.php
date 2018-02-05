<?php

namespace App\Http\Middleware;

use App\Http\Controllers\HomeController;
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
        if ($request->user()->type == 'admin') {
            return redirect('admin');
        }
        elseif ($request->user()->type != 'user') {
            return new Response(view('errors.600'));
        }

        $data['totalPNM'] = $this->home()->getTotalPNM();
        $data['totalNGN'] = $this->home()->getTotalNGN();
        $data['currentValue'] = $this->home()->getCurrentValue();
        $data['transferredPNM'] = $this->home()->getWithDrawnPNM();
        $data['convertedPNM'] = $this->home()->getConvertedPNM();
        $data['withdrawnPNM'] = $this->home()->getWithDrawnPNM();

        $request->session()->flash('stats', $data);

        return $next ($request);
    }

    public function home()
    {
        return new HomeController();
    }
}
