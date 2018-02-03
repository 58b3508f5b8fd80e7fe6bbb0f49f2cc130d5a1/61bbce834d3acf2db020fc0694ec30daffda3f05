<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\User_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AdminEditController extends Controller
{
    //
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

    public function editUser(Request $request)
    {
        $details = $request->all();
        $for = $request->input('for');
        $id = (int) $request->input('id') - 1427;
        $userMeta = User_meta::find($id);
        if ($request->hasFile('form_location')
            && $request->hasFile('signature_location')
            && $request->hasFile('utility_bill_location')
            && $request->hasFile('idcard_location')
            && $request->hasFile('passport_location')
        ) {
            $formImage = $request->file('form_location');
            $signatureImage = $request->file('signature_location');
            $utilityImage = $request->file('utility_bill_location');
            $idcardImage = $request->file('idcard_location');
            $passportImage = $request->file('passport_location');
            if ($formImage->isValid() && $signatureImage->isValid()
                && $utilityImage->isValid()
                && $idcardImage->isValid()
                && $passportImage->isValid()
            ) {
//                $details['form_location'] = str_replace('public',
//                    'storage', $signatureImage->store('public/images/forms'));
                $details['form_location']
                    = $signatureImage->store('tlssavings/public/images/forms');
                $details['signature_location']
                    = $signatureImage->store('tlssavings/public/images/signatures');
                $details['utility_bill_location']
                    = $utilityImage->store('tlssavings/public/images/utility_bills');
                $details['idcard_location']
                    = $idcardImage->store('tlssavings/public/images/idcards');
                $details['passport_location']
                    = $passportImage->store('tlssavings/public/images/passport');
            }
        }

        array_push($details, ['updated_at' => date('Y-m-d H:i:s')]);
        unset($details['_token']);
        unset($details['id']);
        unset($details['for']);
        unset($details[0]);

        $isUpdated = User_meta::where('id', $id)->update($details);

        $userTable = User::where('wallet_address', $userMeta['wallet_address'])
            ->update([
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'avatar'     => $request->input('passport_location'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        if ($isUpdated && $userTable) {
            $message = "New Admin was edited successfully";
        } else {
            $message = $isUpdated.'<br>'.$userTable;
        }
        $data['action'] = 'new admin';
        return $this->getUsers('user', $for, $message);


        /*  $user->first_name = $request->input('first_name');
          $user->last_name = $request->input('last_name');
          $user->other_name = $request->input('other_name');
          $user->account_number = $request->input('account_number');
          $user->wallet_address = $request->input('wallet_address');
          $user->private_key = $request->input('private_key');
          $user->dob = date_create($data['dob']);
          $user->marital_status = $request->input('marital_status');
          $user->gender = $request->input('gender');
          $user->phone_no = $request->input('phone_no');
          $user->nationality = $request->input('nationality');
          $user->state = $request->input('state');
          $user->lga = $request->input('lga');
          $user->residential_address = $request->input('residential_address');
          $user->contact_address = $request->input('contact_address');
          $user->id_card_type = $request->input('id_card_type');
          $user->id_card_no = $request->input('id_card_no');
          $user->bvn = $request->input('bvn');
          $user->bank_name = $request->input('bank_name');
          $user->bank_acc_name = $request->input('bank_acc_name');
          $user->bank_acc_no = $request->input('bank_acc_no');
          $user->occupation = $request->input('occupation');
          $user->next_of_kin = $request->input('next_of_kin');
          $user->nok_relationship = $request->input('nok_relationship');
          $user->nok_contact_address = $request->input('nok_contact_address');
          $user->nok_dob = date_create($data['nok_dob']);
          $user->nok_gender = $request->input('nok_gender');
          $user->nok_phone_no = $request->input('nok_phone_no');
          $user->nok_email = $request->input('nok_email');
          $user->spouse_name = $request->input('spouse_name');
          $user->mother_maiden_name = $request->input('mother_maiden_name');
          $user->office_phone_no = $request->input('office_phone_no');
          $user->landmark = $request->input('landmark');
          $user->form_location = $request->input('form_location');
          $user->signature_location = $request->input('signature_location');
          $user->utility_bill_location = $request->input('utility_bill_location');
          $user->idcard_location = $request->input('idcard_location');
          $user->passport_location = $request->input('passport_location');*/

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
                    ->where('access_level', ' < ', Auth::user()->access_level)
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

    public function getAdmin(Request $request)
    {
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

        $data['user'] = User::join('user_metas', 'users.wallet_address', '=',
            'user_metas.wallet_address')->where('users.id', $id - 9407)
            ->select('user_metas.*')->first();

        $html = View::make('admin.partials.editUser', $data);
        $html = $html->render();

        return response()->json([
            'status' => 'success',
            'html'   => $html
        ]);

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
