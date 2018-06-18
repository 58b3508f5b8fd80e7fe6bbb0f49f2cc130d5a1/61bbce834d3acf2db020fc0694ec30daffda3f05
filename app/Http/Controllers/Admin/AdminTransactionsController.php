<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SendSMS;
use App\Transaction;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class AdminTransactionsController extends Controller
{
    //

    public function admin()
    {
        return new AdminController();
    }

    public function verifyTransaction(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('action');
        $transaction = Transaction::find($id - 1127);
        $message = '';
        $verify = false;
        if ($transaction) {
            switch ($action) {
                case('approve'):
                    $verify = Transaction::where('transaction_id',
                        $transaction->transaction_id)->update([
                        'status'     => 'successful',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $message
                        = 'Transaction has been approved successfully.';
                    break;
                case('revoke'):
                    $verify = Transaction::where('transaction_id',
                        $transaction->transaction_id)->update([
                        'status'     => 'successful',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $message = 'The transaction has been revoked';
                    break;
            }
        }

        if ($verify) {
            $search = new AdminSearchController;
            $data = $search->search($request);
            $html = View::make('admin.partials.search', $data);
            $html = $html->render();

            return response()->json([
                'status'  => 'success',
                'message' => $message,
                'html'    => $html
            ]);
        }
    }

    public function verifyWithdrawal(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('action');
        $type = $request->input('type');
        $for = $request->input('for');
        $transaction = Transaction::find($id - 1127);
        $message = '';
        $verify = false;
        if ($transaction) {
            switch ($action) {
                case('approve'):
                    $verify = Transaction::where('transaction_id',
                        $transaction->transaction_id)->update([
                        'status'     => 'successful',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $message
                        = 'Transaction has been approved successfully.';
                    break;
                case('revoke'):
                    $verify = Transaction::where('transaction_id',
                        $transaction->transaction_id)->update([
                        'status'     => 'successful',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $message = 'The transaction has been revoked';
                    break;
            }
        }
        if ($for == 'verified') {
            $data['withdrawals'] = $this->getVerified($type);
        } elseif ($for == 'requested') {
            $data['withdrawals'] = $this->getWithdrawals($type);
        }

        $data['value'] = $this->admin()->getCurrentValue();
        $data['action'] = $action;
        $html = View::make('admin.partials.withdrawal', $data);
        $html = $html->render();

        if ($verify) {
            return response()->json([
                'status'  => 'success',
                'message' => $message,
                'html'    => $html
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Oops an error occurred',
            'html'    => $html
        ]);
    }

    public function getVerified($action)
    {
        $withdrawals = array();
        $status = '';
        switch ($action) {
            case 'pnm':
                $withdrawals = Transaction::where('type', 'pnm-wallet')
                    ->where('status', '<>', 'requested')
                    ->orderBy('updated_at', 'desc')->get();
                break;
            case 'ngn':
                $withdrawals = Transaction::where('type', 'ngn-bank')
                    ->where('status', '<>', 'requested')
                    ->orderBy('updated_at', 'desc')->get();
                break;
            default:
                break;
        }
        return $withdrawals;
    }

    public function getWithdrawals($action,$grade)
    {
        $withdrawals = array();
        switch ($action) {
            case 'pnm':
                $withdrawals = Transaction::join('users', 'users.wallet_id',
                    '=', 'transactions.from')
                    ->join('user_metas', 'user_metas.wallet_address',
                        '=', 'users.wallet_address')
                    ->where('transactions.type', 'pnm-wallet')
                    ->where('transactions.status', 'requested')
                    ->where('users.grade',$grade)
                    ->select("transactions.*", "user_metas.bank_name",
                        "user_metas.wallet_address", "user_metas.bank_acc_no")
                    ->orderBy('transactions.updated_at', 'desc')->get();
                break;
            case 'ngn':
                $withdrawals = Transaction::leftJoin('users', 'users.name',
                    '=', 'transactions.from')
                    ->leftJoin('user_metas', 'user_metas.wallet_address',
                        '=', 'users.wallet_address')
                    ->where('transactions.type', 'ngn-bank')
                    ->where('transactions.status', 'requested')
                    ->where('users.grade',$grade)
                    ->select("transactions.*", "user_metas.bank_name",
                        "user_metas.wallet_address", "user_metas.bank_acc_no")
                    ->orderBy('transactions.updated_at', 'desc')->get();
                break;
            default:
                break;
        }
        return $withdrawals;
    }

    public function checkPNM($amount)
    {
        $balance = $this->admin()->getTotalReserve();
        if ($balance >= $amount) {
            return true;
        }
        return false;
    }

    public function sharePNM(Request $request)
    {
        $value = $this->admin()->getCurrentValue();
        $pnm = $request->input('pnm');
        $pin = $request->input('pin');
        $wallet = $request->input('wallet');

        $data['action'] = 'new PNM';
        $isUser = User::where('wallet_id', $wallet)
            ->where('wallet_id', '<>', Auth::user()->wallet_id)->first();
        $checkPin = Hash::check($pin, Auth::user()->pin);
        $checkPNM = $this->checkPNM($pnm);
        if ($checkPin && $isUser && $checkPNM) {
            $ngn = $pnm * (int)$value;
            $description = "Admin shared $pnm PNM worth $ngn NGN";
            $type = "holding-pnm";
            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));

            $trans = $this->transaction($transactionID,
                Auth::user()->wallet_id, $wallet,
                $pnm, $description,
                $type, 'successful', 'credit');
            if ($trans) {
                $data['alert'] = 'success';
                $data['message'] = "Your transaction was successful";
            }
        } else {
            if (!$checkPin) {
                $data['alert'] = 'danger';
                $data['message'] = "Sorry, the pin you entered was incorrect";
            } elseif (!$isUser) {
                $data['alert'] = 'danger';
                $data['message']
                    = "Sorry, the wallet id was not traced to any user";
            } elseif (!$checkPNM) {
                $data['alert'] = 'danger';
                $data['message']
                    = "Sorry, you don't have sufficient PNM to complete this transaction";
            }
        }


        return redirect('admin/transactions/share')->with('data', $data);

        // return view('admin.newPNM', $data);
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

        $value = $this->admin()->getCurrentValue();
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

        $message
            = "Wallet $remark!\nAmt: $amount\nDesc: $description is $status.\nDate: "
            . date('d-m-Y H:i') . "\nID: " . substr($transactionID, 0,
                6)
            . '...' . substr($transactionID, -6);
        $to = User::where('wallet_id', $to)->value('phone_no');
        $sms = new SendSMS();
        $response = $sms->sendSMS($to, $message);

        return $save;
    }


    public function viewShare()
    {
        $data['action'] = 'share PNM';
        return view('admin.sharePNM', $data);
    }

    public function viewTransactions()
    {
        // drg >> show transaction history
        $data['value'] = $this->admin()->getCurrentValue();
        $data['transactions'] = Transaction::where('from',
            Auth::user()->wallet_id)
            ->orWhere('to', Auth::user()->wallet_id)
            ->orWhere('from', Auth::user()->name)
            ->orWhere('to', Auth::user()->name)->orderBy('updated_at', 'desc')
            ->get();
        return view('admin.transactionHistory', $data);
    }

    public function viewVerified($action)
    {
        $data = array();
        $data['withdrawals'] = $this->getVerified($action);
        $data['value'] = $this->admin()->getCurrentValue();
        $data['type'] = 'verified';
        $data['action'] = $action;
        return view('admin.withdrawals', $data);
    }

    public function viewWithdrawal($action, $grade='student')
    {
        $data = array();
        $data['withdrawals'] = $this->getWithdrawals($action, $grade);
        $data['value'] = $this->admin()->getCurrentValue();
        $data['type'] = 'requested';
        $data['action'] = $action;
        return view('admin.withdrawals', $data);
    }


}
