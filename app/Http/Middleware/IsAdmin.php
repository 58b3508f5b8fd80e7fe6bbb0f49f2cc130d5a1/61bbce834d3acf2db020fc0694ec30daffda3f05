<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Admin\AdminController;
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
        if ($request->user()->type == 'user') {
            return redirect('home');
        } elseif ($request->user()->type != 'admin') {
            return new Response (view('errors.600'));
        }

        $data['totalPNM'] = $this->admin()->getTotalPNM();
        $data['totalReserveValue'] = $this->admin()->getTotalReserveValue();
        //$data['transactionCommission'] = $this->admin()->getTransactionCommission();
        $data['currentValue'] = $this->admin()->getCurrentValue();
        //$data['sharedPNM'] = $this->admin()->getSharedPNM();

        $request->session()->flash('stats', $data);

        return $next ($request);
    }
    
    public function admin(){
        return new AdminController();
    }
}
