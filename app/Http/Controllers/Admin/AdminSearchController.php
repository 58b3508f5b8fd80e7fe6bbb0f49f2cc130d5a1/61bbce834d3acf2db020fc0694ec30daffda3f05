<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use App\User_meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminSearchController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = $this->search($request);
        $data['query'] = $request->input('search');
        return view('admin.search', $data);
    }

    public function search(Request $request)
    {
        $data = null;
        $query = $request->input('search');

        $terms = preg_split('/[\s,;:]+/', $query);
        $terms = array_filter($terms);

        $data['users'] = $this->users($terms);

        $data['transactions'] = $this->transactions($terms);

        $data['value'] = Setting::where('name', 'current_pnm_value')
            ->value('value');
        return $data;
    }

    public function users($terms)
    {
        $users['registered'] = DB::table('users')->where(
            function ($query) use ($terms) {
                for ($i = 0; $i < count($terms); $i++) {
                    $query->where(DB::raw("LOWER(first_name)"),
                        'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(last_name)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(name)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(email)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(wallet_id)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(account_number)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(wallet_address)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(private_key)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"));
                }
            })->where('type', 'user')
            ->orderBy('first_name')
            ->get();
        $users['unregistered'] = DB::table('user_metas')->where(
            function ($query) use ($terms) {
                for ($i = 0; $i < count($terms); $i++) {
                    $query->where(DB::raw("LOWER(first_name)"),
                        'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(last_name)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(other_name)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(account_number)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(wallet_address)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(
                            DB::raw("LOWER(private_key)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(phone_no)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(bvn)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(id_card_type)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(id_card_no)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(bank_acc_no)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(bank_acc_name)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"));
                }
            })
            ->orderBy('updated_at')
            ->where('status', 'unregistered')
            ->get();
        return $users;
    }

    public function transactions($terms)
    {

        $userMetas = DB::table('transactions')->where(
            function ($query) use ($terms) {
                for ($i = 0; $i < count($terms); $i++) {
                    $query->orWhere(DB::raw("LOWER(transaction_id)"),
                        'like',
                        DB::raw("LOWER('%$terms[$i]%')"))
                        ->orWhere(DB::raw("LOWER(type)"),
                            'like', DB::raw("LOWER('%$terms[$i]%')"));
                }
            })
            ->orderBy('updated_at', 'desc')
            ->get();
        return $userMetas;
    }
}
