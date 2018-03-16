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
        Route::get('/transactions', 'TransactionController@viewTransactions');
        Route::get('/settings', 'SettingsController@index');
        Route::get('/statistics', 'HomeController@statistics');
        Route::get('/settings', 'SettingsController@index');
        Route::get('/settings/{action}', 'SettingsController@index');
        // drg >> "post" routes arranged alphabetically
        Route::post('/transaction/{for}/{action}',
            'TransactionController@process');
        Route::post('/settings/password', 'SettingsController@changePassword');
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
                        Route::get('/transactions/verified/{action}',
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

                        // drg >> settings functions
                        Route::get('settings', 'AdminSettingsController@index');


                        // drg >> search
                        Route::get('/search','AdminSearchController@index');
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

                                Route::get('/transactions/withdrawal/{action}',
                                    'AdminTransactionsController@viewWithdrawal');
                                Route::get('/transactions/share',
                                    'AdminTransactionsController@viewShare');
                                Route::get('/transactions/history',
                                    'AdminTransactionsController@viewTransactions');
                                // drg >> handling transaction functions
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
            if (\Illuminate\Support\Facades\Auth::user()->status == 'blocked') {
                return view('errors.blocked');
            }
            return redirect('/home');
        });
        Route::get('/pending', function () {
            if (\Illuminate\Support\Facades\Auth::user()->status == 'pending') {
                return view('errors.pending');
            }
            return redirect('/home');
        });
    });

Route::get('/clients/62608e08adc29a8d6dbc9754e659f125', function(){
    return view('admin.createAPI');
});