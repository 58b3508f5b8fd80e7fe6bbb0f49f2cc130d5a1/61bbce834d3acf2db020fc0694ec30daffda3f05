<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TransactionController extends Controller
{
    //

    public function __construct(HomeController $details)
    {
        $this->details = $details;
    }

    public function index($for, $action)
    {
        $data = ['for' => $for, 'action' => $action];
        switch ($for) {
            case('ngn'):
                switch ($action) {
                    case('convert'):
                        $data['title'] = "Convert NGN to PNM";
                        $data['heading']
                            = "<i class='si si-fire'></i> PNM to NGN &#8358;";
                        break;
                    case('withdraw'):
                        $data['title'] = "Withdraw NGN to Bank";
                        $data['heading']
                            = "<i class='si si-fire'></i> NGN to Bank <i class='fa fa-institution'></i>";
                        break;
                }
                break;
            case('pnm'):
                switch ($action) {
                    case('convert'):
                        $data['title'] = "Convert PNM to NGN";
                        $data['heading']
                            = "<i class='si si-fire'></i> PNM to NGN &#8358;";
                        break;
                    case('transfer'):
                        $data['title'] = "Transfer PNM to Account";
                        $data['heading']
                            = "<i class='si si-fire'></i> PNM to User <i class='si si-user'></i>";
                        break;
                    case('withdraw'):
                        $data['title'] = "Withdraw PNM to Wallet";
                        $data['heading']
                            = "<i class='si si-fire'></i> PNM to Wallet <i class='si si-briefcase'></i>";
                        break;
                }
                break;
        }
        return view("dashboard.transactions.$action", $data);
    }

    public function checkNGN($amount)
    {
        $balance = $this->details->getTotalNGN();
        if ($balance >= $amount) {
            return true;
        }
        return false;
    }

    public function checkPNM($amount)
    {
        $balance = $this->details->getTotalPNM();
        if ($balance >= $amount) {
            return true;
        }
        return false;
    }

    public function convertNGN(Request $request)
    {
        $value = $this->details->getCurrentValue();
        $ngn = $request->input('amount');
        $pin = $request->input('pin');

        $hasNGN = $this->checkNGN($ngn);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($hasNGN && $checkPin) {
            $pnm = $ngn / (int)$value;
            $description = "Conversion of $ngn NGN to $pnm PNM";
            $type = "ngn-pnm";
            $transaction = new Transaction();
            $transactionID = md5(Auth::user()->wallet_id . $ngn . $pnm
                . date('YFlHisuA'));
            $transaction->transaction_id = $transactionID;
            $transaction->from = Auth::user()->name;
            $transaction->to = Auth::user()->wallet_id;
            $transaction->amount = $pnm;
            $transaction->value = $value;
            $transaction->description = $description;
            $transaction->type = $type;
            $transaction->status = 'succesful';
            $transaction->remark = 'credit';
            $transaction->save();
        } else {
            if (!$checkPin) {
                $data['error'] = 'incorrectPin';
            } elseif (!$hasNGN) {
                $data['error'] = 'wrongAmount';
            }
        }
    }

    public function convertPNM(Request $request)
    {
        $value = $this->details->getCurrentValue();
        $pnm = $request->input('amount');
        $pin = $request->input('pin');

        $hasPNM = $this->checkPNM($pnm);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($hasPNM && $checkPin) {
            $ngn = $pnm * (int)$value;
            $description = "Conversion of $pnm PNM to $ngn NGN";
            $type = "pnm-ngn";
            $transaction = new Transaction();
            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));
            $transaction->transaction_id = $transactionID;
            $transaction->from = Auth::user()->wallet_id;
            $transaction->to = Auth::user()->name;
            $transaction->amount = $pnm;
            $transaction->value = $value;
            $transaction->description = $description;
            $transaction->type = $type;
            $transaction->status = 'succesful';
            $transaction->remark = 'debit';
            $transaction->save();
        } else {
            if (!$checkPin) {
                $data['error'] = 'incorrectPin';
            } elseif (!$hasPNM) {
                $data['error'] = 'wrongAmount';
            }
        }
    }

    public function process(Request $request, $for, $action)
    {
        $data = ['for' => $for, 'action' => $action];
        switch ($for) {
            case('ngn'):
                switch ($action) {
                    case('convert'):
                        $result = $this->convertNGN($request);
                        break;
                    case('withdraw'):

                        break;
                }
                break;
            case('pnm'):
                switch ($action) {
                    case('convert'):
                        $result = $this->convertPNM($request);
                        break;
                    case('transfer'):

                        break;
                    case('withdraw'):

                        break;
                }
                break;
        }
    }

    public function viewTransaction($id)
    {
        // drg >> show just a single transaction
    }

    public function viewTransactions()
    {
        // drg >> show transaction history

    }

    public function withdrawNGN(Request $request){
        $value = $this->details->getCurrentValue();
        $pnm = $request->input('amount');
        $pin = $request->input('pin');

        $hasNGN = $this->checkNGN($pnm);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($hasNGN && $checkPin) {
            $ngn = $pnm * (int)$value;
            $description = "Withdrawal request for $ngn NGN";
            $type = "ngn-bank";
            $transaction = new Transaction();
            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));
            $transaction->transaction_id = $transactionID;
            $transaction->from = Auth::user()->name;
            $transaction->to = 'user';
            $transaction->amount = $pnm;
            $transaction->value = $value;
            $transaction->description = $description;
            $transaction->type = $type;
            $transaction->status = 'requested';
            $transaction->remark = 'debit';
            $transaction->save();
        } else {
            if (!$checkPin) {
                $data['error'] = 'incorrectPin';
            } elseif (!$hasNGN) {
                $data['error'] = 'wrongAmount';
            }
        }
    }

    public function withdrawPNM(Request $request){
        $value = $this->details->getCurrentValue();
        $pnm = $request->input('amount');
        $pin = $request->input('pin');

        $hasPNM = $this->checkPNM($pnm);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($hasPNM && $checkPin) {
            $ngn = $pnm * (int)$value;
            $description = "Withdrawal request for $pnm PNM";
            $type = "pnm-wallet";
            $transaction = new Transaction();
            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));
            $transaction->transaction_id = $transactionID;
            $transaction->from = Auth::user()->name;
            $transaction->to = Auth::user()->wallet_address;
            $transaction->amount = $pnm;
            $transaction->value = $value;
            $transaction->description = $description;
            $transaction->type = $type;
            $transaction->status = 'requested';
            $transaction->remark = 'debit';
            $transaction->save();
        } else {
            if (!$checkPin) {
                $data['error'] = 'incorrectPin';
            } elseif (!$hasPNM) {
                $data['error'] = 'wrongAmount';
            }
        }
    }
}
