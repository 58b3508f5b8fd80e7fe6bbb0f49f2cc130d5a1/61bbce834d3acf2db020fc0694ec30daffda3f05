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
    public function charge()
    {
        try {
            $user = Transaction::all();
            return response()->json(['success' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function confirm()
    {
        return response()->json([
            'user'   => Auth::user(),
            'amount' => Setting::where('name', 'registration_charge')
                ->value('value'),
            'pnm'    => Setting::where('name',
                'current_pnm_value')
                ->value('value'),
        ], 200);
    }

    public function getCurrentValue()
    {
        $value = Setting::where('name', 'current_pnm_value')->value('value');
        return $value;
    }
}
