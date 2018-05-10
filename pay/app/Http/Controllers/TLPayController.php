<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TLPayController extends Controller
{
    //
    public function doTransaction(Request $request)
    {
        $user = User::where('key', $request->key)->first();
        if ($user) {
            $http = new Client();
            try {
                $response = $http->post(config('tlsavings.url')
                    . '/oauth/token', [
                    'form_params' => [
                        'grant_type'    => 'password',
                        'client_id'     => config('tlsavings.id'),
                        'client_secret' => config('tlsavings.secret'),
                        'username'      => $request->name,
                        'password'      => $request->pin,
                        'scope'         => 'transactions',
                    ],
                ]);

                $auth = json_decode((string)$response->getBody());

                $response = $http->request('post',
                    config('tlsavings.url') . '/api/tlpay', [
                        'headers'     => [
                            'Accept'        => 'application/json',
                            'Authorization' => 'Bearer '
                                . $auth->access_token,
                        ],
                        'form_params' => [
                            'amount'      => $request->amount,
                            'description' => $request->description,
                            'key'         => $request->key,
                        ]
                    ]);
                $details = json_decode((string)$response->getBody());
            } catch (\Exception $e) {
                return redirect("/error/401");
            }
            if ($details->status) {
                $transaction = Transaction::find($request->id - 1137);
                $transaction->from = $request->email;
                $transaction->status = 'successful';

                $sms = new SendSMS();
                $message
                    = "Dear $user->name, you recieved a payment of $request->amount from $request->email on "
                    . date('Y-m-d H:i:s') . ". $request->description.\n\n".config('app.name');
                $sms->sendSMS($user->phone_no,$message);
                if ($transaction->save()) {
                    $query = http_build_query([
                        'id' => $transaction->transaction_id,
                    ]);
                    return redirect("$request->callback?$query");
                }

            }
        }
        return false;
    }

    public function verify(Request $request)
    {
        $id = $request->id;
        $transaction = Transaction::where('transaction_id', $id)->first();
        if ($transaction) {
            return response()->json([
                'status'         => true,
                'from'           => $transaction->from,
                'amount'         => $transaction->amount,
                'charge'         => $transaction->charge,
                'transaction_id' => $transaction->transaction_id,
                'description'    => $transaction->description,
                'remark'         => $transaction->status,
            ], 200);
        }
        return response()->json([
            'status'  => false,
            'message' => "Oops.. We can't verify this transaction.<br>An error occured while processing this request."
        ], 400);
    }
}
