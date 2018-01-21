<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Transaction;
use App\User;
use App\User_meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['totalPNM'] = $this->getTotalPNM();
        $data['totalNGN'] = $this->getTotalNGN();
        $data['currentValue'] = $this->getCurrentValue();
        $data['transferredPNM'] = $this->getWithDrawnPNM();
        $data['convertedPNM'] = $this->getConvertedPNM();
        $data['withdrawnPNM'] = $this->getWithDrawnPNM();

        return view('dashboard.index', $data);
    }

    public function getUserData()
    {
        $user = User_meta::where('name', Auth::user()->name)->first();
        return $user;
    }

    public function getTotalPNM()
    {
//        $credit = Transaction::where('to', Auth::user()->wallet_id)->where(function ($query) {
//            $query->where('type', 'ngn-pnm')
//                ->orWhere('type', 'pnm-pnm')
//                ->orWhere('type', 'pnm-wallet');
//        })
//            ->where('remark','credit')
//            ->where('status', 'successful')
//            ->sum('amount');
        $credit = Transaction::where('to', Auth::user()->wallet_id)
            ->where('remark', 'credit')
            ->where('status', 'successful')
            ->sum('amount');
        $debit = Transaction::where('from', Auth::user()->wallet_id)
            ->where('remark', 'debit')
            ->where('status', 'successful')
            ->sum('amount');
        $total = $credit - $debit;
        return $total;
    }

    public function getTotalNGN()
    {
        $credit = Transaction::where('to', Auth::user()->name)
            ->where('status', 'successful')
            ->sum(DB::raw("amount*value"));
        $debit = Transaction::where('from', Auth::user()->name)
            ->where('status', 'successful')
            ->sum(DB::raw("amount*value"));
//        ->select(DB::raw("sum(`amount`* `value`) as aggrega"))->get();

        $total = $credit - $debit;
        return $total;
    }

    public function getCurrentValue()
    {
        $value = Setting::where('name', 'current_pnm_value')->value('value');
        return $value;
    }

    public function getConvertedPNM()
    {
        $pnm = Transaction::where('from', Auth::user()->wallet_id)
            ->where('type', 'pnm-ngn')->where('remark', 'debit')
            ->sum('amount');
        return $pnm;
    }

    public function getTransferredPNM()
    {
        $pnm = Transaction::where('from', Auth::user()->wallet_id)
            ->where('type', 'pnm-pnm')->where('remark', 'debit')
            ->sum('amount');
        return $pnm;
    }

    public function getWithDrawnPNM()
    {
        $pnm = Transaction::where('from', Auth::user()->wallet_id)
            ->where('type', 'pnm-user')->where('remark', 'debit')
            ->sum('amount');
        return $pnm;
    }
}
