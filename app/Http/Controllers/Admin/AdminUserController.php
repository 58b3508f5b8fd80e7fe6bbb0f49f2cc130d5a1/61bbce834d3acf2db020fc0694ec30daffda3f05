<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\User_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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
                $message = 'Admin has been activated successfully.';
                break;
            case('block'):
                $admin->status = 'blocked';
                $message = 'The admin has been blocked';
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

            $data['action'] = $action;
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

    public function suspend()
    {
        $data['action'] = 'all';
        $data['users'] = User::where('type', 'user')->get();
        return view('admin.users', $data);
    }
}
