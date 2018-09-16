<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\User_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class AdminUserController extends Controller
{
    //

    public function verifyUser(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('action');
        $for = $request->input('for');
        $admin = User::find($id - 1107);
        $message = '';

        switch ($action) {
            case('approve'):
                $admin->status = 'active';
                $message = 'User has been activated successfully.';
                break;
            case('block'):
                $admin->status = 'blocked';
                $message = 'The user has been blocked';
                break;
        }

        if ($admin->save()) {

            $data['type'] = 'user';
            switch ($for) {
                case 'active':
                    $data['users'] = User::where('type', 'user')
                        ->where('status', 'active')
                        ->get();
                    break;
                case 'admin':
                    $data['type'] = 'admin';
                    $data['users'] = User::where('type', 'admin')
                        ->where('access_level', '<', Auth::user()->access_level)
                        ->get();
                    break;
                case 'all':
                    $data['users'] = User::where('type', 'user')
                        ->orderBy('status')
                        ->orderBy('first_name')->get();
                    break;
                case 'blocked':
                    $data['users'] = User::where('type', 'user')
                        ->where('status', 'blocked')
                        ->get();
                    break;
                case 'registered':
                    $data['users'] = User_meta::where('status', 'registered')
                        ->get();
                    break;
                case 'unregistered':
                    $data['users'] = User_meta::where('status', 'unregistered')
                        ->orWhere('status', 'pending')->get();
                    break;
                case 'suspended':
                    $data['users'] = User::where('type', 'user')
                        ->where('status', 'pending')
                        ->get();
                    break;
                default:
                    $data['users'] = User::where('type', 'user')
                        ->orderBy('status')
                        ->orderBy('first_name')->get();
                    break;
            }

            $data['action'] = $for;
            $html = View::make('admin.partials.user', $data);
            $html = $html->render();

            return response()->json([
                'status'  => 'success',
                'message' => $message,
                'html'    => $html
            ]);
        }


        return response()->json([
            'status'  => 'failed',
            'message' => 'Sorry, an error occurred.'
        ]);
    }

    public function viewActiveUsers()
    {
        $data['action'] = 'active';
        $data['type'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'active')
            ->get();
        return view('admin.users', $data);
    }

    public function viewAdmins()
    {
        $data['action'] = 'admin';
        $data['type'] = 'admin';
        $data['users'] = User::where('type', 'admin')
            ->where('access_level', '<', Auth::user()->access_level)->get();
        return view('admin.users', $data);
    }

    public function viewAllUsers()
    {
        $data['action'] = 'all';
        $data['type'] = 'user';
        $data['users'] = User::where('type', 'user')->orderBy('status')
            ->orderBy('first_name')->get();
        return view('admin.users', $data);
    }

    public function viewBlockedUsers()
    {
        $data['action'] = 'blocked';
        $data['type'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'blocked')
            ->get();
        return view('admin.users', $data);
    }

    public function viewRegisteredUsers()
    {
        $data['action'] = 'registered';
        $data['type'] = 'user';
        $data['users'] = User_meta::where('status', 'registered')->get();
        return view('admin.users', $data);
    }

    public function viewUnregisteredUsers()
    {
        $data['action'] = 'unregistered';
        $data['type'] = 'user';
        $data['users'] = User_meta::where('status', 'unregistered')
            ->orWhere('status', 'pending')->get();
        return view('admin.users', $data);
    }

    public function viewSuspendedUsers()
    {
        $data['action'] = 'suspended';
        $data['type'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'pending')
            ->get();
        return view('admin.users', $data);
    }

    public function dataTableActiveUsers(DataTables $dataTables)
    {
        $users = User::query()->where('type', 'user')->where('status', 'active')
            ->orderBy('status')
            ->orderBy('full_name')
            ->select(DB::raw('id+1107 as uid'),
                DB::raw("concat(first_name,' ',last_name) as full_name"),'wallet_id as wallet',
                'name', 'wallet_id', 'account_number', 'status');
        return $dataTables->eloquent($users)
            ->editColumn('wallet_id', function (User $user) {
                return $this->trimLongID($user->wallet_id);
            })->toJson();
    }

    public function dataTableAllUsers(DataTables $dataTables)
    {
        $users = User::query()->where('type', 'user')->orderBy('status')
            ->orderBy('full_name')
            ->select(DB::raw('id+1107 as uid'),
                DB::raw("concat(first_name,' ',last_name) as full_name"),'wallet_id as wallet',
                'name', 'wallet_id', 'account_number', 'status');
        return $dataTables->eloquent($users)
            ->editColumn('wallet_id', function (User $user) {
                return $this->trimLongID($user->wallet_id);
            })->toJson();
    }

    public function dataTableBlockedUsers(DataTables $dataTables)
    {
        $users = User::query()->where('type', 'user')
            ->where('status', 'blocked')
            ->orderBy('status')
            ->orderBy('full_name')
            ->select(DB::raw('id+1107 as uid'),
                DB::raw("concat(first_name,' ',last_name) as full_name"),'wallet_id as wallet',
                'name', 'wallet_id', 'account_number', 'status');
        return $dataTables->eloquent($users)
            ->editColumn('wallet_id', function (User $user) {
                return $this->trimLongID($user->wallet_id);
            })->toJson();
    }

    public function dataTableRegisteredUsers(DataTables $dataTables)
    {
        $users = User_meta::query()->where('status', 'registered')
            ->orderBy('status')
            ->orderBy('full_name')
            ->select(DB::raw('id+1107 as uid'),
                DB::raw("concat(first_name,' ',last_name) as full_name"),'private_key as wallet',
                'wallet_address as name', 'private_key as wallet_id',
                'account_number', 'status');
        return $dataTables->eloquent($users)
            ->editColumn('name', function (User_meta $user) {
                return $this->trimLongID($user->name);
            })->editColumn('wallet_id', function (User_meta $user) {
                return $this->trimLongID($user->wallet_id);
            })->toJson();
    }

    public function dataTableUnregisteredUsers(DataTables $dataTables)
    {
        $users = User_meta::where('status', 'unregistered')
            ->orWhere('status', 'pending')->orderBy('status')
            ->orderBy('full_name')
            ->select(DB::raw('id+1107 as uid'),
                DB::raw("concat(first_name,' ',last_name) as full_name"),'private_key as wallet',
                'wallet_address as name', 'private_key as wallet_id',
                'account_number', 'status');
        return $dataTables->eloquent($users)
            ->editColumn('name', function (User_meta $user) {
                return $this->trimLongID($user->name);
            })->editColumn('wallet_id', function (User_meta $user) {
                return $this->trimLongID($user->wallet_id);
            })->toJson();
    }

    public function dataTableSuspendedUsers(DataTables $dataTables)
    {
        $users = User::query()->where('type', 'user')
            ->where('status', 'pending')
            ->orderBy('status')
            ->orderBy('full_name')
            ->select(DB::raw('id+1107 as uid'),
                DB::raw("concat(first_name,' ',last_name) as full_name"),'wallet_id as wallet',
                'name', 'wallet_id', 'account_number', 'status');
        return $dataTables->eloquent($users)
            ->editColumn('wallet_id', function (User $user) {
                return $this->trimLongID($user->wallet_id);
            })->toJson();
    }

    public function suspend()
    {
        $data['action'] = 'all';
        $data['users'] = User::where('type', 'user')->get();
        return view('admin.users', $data);
    }

    public function trimLongID($string)
    {
        if (strlen($string) > 15) {
            $trim1 = substr($string, 0, 6);
            $trim2 = substr($string, -6);
            return "$trim1......$trim2";
        }
        return $string;
    }
}
