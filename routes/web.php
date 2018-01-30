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

Route::get('/', function () {
    return view('site.index-2');
});

Route::get('/about-us', function () {
    return view('site.about-us');
});
Route::get('/account-opening', function () {
    return view('site.account-opening');
});
Route::get('/contacts', function () {
    return view('site.contacts');
});
Route::get('/flags', function () {
    return view('site.flags_matrix');
});
Route::get('/hlight-bg', function () {
    return view('site.hlight_bg');
});
Route::get('/icon-logo', function () {
    return view('site.icon-logo');
});
Route::get('/index-2', function () {
    return view('site.index-2');
});
Route::get('/index-3', function () {
    return view('site.index-3');
});
Route::get('/index-4', function () {
    return view('site.index-4');
});
Route::get('/index-5', function () {
    return view('site.index-5');
});
Route::get('/index-6', function () {
    return view('site.index-6');
});
Route::get('/index-7', function () {
    return view('site.index-7');
});
Route::get('/null', function () {
    return view('site.null');
});
Route::get('/numa', function () {
    return view('site.numa');
});
Route::get('/savings', function () {
    return view('site.savings');
});

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
                Route::get('', 'AdminController@index');
                Route::get('/dashboard', 'AdminController@index');

                // drg >> add functions
                Route::get('/add/user', 'AdminAddController@viewAddUser');
                Route::get('/add/admin', 'AdminAddController@viewAddAdmin');
                Route::get('/add/pnm', 'AdminAddController@viewAddPnm');

                // drg >> settings functions
                Route::get('settings', 'AdminSettingsController@index');

                // drg >> transaction functions
                Route::get('/transactions/share',
                    'AdminTransactionsController@viewShare');
                Route::get('/transactions/withdrawal/{action}',
                    'AdminTransactionsController@viewWithdrawal');
                Route::get('/transactions/verified/{action}',
                    'AdminTransactionsController@viewVerified');

                // drg >> users functions
                Route::get('users/active',
                    'AdminUserController@viewActiveUsers');
                Route::get('users/admin', 'AdminUserController@viewAdmins');
                Route::get('users/all', 'AdminUserController@viewAllUsers');
                Route::get('users/blocked',
                    'AdminUserController@viewBlockedUsers');
                Route::get('users/registered',
                    'AdminUserController@viewRegisteredUsers');
                Route::get('users/unregistered',
                    'AdminUserController@viewUnregisteredUsers');
                Route::get('users/suspended',
                    'AdminUserController@viewSuspendedUsers');

                // drg >> handling add functions
                Route::post('/add/user', 'AdminAddController@addUser');
                Route::post('/add/admin', 'AdminAddController@addAdmin');
                Route::post('/add/pnm', 'AdminAddController@addPNM');
                Route::post('/users/verify', 'AdminUserController@verifyUser');

                // drg >> handling transaction functions
                Route::post('/transactions/share',
                    'AdminTransactionsController@sharePNM');
                Route::post('/transactions/withdrawal',
                    'AdminTransactionsController@verifyWithdrawal');

                // drg >> search
                Route::post('/search');

                // drg >> handling settings functions
                Route::post('/settings/app',
                    'AdminSettingsController@updateSettings');
                Route::post('/settings/password',
                    'AdminSettingsController@changePassword');
                Route::post('/settings/pin',
                    'AdminSettingsController@changePin');

            });

        });

    });

Route::middleware(['auth', 'isUser'])
    ->group(function () {
        Route::get('/blocked', function () {
            if (\Illuminate\Support\Facades\Auth::user()->status =='blocked') {
                return view('errors.blocked');
            }
            return redirect('/home');
        });
        Route::get('/pending', function () {
            if (\Illuminate\Support\Facades\Auth::user()->status =='pending') {
                return view('errors.pending');
            }
            return redirect('/home');
        });
    });