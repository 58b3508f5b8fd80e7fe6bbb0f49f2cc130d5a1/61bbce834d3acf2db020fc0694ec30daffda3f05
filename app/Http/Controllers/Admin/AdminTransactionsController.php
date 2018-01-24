<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminTransactionsController extends Controller
{
    //
    public function __construct(AdminController $details)
    {
        $this->details = $details;
    }


    public function viewNgn()
    {

    }

    public function viewShare()
    {
        $data['action'] = 'share PNM';
        return view('admin.sharePNM', $data);
    }

    public function viewWithdrawal()
    {

    }

    public function sharePNM(Request $request)
    {
        $value = $this->details->getCurrentValue();
        $pnm = $request->input('pnm');
        $pin = $request->input('pin');
        $wallet = $request->input('wallet');

        $data['action'] = 'new PNM';
        $isUser = User::where('wallet_id', $wallet)->where('type', 'user')
            ->first();
        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($checkPin && $isUser) {
            $ngn = $pnm * (int)$value;
            $description = "Admin shared $pnm PNM worth $ngn NGN";
            $type = "holding-pnm";
            $transaction = new Transaction();
            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));
            $transaction->transaction_id = $transactionID;
            $transaction->from = Auth::user()->wallet_id;
            $transaction->to = $wallet;
            $transaction->amount = $pnm;
            $transaction->value = $value;
            $transaction->description = $description;
            $transaction->type = $type;
            $transaction->status = 'successful';
            $transaction->remark = 'credit';
            $transaction->save();
            if ($transaction->save()) {
                $data['alert'] = 'success';
                $data['message'] = "Your transaction was successful";
            }
        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = "Sorry, the pin you entered was incorrect";
            } elseif (!$isUser) {
                $data['alert'] = 'danger';
                $data['message'] = "Sorry, the wallet id was not traced to any user";
            }
        }

        return view('admin.newPNM', $data);
    }
}
