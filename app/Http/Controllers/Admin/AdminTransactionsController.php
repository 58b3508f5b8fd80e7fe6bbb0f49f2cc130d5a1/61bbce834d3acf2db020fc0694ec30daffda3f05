<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
use App\User;
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

    public function verifyWithdrawal(Request $request)
    {

        $id = $request->input('id');
        $action = $request->input('action');
        $type = $request->input('type');
        $for = $request->input('for');
        $transaction = Transaction::find($id - 1127);
        $message = '';

        switch ($action) {
            case('approve'):
                $transaction->status = 'successful';
                $message
                    = 'Transaction has been approved successfully.';
                break;
            case('revoke'):
                $transaction->status = 'failed';
                $message = 'The transaction has been revoked';
                break;
        }

        if ($transaction->save()) {
            if ($for == 'verified') {
                $data['withdrawals'] = $this->getVerified($type);
            } elseif ($for == 'requested') {
                $data['withdrawals'] = $this->getWithdrawals($type);
            }
            $data['value'] = $this->admin()->getCurrentValue();
            $data['action'] = $action;
            $html = View::make('admin.partials.withdrawal', $data);
            $html = $html->render();

            return response()->json([
                'status'  => 'success',
                'message' => $message,
                'html'    => $html
            ]);
        }


        return response()->json([
            'status'  => 'failed',
            'message' => 'Sorry, an error occurred.'
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
                    ->where('status', '<>', $status)
                    ->orderBy('updated_at', 'desc')->get();
                break;
            default:
                break;
        }
        return $withdrawals;
    }

    public function getWithdrawals($action)
    {
        $withdrawals = array();
        switch ($action) {
            case 'pnm':
                $withdrawals = Transaction::where('type', 'pnm-wallet')
                    ->where('status', 'requested')
                    ->orderBy('updated_at', 'desc')->get();
                break;
            case 'ngn':
                $withdrawals = Transaction::where('type', 'ngn-bank')
                    ->where('status', 'requested')
                    ->orderBy('updated_at', 'desc')->get();
                break;
            default:
                break;
        }
        return $withdrawals;
    }

    public function sharePNM(Request $request)
    {
        $value = $this->admin()->getCurrentValue();
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
                $data['message']
                    = "Sorry, the wallet id was not traced to any user";
            }
        }

        return view('admin.newPNM', $data);
    }

    public function viewShare()
    {
        $data['action'] = 'share PNM';
        return view('admin.sharePNM', $data);
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

    public function viewWithdrawal($action)
    {
        $data = array();
        $data['withdrawals'] = $this->getWithdrawals($action);
        $data['value'] = $this->admin()->getCurrentValue();
        $data['type'] = 'requested';
        $data['action'] = $action;
        return view('admin.withdrawals', $data);
    }


}
