<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/tlpay', 'TLPayController@doTransaction');
Route::post('/verify/transactions','TLPayController@verify');
Route::get('/verify/transactions','TLPayController@verify');
Route::post('/get/tlpay/verify', function (Request $request) {
    // drg >> list out form parameters
    $key = $request->key;
    $secret = $request->secret;
    $amount = $request->amount;
    $description = $request->description;
    // drg >> validate requests
    $isKey = \App\User::where('key', $key)->first();
    $validSecret = \App\User::where('secret', $secret)->first();
    $checkCredentials = \Illuminate\Support\Facades\Hash::check($key, $secret);
    $data = array();
    if ($isKey && $validSecret && $checkCredentials) {
        if (!($amount === null || $amount <= 0 || !is_numeric($amount))) {

            $transactionID = md5("$key,$secret," . mt_rand() . date('YmdHis'));
            $transaction = new \App\Transaction();
            $transaction->transaction_id = $transactionID;
            $transaction->amount = $amount;
            $transaction->description = $description;
            $transaction->status = 'pending';
            $transaction->to = $key;
            if ($transaction->save()) {
                $data['amount'] = $amount;
                $data['id'] = $transaction->id+1137;
                $data['key'] = $key;
                $data['email'] = $request->email;
                $data['callback'] = $request->callback;
                $data['description'] = $description;
            }else {
                $data['error'] = "Oops! An error occured, we will look into it.";
            }
        }
        else {
            $data['error'] = "Oops! We recieved an invalid value for amount";
        }
    } else {
        $data['error'] = "Oops! Your credentials were not recognized";
    }
    $html = View::make('authenticate', $data);
    $html = $html->render();
    return response()->json([
        'html' => $html
    ]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
