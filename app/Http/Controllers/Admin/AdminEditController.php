<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SendSMS;
use App\User;
use App\User_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AdminEditController extends Controller
{
    //
    public function editAdmin(Request $request)
    {
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

    public function editUser(Request $request)
    {
        $details = $request->all();
        $for = null;
        $id = (int)$request->input('id') - 1427;
        $userMeta = User_meta::find($id);
        $passport = $userMeta->passport_location;
        $grade = $userMeta->grade;
        // drg >> to change user type, for only super admin
        if (Auth::user()->access_level >= 4) {
            $userMeta->grade = $details['grade'];
            $grade = $details['grade'];
        }
        if ($request->hasFile('form_location')
            && $request->file('form_location')->isValid()
        ) {
            Storage::delete($userMeta->form_location);
            $userMeta->form_location = $request->file('form_location')
                ->store('tlssavings/app/images/forms');
        }
        if ($request->hasFile('signature_location')
            && $request->file('signature_location')->isValid()
        ) {
            Storage::delete($userMeta->signature_location);
            $userMeta->signature_location = $request->file('signature_location')
                ->store('tlssavings/app/images/signatures');
        }
        if ($request->hasFile('utility_bill_location')
            && $request->file('utility_bill_location')->isValid()
        ) {
            Storage::delete($userMeta->utility_bill_location);
            $userMeta->utility_bill_location
                = $request->file('utility_bill_location')
                ->store('tlssavings/app/images/utility_bills');
        }
        if ($request->hasFile('idcard_location')
            && $request->file('idcard_location')->isValid()
        ) {
            Storage::delete($userMeta->idcard_location);
            $userMeta->idcard_location = $request->file('idcard_location')
                ->store('tlssavings/app/images/idcards');
        }
        if ($request->hasFile('passport_location')
            && $request->file('passport_location')->isValid()
        ) {
            Storage::delete($userMeta->passport_location);
            $passport = $request->file('passport_location')
                ->store('tlssavings/app/images/passport');
            $userMeta->passport_location = $passport;
        }
        array_push($details, ['updated_at' => date('Y-m-d H:i:s')]);
        unset($details['signature_location']);
        unset($details['form_location']);
        unset($details['utility_bill_location']);
        unset($details['idcard_location']);
        unset($details['passport_location']);
        unset($details['_token']);
        unset($details['id']);
        unset($details['grade']);
        unset($details['for']);
        unset($details[0]);
        $isUpdated = User_meta::where('id', $id)->update($details);
        $userTable = User::where('wallet_address',
            $userMeta['wallet_address'])
            ->update([
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'phone_no'   => $request->input('phone_no'),
                'avatar'     => $passport,
                'grade'      => $grade,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        if ($isUpdated && $userTable && $userMeta->save()) {
            $message = "User was edited successfully";
        } else {
            $message = $isUpdated . ' < br>' . $userTable;
        }
        $data['action'] = 'new user';
        return $this->getUsers('user', $for, $message);
    }

    public function getUsers($type, $for, $message)
    {
        switch ($for) {
            case 'active':
                $users = User::where('type', 'user')
                    ->where('status', 'active')
                    ->orderBy('created_at', 'desc')->paginate(800);
                $users->withPath("/admin/users/active");
                break;
            case 'admin':
                $users = User::where('type', 'admin')
                    ->where('access_level', ' < ',
                        Auth::user()->access_level)
                    ->orderBy('created_at', 'desc')->paginate(800);
                $users->withPath("/admin/users/admin");
                break;
            case 'all':
                $users = User::where('type', 'user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(800);
                $users->withPath("/admin/users/all");

                break;
            case 'blocked':
                $users = User::where('type', 'user')
                    ->where('status', 'blocked')
                    ->orderBy('created_at', 'desc')->paginate(800);
                $users->withPath("/admin/users/blocked");
                break;
            case 'registered':
                $users = User_meta::where('status', 'registered')
                    ->orderBy('created_at', 'desc')->paginate(800);
                $users->withPath("/admin/users/registered");
                break;
            case 'unregistered':
                $users = User_meta::where('status', 'unregistered')
                    ->orWhere('status', 'pending')
                    ->orderBy('created_at', 'desc')->paginate(800);
                $users->withPath("/admin/users/unregistered");
                break;
            case 'suspended':
                $users = User::where('type', 'user')
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'desc')->paginate(800);
                $users->withPath("/admin/users/suspended");
                break;
            default:
                $users = User::where('type', 'user')
                    ->orderBy('status')
                    ->orderBy('created_at', 'desc')
                    ->paginate(800);
                $users->withPath("/admin/users/all");
                break;
        }
        $data['users'] = $users;
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

    public function getAdmin(
        Request $request
    ) {
        $id = $request->input('id');
        $data['admin'] = User::find($id - 9407);
        $html = View::make('admin.partials.editAdmin', $data);
        $html = $html->render();
        return response()->json([
            'status' => 'success',
            'html'   => $html
        ]);
    }

    public function getUser(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('action');
        $data = null;
        if (!in_array($action, ['registered', 'unregistered'])) {
            $data['user'] = User::join('user_metas', 'users.wallet_address',
                '=', 'user_metas.wallet_address')->where('users.id', $id - 9407)
                ->select('user_metas.*')->first();
        } else {
            $data['user'] = User_meta::where('id', $id - 9407)->first();
        }
        $html = View::make('admin.partials.editUser', $data);
        $html = $html->render();
        return response()->json([
            'status' => 'success',
            'html'   => $html
        ]);
    }

    public function linkAccount(Request $request)
    {
        $id = (int)$request->input('id') - 1427;
        $userMeta = User_meta::find($id);
        $userMeta->bvn = $request->bvn;
        $userMeta->bank_name = $request->bank_name;
        $userMeta->bank_acc_name = $request->acc_name;
        $userMeta->bank_acc_no = $request->acc_no;
        if ($userMeta->save()) {
            $sms = new SendSMS();
            $to = $userMeta->phone_no;
            $message = "Hello " . $userMeta->first_name
                . ",\nYour account with " . config('app.name')
                . " has been linked to the bank successfully.\nBank Name: $userMeta->bank_name,\nAcc. Name: $userMeta->bank_acc_name,\nAcc. No: $userMeta->bank_acc_no.\nPlease contact us for more enquiries.\n"
                . config('app.name') . ".";
            $resp = $sms->sendSMS($to, $message);
            return response()->json([
                'message' => 'Account has been linked successfully'
            ]);
        }
    }

    public function validateAdmin(array $data)
    {
        return Validator::make($data, [
            'name'  => 'required | string | unique:users | max:255',
            'email' => 'required | string | email | max:255 | unique:users',
        ]);
    }

    public function validateUser(array $data)
    {
        return Validator::make($data, [
            'name'  => 'required | string | unique:users | max:255',
            'email' => 'required | string | email | max:255 | unique:users',
        ]);
    }
}
