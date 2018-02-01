<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
use App\User;
use App\User_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAddController extends Controller
{
    //
    public function __construct(AdminController $details)
    {
        $this->details = $details;
    }

    protected function validateUser(array $data)
    {
        return Validator::make($data, [
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'string|max:255',
            'other_name'            => 'max:255',
            'account_number'        => 'required|string|unique:user_metas|max:10',
            'wallet_address'        => 'required|string|unique:user_metas|max:255',
            'private_key'           => 'required|string|unique:user_metas|max:255',
            'dob'                   => 'required|date|max:255',
            'marital_status'        => 'required|string|max:255',
            'gender'                => 'required|string|max:255',
            'phone_no'              => 'required|string|unique:user_metas|max:255',
            'nationality'           => 'required|string|max:255',
            'state'                 => 'required|string|max:255',
            'lga'                   => 'required|string|max:255',
            'residential_address'   => 'required|string|max:255',
            'contact_address'       => 'required|string|max:255',
            'id_card_type'          => 'required|string|max:255',
            'id_card_no'            => 'required|unique:user_metas|max:255',
            'bvn'                   => 'required|numeric|unique:user_metas',
            'bank_name'             => 'string|max:255',
            'bank_acc_name'         => 'string|max:255',
            'bank_acc_no'           => 'numeric|unique:user_metas',
            'occupation'            => 'required|string|max:255',
            'next_of_kin'           => 'required|string|max:255',
            'nok_relationship'      => 'required|string|max:255',
            'nok_contact_address'   => 'required|string|max:255',
            'nok_dob'               => 'required|date|max:255',
            'nok_gender'            => 'required|string|max:255',
            'nok_phone_no'          => 'required|string|max:255',
            'nok_email'             => 'required|string|max:255',
            'spouse_name'           => 'required|string|max:255',
            'mother_maiden_name'    => 'required|string|max:255',
            'office_phone_no'       => 'required|string|max:255',
            'landmark'              => 'required|string|max:255',
            'form_location'         => 'required|image',
            'signature_location'    => 'required|image',
            'utility_bill_location' => 'required|image',
            'idcard_location'       => 'required|image',
            'passport_location'     => 'required|image',
        ]);
    }

    public function validateAdmin(array $data)
    {
        return Validator::make($data, [
            'name'  => 'required|string|unique:users|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }

    public function addPNM(Request $request)
    {
        $value = $this->details->getCurrentValue();
        $pnm = $request->input('amount');
        $pin = $request->input('pin');

        $data['action'] = 'new PNM';
        $checkPin = Hash::check($pin, Auth::user()->pin);
        if ($checkPin) {
            $ngn = $pnm * (int)$value;
            $description = "Admin added $pnm PNM worth $ngn NGN";
            $type = "admin-holding";
            $transaction = new Transaction();
            $transactionID = md5(Auth::user()->wallet_id . $pnm . $ngn
                . date('YFlHisuA'));
            $transaction->transaction_id = $transactionID;
            $transaction->from = Auth::user()->name;
            $transaction->to = Auth::user()->wallet_id;
            $transaction->amount = $pnm;
            $transaction->value = $value;
            $transaction->description = $description;
            $transaction->type = $type;
            $transaction->status = 'successful';
            $transaction->remark = 'credit';
            $transaction->save();
            if ($transaction->save()) {
                $data['alert'] = 'success';
                $data['message'] = "Your transaction was successful";
            }
        } elseif (!$checkPin) {
            $data['alert'] = 'danger';
            $data['message'] = "Sorry, the pin you entered was incorrect";
        }

        return view('admin.newPNM', $data);
    }

    public function addAdmin(Request $request)
    {
        $details = $request->all();
        $this->validateAdmin($details)->validate();
        $isAcc = true;
        $acc_no = '';
        while ($isAcc) {
            $acc_no = rand(1, 100000);
            $isAcc = User::where('account_number', $acc_no)->first();
        }
        $admin = User::create([
            'first_name'     => $details['first_name'],
            'last_name'      => $details['last_name'],
            'wallet_id'      => md5($details['email'] . date('YmdHis')),
            'name'           => $details['name'],
            'email'          => $details['email'],
            'password'       => bcrypt(md5($details['email'])),
            'pin'            => bcrypt('1234'),
            'account_number' => $acc_no,
            'wallet_address' => md5($details['email']),
            'private_key'    => md5($details['email']),
            'type'           => 'admin',
            'status'         => 'active',
            'access_level'   => $details['level'],
        ]);

        if ($admin) {
            $data['alert'] = 'success';
            $data['message'] = "New Admin was created successfully";

        } else {
            $data['alert'] = 'danger';
            $data['message'] = "There was an error in creating the admin";

        }
        $data['action'] = 'new admin';
        return view('admin.newAdmin', $data);
    }

    public function addUser(Request $request)
    {
        $details = $request->all();
        $this->validateUser($details)->validate();

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
                $details['form_location'] = str_replace('public',
                    'storage', $signatureImage->store('public/images/forms'));
                $details['signature_location'] = str_replace('public',
                    'storage',
                    $signatureImage->store('public/images/signatures'));
                $details['utility_bill_location'] = str_replace('public',
                    'storage',
                    $utilityImage->store('public/images/utility_bills'));
                $details['idcard_location'] = str_replace('public', 'storage',
                    $idcardImage->store('public/images/idcards'));
                $details['passport_location'] = str_replace('public', 'storage',
                    $passportImage->store('public/images/passport'));
            }
        }

        $user = $this->createUsers($details);
        if ($user) {
            $data['alert'] = 'success';
            $data['message'] = "User was created successfully";

        } else {
            $data['alert'] = 'danger';
            $data['message'] = "There was an error in creating the user";

        }
        $data['action'] = 'new user';
        return view('admin.newUser', $data);
    }

    protected function createUsers(array $data)
    {
        return User_meta::create([
            'first_name'            => $data['first_name'],
            'last_name'             => $data['last_name'],
            'other_name'            => $data['other_name'],
            'account_number'        => $data['account_number'],
            'wallet_address'        => $data['wallet_address'],
            'private_key'           => $data['private_key'],
            'dob'                   => date_create($data['dob']),
            'marital_status'        => $data['marital_status'],
            'gender'                => $data['gender'],
            'phone_no'              => $data['phone_no'],
            'nationality'           => $data['nationality'],
            'state'                 => $data['state'],
            'lga'                   => $data['lga'],
            'residential_address'   => $data['residential_address'],
            'contact_address'       => $data['contact_address'],
            'id_card_type'          => $data['id_card_type'],
            'id_card_no'            => $data['id_card_no'],
            'bvn'                   => $data['bvn'],
            'bank_name'             => $data['bank_name'],
            'bank_acc_name'         => $data['bank_acc_name'],
            'bank_acc_no'           => $data['bank_acc_no'],
            'occupation'            => $data['occupation'],
            'next_of_kin'           => $data['next_of_kin'],
            'nok_relationship'      => $data['nok_relationship'],
            'nok_contact_address'   => $data['nok_contact_address'],
            'nok_dob'               => date_create($data['nok_dob']),
            'nok_gender'            => $data['nok_gender'],
            'nok_phone_no'          => $data['nok_phone_no'],
            'nok_email'             => $data['nok_email'],
            'spouse_name'           => $data['spouse_name'],
            'mother_maiden_name'    => $data['mother_maiden_name'],
            'office_phone_no'       => $data['office_phone_no'],
            'landmark'              => $data['landmark'],
            'form_location'         => $data['form_location'],
            'signature_location'    => $data['signature_location'],
            'utility_bill_location' => $data['utility_bill_location'],
            'idcard_location'       => $data['idcard_location'],
            'passport_location'     => $data['passport_location'],
            'status'                => 'unregistered'
        ]);
    }

    public function uploadFiles(Request $request)
    {
        $details = array();

        return $details;
    }

    public function viewAddUser($data = array())
    {
        $data['action'] = 'new user';
        return view('admin.newUser', $data);
    }

    public function viewAddAdmin()
    {
        $data['action'] = 'new admin';
        return view('admin.newAdmin', $data);
    }

    public function viewAddPnm()
    {
        $data['action'] = 'new PNM';
        return view('admin.newPNM', $data);
    }

}
