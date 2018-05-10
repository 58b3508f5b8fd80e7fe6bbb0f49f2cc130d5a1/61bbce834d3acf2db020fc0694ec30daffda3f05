<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GreenWhiteController extends Controller
{
    //

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
            $ngn = $request->amount;
            $pin = $request->input('pin');
            $data = array();

            $pnm = $ngn / (int)$value;

            $hasPNM = $this->checkPNM($pnm);

            if ($hasPNM) {
                $description
                    = "Payment for Touching Lives Skills registration";
                $type = "wallet-holding";

                $transaction = new Transaction();

                $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                    . date('YFlHisuA'));
                $amount = $pnm * 100000;
                $transaction->transaction_id = $transactionID;
                $transaction->from = Auth::user()->wallet_id;
                $transaction->to = 'holding';
                $transaction->amount = $amount;
                $transaction->value = $value;
                $transaction->description = $description;
                $transaction->type = $type;
                $transaction->status = 'successful';
                $transaction->remark = 'debit';

                if ($transaction->save()) {
                    $message
                        = "Wallet debit!\nAmt: $amount\nDesc: $description\nDate: "
                        . date('d-m-Y H:i') . "\nID: " . substr($transactionID,
                            0, 6)
                        . '...' . substr($transactionID, -6) . "\nBal: "
                        . $this->getTotalPNM() / 100000;
                    $sms = new SendSMS();
                    $response = $sms->sendSMS(Auth::user()->phone_no, $message);
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
    }}
