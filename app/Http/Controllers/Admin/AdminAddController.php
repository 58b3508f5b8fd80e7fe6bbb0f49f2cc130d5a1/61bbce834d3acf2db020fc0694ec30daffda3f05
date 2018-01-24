<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
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
            'first_name'            => 'required|string|unique:users|max:255',
            'last_name'             => 'required|string|unique:users|max:255',
            'other_name'            => 'required|string|unique:users|max:255',
            'account_number'        => 'required|string|unique:users|max:255',
            'wallet_address'        => 'required|string|unique:users|max:255',
            'private_key'           => 'required|string|unique:users|max:255',
            'dob'                   => 'required|string|unique:users|max:255',
            'marital_status'        => 'required|string|unique:users|max:255',
            'mega-gender-group'     => 'required|string|unique:users|max:255',
            'phone_no'              => 'required|string|unique:users|max:255',
            'nationality'           => 'required|string|unique:users|max:255',
            'state'                 => 'required|string|unique:users|max:255',
            'lga'                   => 'required|string|unique:users|max:255',
            'residential_address'   => 'required|string|unique:users|max:255',
            'contact_address'       => 'required|string|unique:users|max:255',
            'id_card_type'          => 'required|string|unique:users|max:255',
            'id_card_no'            => 'required|string|unique:users|max:255',
            'bvn'                   => 'required|string|unique:users|max:255',
            'occupation'            => 'required|string|unique:users|max:255',
            'next_of_kin'           => 'required|string|unique:users|max:255',
            'nok_relationship'      => 'required|string|unique:users|max:255',
            'nok_contact_address'   => 'required|string|unique:users|max:255',
            'nok_dob'               => 'required|string|unique:users|max:255',
            'nok_gender'            => 'required|string|unique:users|max:255',
            'nok_phone_no'          => 'required|string|unique:users|max:255',
            'nok_email'             => 'required|string|unique:users|max:255',
            'spouse_name'           => 'required|string|unique:users|max:255',
            'mother_maiden_name'    => 'required|string|unique:users|max:255',
            'office_phone_no'       => 'required|string|unique:users|max:255',
            'landmark'              => 'required|string|unique:users|max:255',
            'form_location'         => 'required|string|unique:users|max:255',
            'signature_location'    => 'required|string|unique:users|max:255',
            'utility_bill_location' => 'required|string|unique:users|max:255',
            'idcard_location'       => 'required|string|unique:users|max:255',
            'passport_location'     => 'required|string|unique:users|max:255',
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

    public function addUser(Request $request)
    {
        $details = $request->all();
        //$this->validateUser($details->validate());
        array_push($details, $this->uploadFiles($request));
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
            //'dob'                   => date_create_from_format('Y-M-d',$data['dob']),
            'marital_status'        => $data['marital_status'],
            //'gender'     => $data['mega-gender-group'],
            'phone_no'              => $data['phone_no'],
            'nationality'           => $data['nationality'],
            'state'                 => $data['state'],
            'lga'                   => $data['lga'],
            'residential_address'   => $data['residential_address'],
            'contact_address'       => $data['contact_address'],
            'id_card_type'          => $data['id_card_type'],
            'id_card_no'            => $data['id_card_no'],
            'bvn'                   => $data['bvn'],
            'occupation'            => $data['occupation'],
            'next_of_kin'           => $data['next_of_kin'],
            'nok_relationship'      => $data['nok_relationship'],
            'nok_contact_address'   => $data['nok_contact_address'],
            //'nok_dob'               => date_create_from_format('Y-M-d',$data['nok_dob']),
            //'nok_gender'            => $data['nok_gender'],
            'nok_phone_no'          => $data['nok_phone_number'],
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
        ]);
    }

    public function uploadFiles(Request $request)
    {
        $details = array();
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
                $details['form_location'] = str_replace('public', 'storage',
                    $formImage->store('public/images/forms'));
                $details['signature_location'] = str_replace('public',
                    'storage',
                    $signatureImage->store('public/images/signatures'));
                $details['utility_bill_location'] = str_replace('public',
                    'storage',
                    $utilityImage->store('public/images/utility_bills'));
                $details['idcard_location'] = str_replace('public', 'storage',
                    $idcardImage->store('public/images/idcards'));
                $details['form_location'] = str_replace('public', 'storage',
                    $passportImage->store('public/images/profile'));
            }
        }
        var_dump($details);
    }

    public function viewAddUser($data = array())
    {
        $data['action'] = 'new user';
        return view('admin.newUser', $data);
    }

    public function viewAddAdmin()
    {

    }

    public function viewAddPnm()
    {
        $data['action'] = 'new PNM';
        return view('admin.newPNM', $data);
    }

}
