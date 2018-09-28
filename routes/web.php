<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::middleware(['checkMaintenance'])->group(function () {
    Route::get('/register', function (\Illuminate\Http\Request $request) {
        if ($request->session()->has('user')) {
            $request->session()->reflash();
            return view('auth.register');
        }
        return redirect('/join');
    });

    Route::get('/join', 'Auth\RegisterController@showJoinForm');

    Route::post('/register', 'Auth\RegisterController@join');
    Route::put('/register', 'Auth\RegisterController@register');

    Route::middleware(['auth', 'isUser', 'isVerified'])
        ->group(function () {
            // drg >> "get" routes arranged alphabetically
            Route::get('/', 'HomeController@index');
            Route::get('/home', 'HomeController@index')->name('home');
            Route::get('/dashboard', 'HomeController@index');
            // drg >> transactions
            Route::get('/transaction/{for}/{action}',
                'TransactionController@index');
            Route::get('/transaction/{id}',
                'TransactionController@viewTransaction');
            Route::get('/transactions',
                'TransactionController@viewTransactions');
            Route::get('/settings', 'SettingsController@index');
            Route::get('/statistics', 'HomeController@statistics');
            Route::get('/settings', 'SettingsController@index');
            Route::get('/settings/{action}', 'SettingsController@index');
            // drg >> "post" routes arranged alphabetically
            Route::post('/transaction/{for}/{action}',
                'TransactionController@process');
            Route::post('/settings/password',
                'SettingsController@changePassword');
            Route::post('/settings/pin', 'SettingsController@changePin');

        });

    Route::middleware(['auth', 'isAdmin', 'isVerified'])
        ->group(function () {
            Route::namespace('Admin')->group(function () {
                Route::prefix('/admin')->group(function () {
                    Route::middleware(['adminLevel'])
                        ->group(function () {

                            Route::get('', 'AdminController@index');
                            Route::get('/dashboard', 'AdminController@index');
                            // drg >> transaction functions
                            Route::get('/transactions/verified/{grade}/{action}',
                                'AdminTransactionsController@viewVerified');
                            // drg >> add functions
                            Route::get('/add/user',
                                'AdminAddController@viewAddUser');
                            Route::post('/add/user',
                                'AdminAddController@addUser');
                            Route::post('/add/user/getlgas',
                                'AdminAddController@getLGAs');
                            // drg >> users functions
                            Route::get('users/active',
                                'AdminUserController@viewActiveUsers');
                            Route::get('users/all',
                                'AdminUserController@viewAllUsers');
                            Route::get('users/blocked',
                                'AdminUserController@viewBlockedUsers');
                            Route::get('users/registered',
                                'AdminUserController@viewRegisteredUsers');
                            Route::get('users/unregistered',
                                'AdminUserController@viewUnregisteredUsers');
                            Route::get('users/suspended',
                                'AdminUserController@viewSuspendedUsers');
                            Route::post('users/active',
                                'AdminUserController@dataTableActiveUsers');
                            Route::post('users/all',
                                'AdminUserController@dataTableAllUsers');
                            Route::post('users/blocked',
                                'AdminUserController@dataTableBlockedUsers');
                            Route::post('users/registered',
                                'AdminUserController@dataTableRegisteredUsers');
                            Route::post('users/unregistered',
                                'AdminUserController@dataTableUnregisteredUsers');
                            Route::post('users/suspended',
                                'AdminUserController@dataTableSuspendedUsers');

                            // drg >> settings functions
                            Route::get('settings',
                                'AdminSettingsController@index');

                            // drg >> search
                            Route::get('/search',
                                'AdminSearchController@index');
                            Route::post('/add/user',
                                'AdminAddController@addUser');
                            Route::post('/add/user/getlgas',
                                'AdminAddController@getLGAs');

                            Route::post('/settings/password',
                                'AdminSettingsController@changePassword');
                            Route::post('/settings/pin',
                                'AdminSettingsController@changePin');

                            Route::middleware(['seniorAdminLevel'])
                                ->group(function () {

                                    Route::get('/transactions/withdrawal/{action}/{grade?}',
                                        'AdminTransactionsController@viewWithdrawal');
                                    Route::get('/transactions/share',
                                        'AdminTransactionsController@viewShare');
                                    Route::get('/transactions/history',
                                        'AdminTransactionsController@viewTransactions');
                                    // drg >> handling transaction functions
                                    Route::post('/transactions/verify',
                                        'AdminTransactionsController@verifyTransaction');
                                    Route::post('/transactions/withdrawal',
                                        'AdminTransactionsController@verifyWithdrawal');
                                    Route::post('/transactions/share',
                                        'AdminTransactionsController@sharePNM');
                                    Route::post('/transactions/share',
                                        'AdminTransactionsController@sharePNM');
                                    Route::get('/transactions/history',
                                        'AdminTransactionsController@viewTransactions');

                                    Route::get('/add/admin',
                                        'AdminAddController@viewAddAdmin');
                                    Route::post('/users/verify',
                                        'AdminUserController@verifyUser');
                                    Route::post('/edit/user',
                                        'AdminEditController@viewuser');
                                    Route::put('/edit/user',
                                        'AdminEditController@editUser');
                                    Route::post('/edit/viewuser',
                                        'AdminEditController@getUser');
                                    Route::post('/edit/user',
                                        'AdminEditController@editUser');
                                    Route::post('/edit/user/account',
                                        'AdminEditController@linkAccount');
                                    Route::post('/add/admin',
                                        'AdminAddController@addAdmin');
                                    Route::middleware(['superAdminLevel'])
                                        ->group(function () {
                                            // drg >> add functions
                                            Route::get('users/admin',
                                                'AdminUserController@viewAdmins');
                                            Route::get('/add/pnm',
                                                'AdminAddController@viewAddPnm');

                                            // drg >> handling settings functions
                                            Route::post('/settings/app',
                                                'AdminSettingsController@updateSettings');
                                            Route::post('/add/pnm',
                                                'AdminAddController@addPNM');
                                            Route::post('/edit/viewadmin',
                                                'AdminEditController@getAdmin');
                                            Route::post('/edit/admin',
                                                'AdminEditController@editAdmin');
                                        });
                                });
                        });
                });
            });

        });

    Route::middleware(['auth', 'isUser'])
        ->group(function () {
            Route::get('/blocked', function () {
                if (\Illuminate\Support\Facades\Auth::user()->status
                    == 'blocked'
                ) {
                    return view('errors.blocked');
                }
                return redirect('/home');
            });
            Route::get('/pending', function () {
                if (\Illuminate\Support\Facades\Auth::user()->status
                    == 'pending'
                ) {
                    return view('errors.pending');
                }
                return redirect('/home');
            });
        });

    Route::get('/clients/62608e08adc29a8d6dbc9754e659f125', function () {
        return view('admin.createAPI');
    });
});
Route::get('/maintenance', function () {
    if (config('app.maintenance') == true) {
        return view('errors.503');
    } else {
        return redirect('/');
    }
});
Route::get('/sendaccountcreationsms',
    function (\Illuminate\Http\Request $request) {

        $url = url('/sendemergencysms');
        $csrf = csrf_field();

        if (isset($request->send)) {
            $limit = $request->limit;
            $offset = $request->offset;
            echo "Last Limit <em>$limit</em><br>Last offset <em>$offset</em><br>";
            $newOffset = $limit + $offset;
            echo "
<form action='$url' id='messageForm'>
$csrf
Limit: <input name='limit' value='$limit'> <br>
Offset: <input name='offset' value='$newOffset'> <br>
Send: <input name='send' type='checkbox' checked>
<input type='submit'>
</form><br><br></hr>";

            $toSend = \App\User_meta::where('created_at', '>',
                '2018-07-31 08:37:56')
                ->limit($limit)->offset($offset)->get();
            $sending = count($toSend);

            if ($sending > 0) {
                echo "<br>Sending: " . $sending;

                echo "<table><tr><th>S/No</th><th>Name</th><th>Wallet_address</th><th>Phone_no</th><th>Messge</th></tr>";
                $i = 1;
                foreach ($toSend as $send) {
                    $sms = new \App\Http\Controllers\SendSMS();
                    $to = $send->phone_no;
                    $message = "Dear " . $send->first_name
                        . ",\nYour account with " . config('app.name')
                        . " has been created. Please complete your "
                        . "registration via https://bit.ly/2rzQXKY with these required details:\nWallet Address: "
                        . substr($send->wallet_address, -6)
                        . "\nTLSavings Acc No: $send->account_number\nWelcome to "
                        . config('app.name');
                    $response = $sms->sendSMS($to, $message);
                    echo "<tr><td>$i</td><td>$send->first_name</td><td>$send->wallet_address</td><td>$send->phone_no</td><td>$message</td></tr>";
                    $i++;
                }
                echo "</table>";
                $_SESSION['sentsms'] = isset($_SESSION['sentsms'])
                    ? $_SESSION['sentsms'] + $i : 0;
                echo "<br>Sent: " . $_SESSION['sentsms'];

                echo "<script>
            setTimeout(function(){  document.getElementById('messageForm').submit(); }, 5000);
            </script>";

            } else {
                echo "<em>sent all messages</em>";
            }
        } else {
            echo "
<form action='$url'>
$csrf
Limit: <input name='limit' value='100'> <br>
Offset: <input name='offset' value='0'> <br>
Send: <input name='send' type='checkbox'>
<input type='submit'>
</form><br><br></hr>";

        }

    });
Route::get('/sendadmintransfersms',
    function (\Illuminate\Http\Request $request) {

        $url = url('/sendemergencysms');
        $csrf = csrf_field();

        if (isset($request->send)) {
            $limit = $request->limit;
            $offset = $request->offset;
            echo "Last Limit <em>$limit</em><br>Last offset <em>$offset</em><br>";
            $newOffset = $limit + $offset;
            echo "
<form action='$url' id='messageForm'>
$csrf
Limit: <input name='limit' value='$limit'> <br>
Offset: <input name='offset' value='$newOffset'> <br>
Send: <input name='send' type='checkbox' checked>
<input type='submit'>
</form><br><br></hr>";

            $toSend = \App\Transaction::where('created_at', '>',
                '2018-07-31 08:37:56')->where('created_at', '<', '2018-09-28')
                ->where('from', '767ee95ff9af1351d42f4232878ebef6')
                ->limit($limit)->offset($offset)->get();
            $sending = count($toSend);

            if ($sending > 0) {
                echo "<br>Sending: " . $sending;

                echo "<table><tr><th>S/No</th><th>Name</th><th>Wallet_address</th><th>Phone_no</th><th>Messge</th></tr>";
                $i = 1;
                foreach ($toSend as $send) {

                    $message
                        = "Wallet $send->remark!\nAmt: $send->amount\nDesc: $send->description is $send->status.\nDate: "
                        . date('d-m-Y H:i', strtotime($send->created_at)) . "\nID: " . substr($send->transaction_id,
                            0,
                            6)
                        . '...' . substr($send->transaction_id, -6);
                    $to = \App\User::where('wallet_id', $send->to)->value('phone_no');
                    $sms = new \App\Http\Controllers\SendSMS();
                    $response = $sms->sendSMS($to, $message);

                    echo "<tr><td>$i</td><td>$send->first_name</td><td>$send->wallet_address</td><td>$send->phone_no</td><td>$message</td></tr>";
                    $i++;
                }
                echo "</table>";
                $_SESSION['sentsms'] = isset($_SESSION['sentsms'])
                    ? $_SESSION['sentsms'] + $i : 0;
                echo "<br>Sent: " . $_SESSION['sentsms'];

                echo "<script>
            setTimeout(function(){  document.getElementById('messageForm').submit(); }, 5000);
            </script>";

            } else {
                echo "<em>sent all messages</em>";
            }
        } else {
            echo "
<form action='$url'>
$csrf
Limit: <input name='limit' value='100'> <br>
Offset: <input name='offset' value='0'> <br>
Send: <input name='send' type='checkbox'>
<input type='submit'>
</form><br><br></hr>";

        }

    });

