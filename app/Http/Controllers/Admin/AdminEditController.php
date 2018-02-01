<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AdminEditController extends Controller
{
    //
    public function getAdmin(Request $request)
    {
        $id = $request->input('id');

        $data['user'] = User::find($id - 9407);

        $html = View::make('admin.partials.editAdmin', $data);
        $html = $html->render();

        return response()->json([
            'status' => 'success',
            'html'   => $html
        ]);

    }

    public function editAdmin(Request $request)
    {
        $details = $request->all();
        $for = $request->input('for');
        $id = $request->input('id');
        $admin = User::find($id - 1427);

        $admin->first_name = $request->input('first_name');
        $admin->last_name = $request->input('last_name');
        $admin->email = $request->input('email');
        $admin->access_level = $request->input('access_level');

        if ($admin->save()) {
            $message = "New Admin was edited successfully";
        } else {
            $message = "There was an error in editing the admin";
        }
        $data['action'] = 'new admin';
        return $this->getUsers('admin', $for, $message);
    }

    public function getUsers($type, $for, $message)
    {
        switch ($for) {
            case 'active':
                $data['users'] = User::where('type', 'user')
                    ->where('status', 'active')
                    ->get();
                break;
            case 'admin':
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
        $data['type'] = $type;
        $html = View::make('admin.partials.user', $data);
        $html = $html->render();

        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'html'    => $html
        ]);
    }

    public function validateAdmin(array $data)
    {
        return Validator::make($data, [
            'name'  => 'required|string|unique:users|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }
}
