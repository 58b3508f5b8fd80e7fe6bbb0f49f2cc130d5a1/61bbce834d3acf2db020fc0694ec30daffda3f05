<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\User_meta;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'pin'      => 'required|numeric|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User_meta::where('id', $data['find'] - 1147)
            ->where('account_number', $data['acc_number'])
            ->where('wallet_address', $data['wallet'])->firstOrFail();

        return User::create([
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'wallet_id'  => md5($user->wallet_address . $data['email']),
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password']),
            'pin'        => bcrypt($data['pin']),
            'account_number'=>$user->account_number,
            'wallet_address'=>$user->wallet_address,
            'private_key'=>$user->private_key,
        ]);
    }

    public function join(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account' => 'required|max:10|min:10',
            'wallet'  => 'required|alpha-num|max:6|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $errors = array();
        $failed = false;
        $accountNumber = $request->input('account');
        $wallet = $request->input('wallet');
        $accountExists = User_meta::where('account_number', $accountNumber)
            ->first();
        $accountPending = User_meta::where('account_number', $accountNumber)
            ->where('status', 'pending')->first();
        $checkAccount = User_meta::where('account_number', $accountNumber)
            ->where('wallet_address', 'like', "%$wallet%")
            ->first();

        if (!$accountExists) {
            $errors = array_add($errors, 'account',
                'This account does not exist');
            $failed = true;
        } elseif (!$accountPending) {
            $errors = array_add($errors, 'account',
                'This account cannot be registered again');
            $failed = true;
        } elseif (!$checkAccount) {
            $errors = array_add($errors, 'wallet',
                'The characters entered do not match our record');
            $failed = true;
        }
        if ($failed) {
            return redirect()->back()
                ->withInput()
                ->withErrors($errors);
        }
        $request->session()->flash('user', $checkAccount);
        return view('auth.register');
    }

    public function showJoinForm()
    {
        return view('auth.join');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->session()->reflash();

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
