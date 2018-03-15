<?php

namespace App\Http\Controllers\API;

use App\Setting;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            if (Auth::attempt([
                'email'    => $request->get('email'),
                'password' => $request->get('password')
            ])
            ) {
                $user = Auth::user();
                $success['token'] = $user->createToken('MyApp')->accessToken;
                return response()->json(['success' => $success],
                    200);
            } else {
                return response()->json([
                    'error'    => 'Unauthorisable',
                    'email'    => $request->get('email'),
                    'password' => $request->get('password')
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function charge()
    {
        try {
            $user = Transaction::all();
            return response()->json(['success' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function confirm(){
        return response()->json([
            'user'=>Auth::user(),
            'amount'=>Setting::where('name', 'registration_charge')
            ->value('value')
        ], 200);
    }

    public function getCurrentValue()
    {
        $value = Setting::where('name', 'current_pnm_value')->value('value');
        return $value;
    }


}
