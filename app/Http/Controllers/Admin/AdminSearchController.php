<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User_meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSearchController extends Controller
{
    //
    public function index(Request $request)
    {
        $data['results'] = $this->search($request);
        $data['query'] = $request->input('search');
        return view('admin.searchUsers', $data);
    }

    public function search(Request $request)
    {
        $data = null;
        $query = $request->input('search');
        $type = $request->input('type', 'users');
        $terms = preg_split('/[\s,;:]+/', $query);
        $terms = array_filter($terms);
        switch ($type) {
            case('users'):
                $data = $this->users($terms);
                break;
            case('transactions'):
                $data = $this->transactions($terms);
                break;
        }
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
            ->orderBy('first_name')
            ->where('status', 'unregistered')
            ->get();
        return $users;
    }

    public function transactions($terms)
    {
        $userMetas = DB::table('users')->where(
            function ($query) use ($terms) {
                for ($i = 0; $i < count($terms); $i++) {

                    $query->where('student_reg_no', 'like',
                        "%$terms[$i]%")
                        ->orWhere(DB::raw("LOWER(first_name)"),
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
            })
            ->orderBy('first_name')
            ->get();
        return $userMetas;
    }
}
