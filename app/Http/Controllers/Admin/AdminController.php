<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index()
    {
        $data['totalReserve'] = $this->getTotalReserve();
        $data['totalReserveValue'] = $this->getTotalReserveValue();
        $data['transactionCommission'] = $this->getTransactionCommission();
        $data['sharedPNM'] = $this->getSharedPNM();
        return view('admin.index', $data);
    }

    public function getCurrentValue()
    {
        $value = Setting::where('name', 'current_pnm_value')->value('value');
        return $value;
    }

    public function getCheckProfitStart()
    {
        $start = Setting::where('name', 'check_profit_start')->value('value');
        return $start;
    }

    public function getCheckSharedStart()
    {
        $start = Setting::where('name', 'check_shared_start')->value('value');
        return $start;
    }

    public function getTotalReserve()
    {
        $transactionCommission = $this->getTransactionCommission();
        $addedPNM = Transaction::where('from', Auth::user()->name)
            ->where('to', Auth::user()->wallet_id)
            ->where('type', 'admin-holding')->where('remark', 'credit')
            ->where('status', 'successful')
            ->sum('amount');
        $sharedPNM = $this->getSharedPNM();
        $credit = $transactionCommission + $addedPNM;
        $reserve = $credit - $sharedPNM;
        return $reserve;
    }

    public function getSharedPNM()
    {

        $pnm = Transaction::where('from', Auth::user()->wallet_id)
            ->where('type', 'holding-pnm')->where('status', 'successful')
            ->sum('amount');
        return $pnm;
    }

    public function getTransactionCommission()
    {
        $start = $this->getCheckProfitStart();
        $pnm = Transaction::where('type', 'pnm-holding')
            ->where('to', 'holding')
            ->where('remark', 'debit')
            ->whereDate('updated_at', ">", $start)
            ->where('status', 'successful')
            ->sum('amount');
        return $pnm;
    }

    public function getTotalReserveValue()
    {
        $reserve = $this->getTotalReserve();
        $value = $this->getCurrentValue();
        $reserveValue = $reserve * $value;
        return $reserveValue;
    }

    public function sharePNM()
    {

    }
}
