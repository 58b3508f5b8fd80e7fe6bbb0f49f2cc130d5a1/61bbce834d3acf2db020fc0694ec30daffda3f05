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
    return view('welcome');
});
Route::get('/apilogin', function(){
    return view('authenticate');
});

Route::post('/login/get/tlpay/verify', function(Request $request){
    $data['amount']= $request->amount;
    $data['key']= $request->key;
    $html = View::make('authenticate', $data);
    $html = $html->render();

    return response()->json([
        'html'    => $html
    ]);
});

Auth::routes();

Route::get('/error/{id}', function ($id){
   return view("errors.$id"); 
});
Route::get('/home', 'HomeController@index')->name('home');
