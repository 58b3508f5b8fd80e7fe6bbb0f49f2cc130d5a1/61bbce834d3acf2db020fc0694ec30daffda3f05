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

    public function viewActiveUsers(Request $request)
    {
        $page = $request->page ?: 1;
        $count = 800 * $page;
        $data['action'] = 'active';
        $data['type'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'active')
            ->orderBy('created_at', 'desc')->paginate(800);
        return view('admin.users', $data);
    }

    public function viewAdmins(Request $request)
    {
        $data['action'] = 'admin';
        $data['type'] = 'admin';
        $data['users'] = User::where('type', 'admin')
            ->where('access_level', '<', Auth::user()->access_level)
            ->orderBy('created_at', 'desc')->paginate(800);
        return view('admin.users', $data);
    }

    public function viewAllUsers(Request $request)
    {
        $data['action'] = 'all';
        $data['type'] = 'user';
        $data['users'] = User::where('type', 'user')
            ->orderBy('created_at', 'desc')->paginate(800);
        return view('admin.users', $data);
    }

    public function viewBlockedUsers(Request $request)
    {
        $data['action'] = 'blocked';
        $data['type'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'blocked')
            ->orderBy('created_at', 'desc')->paginate(800);
        return view('admin.users', $data);
    }

    public function viewRegisteredUsers(Request $request)
    {
        $data['action'] = 'registered';
        $data['type'] = 'user';
        $data['users'] = User_meta::where('status', 'registered')
            ->orderBy('created_at', 'desc')->paginate(800);
        return view('admin.users', $data);
    }

    public function viewUnregisteredUsers(Request $request)
    {
        $data['action'] = 'unregistered';
        $data['type'] = 'user';
        $data['users'] = User_meta::where('status', 'unregistered')
            ->orWhere('status', 'pending')->orderBy('created_at', 'desc')
            ->paginate(800);
        return view('admin.users', $data);
    }

    public function viewSuspendedUsers(Request $request)
    {
        $data['action'] = 'suspended';
        $data['type'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'pending')
            ->orderBy('created_at', 'desc')->paginate(800);
        return view('admin.users', $data);
    }

    public function suspend(Request $request)
    {
        $data['action'] = 'all';
        $data['users'] = User::where('type', 'user')->get();
        return view('admin.users', $data);
    }
}
