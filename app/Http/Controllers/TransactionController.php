<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Transaction;
use App\User;
use App\User_meta;
use GuzzleHttp\Client;
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
        $grade = Auth::user()->grade;
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
                        $data['duration'] = Setting::where('name',
                            'ngn_withdrawal_duration')
                            ->value('value');
                        $data['max_withdrawal'] = Setting::where('name',
                            $grade.'_ngn_withdrawal_limit')
                            ->value('value');
                        $data['max_daily_withdrawal'] = Setting::where('name',
                            $grade.'_ngn_daily_withdrawal_limit')
                            ->value('value');
                        $data['pnm_balance']=$this->checkPNM();
                        $data['ngn_balance']=$this->checkNGN();
                        $data['today']=$this->checkDailyNGNWithdrawals();
                        $data['commission']=Setting::where('name', 'ngn_withdrawal_charge')
                            ->value('value');
                        break;
                    default:
                        return view('errors.404');
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
                        $data['duration'] = Setting::where('name',
                            'pnm_withdrawal_duration')
                            ->value('value');
                        $data['max_withdrawal'] = Setting::where('name',
                            $grade.'_pnm_withdrawal_limit')
                            ->value('value');
                        $data['max_daily_withdrawal'] = Setting::where('name',
                            $grade.'_pnm_daily_withdrawal_limit')
                            ->value('value');
                        $data['pnm_balance']=$this->checkPNM();
                        $data['ngn_balance']=$this->checkNGN();
                        $data['today']=$this->checkDailyNGNWithdrawals();
                        $data['commission']=Setting::where('name', 'ngn_withdrawal_charge')
                              ->value('value');
                        break;
                    default:
                        return view('errors.404');
                }
                break;
            default:
                return view('errors.404');
        }
        return view("dashboard.transactions.$action", $data);
    }

    public function checkDailyNGNWithdrawals($ngn=null)
    {
        $grade = Auth::user()->grade;
        $limit = Setting::where('name', $grade.'_ngn_daily_withdrawal_limit')
            ->value('value');
        $amount = Transaction::where('type', 'ngn-bank')
            ->where('from', Auth::user()->name)
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->where('status', 'requested')->sum(DB::raw('amount*value'));
        $amount=$amount / 100000;
        if ($ngn===null){
            return $amount;
        }
        elseif ($amount + $ngn < $limit) {
            return true;
        }
        return false;
    }

    public function checkDailyPNMWithdrawals($pnm)
    {
        $grade = Auth::user()->grade;
        $limit = Setting::where('name', $grade.'_pnm_daily_withdrawal_limit')
            ->value('value');
        $amount = Transaction::where('type', 'pnm-wallet')
            ->where('from', Auth::user()->wallet_id)->whereDate('created_at',
                DB::raw('CURDATE()'))->where('status', 'requested')
            ->sum('amount');
        if ($amount / 100000 + $pnm < $limit) {
            return true;
        }
        return false;
    }

    public function checkNGN($amount=null)
    {
        $balance = $this->home()->getTotalNGN() / 100000;
        if ($amount===null){
            return $balance;
        }
        elseif ($balance >= $amount) {
            return true;
        }
        return false;
    }

    public function checkPNM($amount=null)
    {
        $balance = $this->home()->getTotalPNM() / 100000;
        if($amount === null){
            return $balance;
        }
        elseif ($balance >= $amount) {
            return true;
        }
        return false;
    }

    public function checkNGNWithdrawalLimit($ngn)
    {
        $grade = Auth::user()->grade;
        $limit = Setting::where('name', $grade . '_ngn_withdrawal_limit')
            ->value('value');

        if ($ngn <= $limit) {
            return true;
        }
        return false;
    }

    public function checkPNMWithdrawalLimit($pnm)
    {
        $grade = Auth::user()->grade;
        $limit = Setting::where('name', $grade . '_pnm_withdrawal_limit')
            ->value('value');
        $amount = Transaction::where('type', 'pnm-wallet')
            ->where('from', Auth::user()->wallet_id)->whereDate('created_at',
                DB::raw('CURDATE()'))->where('status', 'successful')
            ->sum('amount');
        if ($amount / 100000 + $pnm <= $limit) {
            return true;
        }
        return false;
    }

    public function checkPNMTransferLimit($pnm)
    {
        $grade = Auth::user()->grade;
        $limit = Setting::where('name', $grade.'_pnm_transfer_limit')->value('value');

        $amount = Transaction::where('type', 'pnm-pnm')
            ->where('from', Auth::user()->wallet_id)->whereDate('created_at',
                DB::raw('CURDATE()'))->where('status', 'successful')
            ->sum('amount');
        if ($amount / 100000 + $pnm <= $limit) {
            return true;
        }
        return false;
    }

    public function checkDailyPNMConversionLimit($pnm)
    {
        $grade = Auth::user()->grade;
        $limit = Setting::where('name', $grade.'_pnm_daily_conversion_limit')
            ->value('value');
        $amount = Transaction::where('type', 'pnm-ngn')
            ->where('from', Auth::user()->wallet_id)->whereDate('created_at',
                DB::raw('CURDATE()'))->where('status', 'successful')
            ->sum('amount');
        //echo "$amount ". ($amount/100000) + $pnm. " $pnm $limit";
        if ($amount / 100000 + $pnm <= $limit) {
            return true;
        }
        return false;
    }

    public function checkPNMConversionLimit($pnm)
    {
        $grade = Auth::user()->grade;
        $limit = Setting::where('name', $grade.'_pnm_conversion_limit')->value('value');
        if ($pnm <= $limit) {
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

            $transactionID = md5(Auth::user()->wallet_id . $ngn . $pnm
                . date('YFlHisuA'));

            $trans = $this->transaction($transactionID,
                Auth::user()->name, Auth::user()->wallet_id,
                $pnm, $description,
                $type, 'successful', 'credit');
            if ($trans) {
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
        $chargeNGN = $chargePNM * $value;

        $hasPNM = $this->checkPNM($pnm + $chargePNM);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        $checkLimit = $this->checkPNMConversionLimit($pnm);
        $checkDailyLimit = $this->checkDailyPNMConversionLimit($pnm);
        if ($hasPNM && $checkPin && $checkLimit && $checkDailyLimit) {
            $description1 = "Conversion of $pnm PNM to $ngn NGN";
            $description2
                = "$chargePNM PNM commission charge for $pnm PNM conversion";
            $type1 = "pnm-ngn";
            $type2 = "pnm-holding";

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $trans1 = $this->transaction($transactionID,
                Auth::user()->wallet_id, Auth::user()->name,
                $pnm, $description1,
                $type1, 'successful', 'debit');
            $trans2 = $this->transaction($transactionID,
                Auth::user()->wallet_id, 'holding',
                $chargePNM, $description2,
                $type2, 'successful', 'debit');

            if ($trans1 && $trans2) {
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
            } elseif (!$checkDailyLimit) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'You cannot exceed your daily conversion limit';
            } elseif (!$checkLimit) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'You cannot exceed your conversion limit per transaction';
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

        return redirect("transaction/$for/$action")->with('data', $data);
    }

    public function transaction(
        $transactionID,
        $from,
        $to,
        $amount,
        $description,
        $type,
        $status,
        $remark
    ) {

        $client = new Client;

        $value = $this->home()->getCurrentValue();
        $transaction = new Transaction();
        $transaction->transaction_id = $transactionID;
        $transaction->from = $from;
        $transaction->to = $to;
        $transaction->amount = $amount * 100000;
        $transaction->value = $value;
        $transaction->description = $description;
        $transaction->type = $type;
        $transaction->status = $status;
        $transaction->remark = $remark;
        $save = $transaction->save();
        try {
            if ($type == 'pnm-pnm') {
                $message
                    = "Wallet credit!\nAmt: $amount\nDesc: $description is $status.\nDate: "
                    . date('d-m-Y H:i') . "\nID: " . substr($transactionID, 0,
                        6)
                    . '...' . substr($transactionID, -6);
                $sms = new SendSMS();
                $response = $sms->sendSMS(User::where('wallet_id', $to)
                    ->first()->phone_no, $message);
            }
            $message
                = "Wallet $remark!\nAmt: $amount\nDesc: $description\nDate: "
                . date('d-m-Y H:i') . "\nID: " . substr($transactionID, 0, 6)
                . '...' . substr($transactionID, -6) . "\nBal: " . $this->home()
                    ->getTotalPNM() / 100000;
            $sms = new SendSMS();
            $response = $sms->sendSMS(Auth::user()->phone_no, $message);
        } catch (\Exception $e) {

        }
        return $save;
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
        $isUser = User::where('wallet_id', $wallet)
            ->where('wallet_id', '<>', Auth::user()->wallet_id)
            ->where('type', 'user')
            ->first();

        $checkPin = Hash::check($pin, Auth::user()->pin);
        $checkLimit = $this->checkPNMTransferLimit($pnm);
        if ($hasPNM && $checkPin && $isUser && $checkLimit) {
            $description1 = "$pnm PNM transfer from "
                . substr(Auth::user()->wallet_id, 0, 6) . '...'
                . substr(Auth::user()->wallet_id, -6)
                . " to " . substr($wallet, 0, 6) . '...' . substr($wallet, -6);
            $description2
                = "$chargePNM commission charge for $pnm PNM transfer";
            $type1 = "pnm-pnm";
            $type2 = "pnm-holding";

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $trans1 = $this->transaction($transactionID,
                Auth::user()->wallet_id, $wallet,
                $pnm, $description1,
                $type1, 'successful', 'debit');
            $trans2 = $this->transaction($transactionID,
                Auth::user()->wallet_id, 'holding',
                $chargePNM, $description2,
                $type2, 'successful', 'debit');

            if ($trans1 && $trans2) {
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
                    = 'The Wallet ID entered does not match any valid user in our record';
            } elseif (!$checkLimit) {
                $data['alert'] = 'danger';
                $data['message']
                    = 'You cannot exceed the transfer daily limit of transaction';
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
            ->value('value');

        $hasNGN = $this->checkNGN($ngn);
        $hasPNM = $this->checkPNM($chargePNM);
        $checkPin = Hash::check($pin, Auth::user()->pin);
        $checkLimit = $this->checkNGNWithdrawalLimit($ngn);
        $checkDaily = $this->checkDailyNGNWithdrawals($ngn);
        if ($hasNGN && $hasPNM && $checkPin && $checkLimit && $checkDaily) {
            $description1 = "Withdrawal request for $ngn NGN";
            $description2
                = "$chargePNM NGN ($chargePNM PNM) commission charge for $ngn NGN withdrawal";
            $type1 = "ngn-bank";
            $type2 = "pnm-holding";

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $trans1 = $this->transaction($transactionID,
                Auth::user()->name, 'user',
                $pnm, $description1,
                $type1, 'requested', 'debit');
            $trans2 = $this->transaction($transactionID,
                Auth::user()->wallet_id, 'holding',
                $chargePNM, $description2,
                $type2, 'requested', 'debit');

            if ($trans1 && $trans2) {
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
        $checkLimit = $this->checkPNMWithdrawalLimit($pnm);
        $checkDaily = $this->checkDailyPNMWithdrawals($pnm);
        if ($hasPNM && $checkPin && $checkLimit && $checkDaily) {
            $description1 = "Withdrawal request for $pnm PNM";
            $description2
                = "$chargePNM commission charge for $pnm PNM withdrawal";
            $type1 = "pnm-wallet";
            $type2 = "pnm-holding";

            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $trans1 = $this->transaction($transactionID,
                Auth::user()->wallet_id, Auth::user()->wallet_address,
                $pnm, $description1,
                $type1, 'requested', 'debit');
            $trans2 = $this->transaction($transactionID,
                Auth::user()->wallet_id, 'holding',
                $chargePNM, $description2,
                $type2, 'requested', 'debit');

            if ($trans1 && $trans2) {
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