<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TransactionController extends Controller
{
    //

    public function home()
    {
        return new HomeController();
    }

    public function index($for, $action)
    {
        $data = [
            'for'    => $for,
            'action' => $action,
            'value'  => $this->home()->getCurrentValue()
        ];
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
                        $data['duration']= Setting::where('name', 'ngn_withdrawal_duration')
                            ->value('value');
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
                        $data['duration']= Setting::where('name', 'pnm_withdrawal_duration')
                            ->value('value');
                        break;
                }
                break;
        }
        return view("dashboard.transactions.$action", $data);
    }

    public function checkNGN($amount)
    {
        $balance = $this->home()->getTotalNGN();
        if ($balance >= $amount) {
            return true;
        }
        return false;
    }

    public function checkPNM($amount)
    {
        $balance = $this->home()->getTotalPNM();
        if ($balance >= $amount) {
            return true;
        }
        return false;
    }

    public function convertNGN(Request $request)
    {
        $value = $this->home()->getCurrentValue();
        $ngn = $request->input('amount');
        $pin = $request->input('pin');
        $data = array();

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
            $transaction->status = 'successful';
            $transaction->remark = 'credit';
            $transaction->save();
        } else {
            if (!$checkPin) {
                $data['error'] = 'incorrectPin';
            } elseif (!$hasNGN) {
                $data['error'] = 'wrongAmount';
            }
        }
        return $data;
    }

    public function convertPNM(Request $request)
    {
        $data = array();
        $value = $this->home()->getCurrentValue();
        $pnm = $request->input('amount');
        $pin = $request->input('pin');

        $ngn = $pnm * (int)$value;
        $charge = Setting::where('name', 'ngn_conversion_charge')
            ->value('value');
        $chargePNM = $charge / (int)$value;

        $hasPNM = $this->checkPNM($pnm + $chargePNM);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($hasPNM && $checkPin) {
            $description1 = "Conversion of $pnm PNM to $ngn NGN";
            $description2
                = "$charge NGN ($chargePNM PNM) commission charge for $pnm PNM conversion";
            $type1 = "pnm-ngn";
            $type2 = "pnm-holding";

            $transaction1 = new Transaction();
            $transaction2 = new Transaction();

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $transaction1->transaction_id = $transactionID;
            $transaction1->from = Auth::user()->wallet_id;
            $transaction1->to = Auth::user()->name;
            $transaction1->amount = $pnm;
            $transaction1->value = $value;
            $transaction1->description = $description1;
            $transaction1->type = $type1;
            $transaction1->status = 'successful';
            $transaction1->remark = 'debit';

            $transaction2->transaction_id = $transactionID;
            $transaction2->from = Auth::user()->wallet_id;
            $transaction2->to = 'holding';
            $transaction2->amount = $chargePNM;
            $transaction2->value = $value;
            $transaction2->description = $description2;
            $transaction2->type = $type2;
            $transaction2->status = 'successful';
            $transaction2->remark = 'debit';

            if ($transaction1->save() && $transaction2->save()) {
                $data['alert'] = 'Success';
                $data['message'] = 'Your transaction request was successful';
            }

        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = 'You entered an incorrect pin';
            } elseif (!$hasPNM) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient PNM balance';
            }
        }
        return $data;
    }

    public function process(Request $request, $for, $action)
    {
        $result = array();
        switch ($for) {
            case('ngn'):
                switch ($action) {
                    case('convert'):
                        $result = $this->convertNGN($request);
                        $result['title'] = "Convert NGN to PNM";
                        $result['heading']
                            = "<i class='si si-fire'></i> PNM to NGN &#8358;";
                        break;
                    case('withdraw'):
                        $result = $this->withdrawNGN($request);
                        $result['title'] = "Withdraw PNM to Wallet";
                        $result['heading']
                            = "&#8358; NGN to Bank <i class='fa fa-bank'></i>";
                        break;
                }
                break;
            case('pnm'):
                switch ($action) {
                    case('convert'):
                        $result = $this->convertPNM($request);
                        $result['title'] = "Convert PNM to NGN";
                        $result['heading']
                            = "<i class='si si-fire'></i> PNM to NGN &#8358;";
                        break;
                    case('transfer'):
                        $result = $this->transferPNM($request);
                        $result['title'] = "Transfer PNM to user";
                        $result['heading']
                            = "<i class='si si-fire'></i> PNM to User <i class='si si-user'></i>";
                        break;
                        break;
                    case('withdraw'):
                        $result = $this->withdrawPNM($request);
                        $result['title'] = "Withdraw PNM to Wallet";
                        $result['heading']
                            = "<i class='si si-fire'></i> PNM to Wallet <i class='fa fa-shopping-bag'></i>";
                        break;
                }
                break;
        }

        $data = $result;
        $data['for'] = $for;
        $data['action'] = $action;
        $data['value'] = $this->home()->getCurrentValue();

        return view("dashboard.transactions.$action", $data);
    }

    public function transferPNM(Request $request)
    {
        $value = $this->home()->getCurrentValue();
        $pnm = $request->input('amount');
        $pin = $request->input('pin');
        $wallet = $request->input('wallet');
        $data = array();

        $ngn = $pnm * (int)$value;
        $chargePNM = Setting::where('name', 'pnm_transfer_charge')
            ->value('value');

        $hasPNM = $this->checkPNM($pnm + $chargePNM);
        $isUser = User::where('wallet_id', $wallet)->where('type', 'user')
            ->first();

        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($hasPNM && $checkPin && $isUser) {
            $description1 = "$pnm PNM transfer from ".Auth::user()->pin." to $wallet";
            $description2
                = "$chargePNM commission charge for $pnm PNM transfer";
            $type1 = "pnm-pnm";
            $type2 = "pnm-holding";

            $transaction1 = new Transaction();
            $transaction2 = new Transaction();

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $transaction1->transaction_id = $transactionID;
            $transaction1->from = Auth::user()->wallet_id;
            $transaction1->to = $wallet;
            $transaction1->amount = $pnm;
            $transaction1->value = $value;
            $transaction1->description = $description1;
            $transaction1->type = $type1;
            $transaction1->status = 'successful';
            $transaction1->remark = 'debit';

            $transaction2->transaction_id = $transactionID;
            $transaction2->from = Auth::user()->wallet_id;
            $transaction2->to = 'holding';
            $transaction2->amount = $chargePNM;
            $transaction2->value = $value;
            $transaction2->description = $description2;
            $transaction2->type = $type2;
            $transaction2->status = 'successful';
            $transaction2->remark = 'debit';


            if ($transaction1->save() && $transaction2->save()) {
                $data['alert'] = 'Success';
                $data['message'] = 'Your transaction request was successful';
            }


        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = 'You entered an incorrect pin';
            } elseif (!$hasPNM) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient PNM balance';
            } elseif (!$isUser) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'The Wallet ID entered does not match any user in our record';
            }
        }
        return $data;
    }

    public function viewTransaction($id)
    {
        // drg >> show just a single transaction
        $data['value'] = $this->home()->getCurrentValue();
        $data['transactions'] = Transaction::where('from',
            Auth::user()->wallet_id)
            ->orWhere('to', Auth::user()->wallet_id)
            ->orWhere('from', Auth::user()->name)
            ->orWhere('to', Auth::user()->name)->get();
        return view('dashboard.transactions.history', $data);
    }

    public function viewTransactions()
    {
        // drg >> show transaction history
        $data['value'] = $this->home()->getCurrentValue();
        $data['transactions'] = Transaction::where('from',
            Auth::user()->wallet_id)
            ->orWhere('to', Auth::user()->wallet_id)
            ->orWhere('from', Auth::user()->name)
            ->orWhere('to', Auth::user()->name)->orderBy('updated_at', 'desc')
            ->get();
        return view('dashboard.transactions.history', $data);
    }

    public function withdrawNGN(Request $request)
    {
        $data = array();
        $value = $this->home()->getCurrentValue();
        $ngn = $request->input('amount');
        $pin = $request->input('pin');

        $pnm = $ngn / (int)$value;
        $charge = Setting::where('name', 'ngn_withdrawal_charge')
            ->value('value');
        $chargePNM = $charge / (int)$value;

        $hasNGN = $this->checkNGN($ngn);
        $hasPNM = $this->checkPNM($chargePNM);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($hasNGN && $hasPNM && $checkPin) {
            $description1 = "Withdrawal request for $ngn NGN";
            $description2
                = "$charge NGN ($chargePNM PNM) commission charge for $ngn NGN withdrawal";
            $type1 = "ngn-bank";
            $type2 = "pnm-holding";

            $transaction1 = new Transaction();
            $transaction2 = new Transaction();

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $transaction1->transaction_id = $transactionID;
            $transaction1->from = Auth::user()->name;
            $transaction1->to = 'user';
            $transaction1->amount = $pnm;
            $transaction1->value = $value;
            $transaction1->description = $description1;
            $transaction1->type = $type1;
            $transaction1->status = 'requested';
            $transaction1->remark = 'debit';

            $transaction2->transaction_id = $transactionID;
            $transaction2->from = Auth::user()->wallet_id;
            $transaction2->to = 'holding';
            $transaction2->amount = $chargePNM;
            $transaction2->value = $value;
            $transaction2->description = $description2;
            $transaction2->type = $type2;
            $transaction2->status = 'requested';
            $transaction2->remark = 'debit';

            if ($transaction1->save() && $transaction2->save()) {
                $data['alert'] = 'Success';
                $data['message'] = 'Your transaction request was successful';
            }


        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = 'You entered an incorrect pin';
            } elseif (!$hasNGN) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient NGN balance';
            } elseif (!$hasPNM) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient PNM balance';
            }
        }
        return $data;
    }

    public function withdrawPNM(Request $request)
    {
        $value = $this->home()->getCurrentValue();
        $pnm = $request->input('amount');
        $pin = $request->input('pin');
        $data = array();

        $ngn = $pnm * (int)$value;
        $chargePNM = Setting::where('name', 'pnm_withdrawal_charge')
            ->value('value');

        $hasPNM = $this->checkPNM($pnm + $chargePNM);

        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($hasPNM && $checkPin) {
            $description1 = "Withdrawal request for $pnm PNM";
            $description2
                = "$chargePNM commission charge for $pnm PNM withdrawal";
            $type1 = "pnm-wallet";
            $type2 = "pnm-holding";

            $transaction1 = new Transaction();
            $transaction2 = new Transaction();

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $transaction1->transaction_id = $transactionID;
            $transaction1->from = Auth::user()->wallet_id;
            $transaction1->to = Auth::user()->wallet_address;
            $transaction1->amount = $pnm;
            $transaction1->value = $value;
            $transaction1->description = $description1;
            $transaction1->type = $type1;
            $transaction1->status = 'requested';
            $transaction1->remark = 'debit';

            $transaction2->transaction_id = $transactionID;
            $transaction2->from = Auth::user()->wallet_id;
            $transaction2->to = 'holding';
            $transaction2->amount = $chargePNM;
            $transaction2->value = $value;
            $transaction2->description = $description2;
            $transaction2->type = $type2;
            $transaction2->status = 'requested';
            $transaction2->remark = 'debit';


            if ($transaction1->save() && $transaction2->save()) {
                $data['alert'] = 'Success';
                $data['message'] = 'Your transaction request was successful';
            }


        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = 'You entered an incorrect pin';
            } elseif (!$hasPNM) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient PNM balance';
            }

        }
        return $data;
    }
}