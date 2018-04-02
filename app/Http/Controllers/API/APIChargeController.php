<?php

namespace App\Http\Controllers\API;

use App\Setting;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class APIChargeController extends Controller
{
    //
    public function index(Request $request)
    {

    }

    public function api()
    {
        return new APIController();
    }

    public function checkPNM($amount)
    {
        $balance = $this->getTotalPNM();
        if ($balance >= $amount) {
            return true;
        }
        return false;
    }

    public function charge(Request $request)
    {
        try {
            $status = false;
            $transactionID = '';
            $value = $this->api()->getCurrentValue();
            $ngn = Setting::where('name', 'registration_charge')
                ->value('value');
            $pin = $request->input('pin');
            $data = array();

            $pnm = $ngn / (int)$value;

            $hasPNM = $this->checkPNM($pnm);

            if ($hasPNM) {
                $description1
                    = "Payment for Touching Lives Skills registration";
                $type1 = "wallet-holding";

                $transaction1 = new Transaction();

                $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                    . date('YFlHisuA'));

                $transaction1->transaction_id = $transactionID;
                $transaction1->from = Auth::user()->wallet_id;
                $transaction1->to = 'holding';
                $transaction1->amount = $pnm * 100000;
                $transaction1->value = $value;
                $transaction1->description = $description1;
                $transaction1->type = $type1;
                $transaction1->status = 'successful';
                $transaction1->remark = 'debit';

                if ($transaction1->save()) {
                    $status = true;
                    $data['alert'] = 'success';
                    $data['message'] = 'Your payment was successful';
                }


            } elseif (!$hasPNM) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient PNM balance';
                $status = false;
            }


            return response()->json([
                'status'         => $status,
                'data'           => $data,
                'user'           => Auth::user(),
                'amount'         => Setting::where('name',
                    'registration_charge')
                    ->value('value'),
                'pnm'            => Setting::where('name',
                    'current_pnm_value')
                    ->value('value'),
                'transaction_id' => $transactionID,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function getTotalPNM()
    {
        $credit = Transaction::where('to', Auth::user()->wallet_id)
            ->where('status', 'successful')
            ->sum('amount');
        $debit = Transaction::where('from', Auth::user()->wallet_id)
            ->where('remark', 'debit')->where(function ($query) {
                $query->where('status', 'successful')
                    ->orWhere('status', 'requested');
            })
            ->sum('amount');
        $total = $credit - $debit;
        return $total;
    }

    public function getTransactions()
    {
        return response()->json(['error' => 'wow']);
        //Transaction::where('from', Auth::user()->wallet_id)->get();
    }
}
