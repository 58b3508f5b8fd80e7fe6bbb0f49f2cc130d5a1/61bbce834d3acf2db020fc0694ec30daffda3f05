<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                        $data['duration'] = Setting::where('name',
                            'ngn_withdrawal_duration')
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
                        $data['duration'] = Setting::where('name',
                            'pnm_withdrawal_duration')
                            ->value('value');
                        break;
                }
                break;
        }
        return view("dashboard.transactions.$action", $data);
    }

    public function checkDailyNGNWithdrawals()
    {
        $limit = Setting::where('name', 'ngn_daily_withdrawal_limit')
            ->value('value');
        $number = Transaction::where('type', 'ngn-bank')
            ->where('from', Auth::user()->name)
            ->whereDate('created_at', DB::raw('CURDATE()'))->count();
        if ($number < $limit) {
            return true;
        }
        return false;
    }

    public function checkDailyPNMWithdrawals()
    {
        $limit = Setting::where('name', 'pnm_daily_withdrawal_limit')
            ->value('value');
        $number = Transaction::where('type', 'pnm-wallet')
            ->where('from', Auth::user()->wallet_id)->whereDate('created_at',
                DB::raw('CURDATE()'))->count();
        if ($number < $limit) {
            return true;
        }
        return false;
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

    public function checkNGNLimit($ngn)
    {
        $limit = Setting::where('name', 'ngn_withdrawal_limit')->value('value');
        $amount = Transaction::where('type', 'ngn-bank')
            ->where('from', Auth::user()->name)
            ->whereDate('created_at', DB::raw('CURDATE()'))->sum('amount');

        if ($amount + $ngn <= $limit) {
            return true;
        }
        return false;
    }

    public function checkPNMLimit($pnm)
    {
        $limit = Setting::where('name', 'pnm_withdrawal_limit')->value('value');
        $amount = Transaction::where('type', 'pnm-wallet')
            ->where('from', Auth::user()->wallet_id)->whereDate('created_at',
                DB::raw('CURDATE()'))->sum('amount');
        if ($amount + $pnm <= $limit) {
            return true;
        }
        return false;
    }

    public function checkPNMTransferLimit($pnm)
    {
        $limit = Setting::where('name', 'pnm_transfer_limit')->value('value');
        $amount = Transaction::where('type', 'pnm-pnm')
            ->where('from', Auth::user()->wallet_id)->whereDate('created_at',
                DB::raw('CURDATE()'))->sum('amount');
        if ($amount + $pnm <= $limit) {
            return true;
        }
        return false;
    }

    public function checkPNMConversionLimit($pnm)
    {
        $limit = Setting::where('name', 'pnm_conversion_limit')->value('value');
        $amount = Transaction::where('type', 'pnm-ngn')
            ->where('from', Auth::user()->wallet_id)->whereDate('created_at',
                DB::raw('CURDATE()'))->sum('amount');
        if ($amount + $pnm <= $limit) {
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
            $transaction->amount = $pnm*100000;
            $transaction->value = $value;
            $transaction->description = $description;
            $transaction->type = $type;
            $transaction->status = 'successful';
            $transaction->remark = 'credit';
            $transaction->save();
        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = 'You entered an incorrect pin';
            } elseif (!$hasNGN) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient NGN balance';
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
        $chargePNM = Setting::where('name', 'pnm_conversion_charge')
            ->value('value');
        $chargeNGN = $chargePNM*$value;

        $hasPNM = $this->checkPNM($pnm + $chargePNM);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        $checkLimit = $this->checkPNMConversionLimit($pnm);
        if ($hasPNM && $checkPin && $checkLimit) {
            $description1 = "Conversion of $pnm PNM to $ngn NGN";
            $description2
                = "$chargeNGN NGN ($chargePNM PNM) commission charge for $pnm PNM conversion";
            $type1 = "pnm-ngn";
            $type2 = "pnm-holding";

            $transaction1 = new Transaction();
            $transaction2 = new Transaction();

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $transaction1->transaction_id = $transactionID;
            $transaction1->from = Auth::user()->wallet_id;
            $transaction1->to = Auth::user()->name;
            $transaction1->amount = $pnm*100000;
            $transaction1->value = $value;
            $transaction1->description = $description1;
            $transaction1->type = $type1;
            $transaction1->status = 'successful';
            $transaction1->remark = 'debit';

            $transaction2->transaction_id = $transactionID;
            $transaction2->from = Auth::user()->wallet_id;
            $transaction2->to = 'holding';
            $transaction2->amount = $chargePNM*100000;
            $transaction2->value = $value;
            $transaction2->description = $description2;
            $transaction2->type = $type2;
            $transaction2->status = 'successful';
            $transaction2->remark = 'debit';

            if ($transaction1->save() && $transaction2->save()) {
                $data['alert'] = 'success';
                $data['message'] = 'Your transaction request was successful';
            }

        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = 'You entered an incorrect pin';
            } elseif (!$hasPNM) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient PNM balance';
            } elseif (!$checkLimit) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'You cannot exceed your daily conversion limit';
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

        return redirect("transaction/$for/$action")->with('data',$data);
        //return view("dashboard.transactions.$action", $data);
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
        $checkLimit = $this->checkPNMTransferLimit($pnm);
        if ($hasPNM && $checkPin && $isUser && $checkLimit) {
            $description1 = "$pnm PNM transfer from " . Auth::user()->pin
                . " to $wallet";
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
            $transaction1->amount = $pnm*100000;
            $transaction1->value = $value;
            $transaction1->description = $description1;
            $transaction1->type = $type1;
            $transaction1->status = 'successful';
            $transaction1->remark = 'debit';

            $transaction2->transaction_id = $transactionID;
            $transaction2->from = Auth::user()->wallet_id;
            $transaction2->to = 'holding';
            $transaction2->amount = $chargePNM*100000;
            $transaction2->value = $value;
            $transaction2->description = $description2;
            $transaction2->type = $type2;
            $transaction2->status = 'successful';
            $transaction2->remark = 'debit';


            if ($transaction1->save() && $transaction2->save()) {
                $data['alert'] = 'success';
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
            } elseif (!$checkLimit) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'You cannot exceed the withdrawal limit';
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
        $chargePNM = Setting::where('name', 'ngn_withdrawal_charge')
            ->value('value');;

        $hasNGN = $this->checkNGN($ngn);
        $hasPNM = $this->checkPNM($chargePNM);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        $checkLimit = $this->checkNGNLimit($ngn);
        $checkDaily = $this->checkDailyNGNWithdrawals();
        if ($hasNGN && $hasPNM && $checkPin && $checkLimit && $checkDaily) {
            $description1 = "Withdrawal request for $ngn NGN";
            $description2
                = "$chargePNM NGN ($chargePNM PNM) commission charge for $ngn NGN withdrawal";
            $type1 = "ngn-bank";
            $type2 = "pnm-holding";

            $transaction1 = new Transaction();
            $transaction2 = new Transaction();

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $transaction1->transaction_id = $transactionID;
            $transaction1->from = Auth::user()->name;
            $transaction1->to = 'user';
            $transaction1->amount = $pnm*100000;
            $transaction1->value = $value;
            $transaction1->description = $description1;
            $transaction1->type = $type1;
            $transaction1->status = 'requested';
            $transaction1->remark = 'debit';

            $transaction2->transaction_id = $transactionID;
            $transaction2->from = Auth::user()->wallet_id;
            $transaction2->to = 'holding';
            $transaction2->amount = $chargePNM*100000;
            $transaction2->value = $value;
            $transaction2->description = $description2;
            $transaction2->type = $type2;
            $transaction2->status = 'requested';
            $transaction2->remark = 'debit';

            if ($transaction1->save() && $transaction2->save()) {
                $data['alert'] = 'success';
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
            } elseif (!$checkLimit) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'Sorry, you have exceeded the withdrawal limit';
            } elseif (!$checkDaily) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'Sorry, you have exceeded the daily withdrawal limit';
            }
        }
        $data['duration'] = Setting::where('name',
            'ngn_withdrawal_duration')
            ->value('value');
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
        $checkLimit = $this->checkPNMLimit($pnm);
        $checkDaily = $this->checkDailyNGNWithdrawals();
        if ($hasPNM && $checkPin && $checkLimit && $checkDaily) {
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
            $transaction1->amount = $pnm*100000;
            $transaction1->value = $value;
            $transaction1->description = $description1;
            $transaction1->type = $type1;
            $transaction1->status = 'requested';
            $transaction1->remark = 'debit';

            $transaction2->transaction_id = $transactionID;
            $transaction2->from = Auth::user()->wallet_id;
            $transaction2->to = 'holding';
            $transaction2->amount = $chargePNM*100000;
            $transaction2->value = $value;
            $transaction2->description = $description2;
            $transaction2->type = $type2;
            $transaction2->status = 'requested';
            $transaction2->remark = 'debit';


            if ($transaction1->save() && $transaction2->save()) {
                $data['alert'] = 'success';
                $data['message'] = 'Your transaction request was successful';
            }


        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = 'You entered an incorrect pin';
            } elseif (!$hasPNM) {
                $data['alert'] = 'danger';
                $data['message'] = 'You have an insufficient PNM balance';
            } elseif (!$checkLimit) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'Sorry, you have exceeded the withdrawal limit';
            } elseif (!$checkDaily) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'Sorry, you have exceeded the daily withdrawal limit';
            }

        }
        $data['duration'] = Setting::where('name',
            'pnm_withdrawal_duration')
            ->value('value');
        return $data;
    }
}