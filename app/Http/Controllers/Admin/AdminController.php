<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use App\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.index');
    }

    public function getCurrentValue()
    {
        $value = Setting::where('name', 'current_pnm_value')->value('value');
        return $value;
    }

    public function getPNMReserve()
    {
        $pnm = Transaction::where('from', Auth::user()->wallet_id)
            ->where('type', 'pnm-ngn')->where('remark', 'debit')
            ->sum('amount');
        return $pnm;
    }

    public function getSharedPNM()
    {
        $pnm = Transaction::where('from', Auth::user()->wallet_id)
            ->where('type', 'pnm-pnm')->where('remark', 'debit')
            ->sum('amount');
        return $pnm;
    }

    public function getPNM()
    {
        $pnm = Transaction::where('from', Auth::user()->wallet_id)
            ->where('type', 'pnm-user')->where('remark', 'debit')
            ->sum('amount');
        return $pnm;
    }
}
