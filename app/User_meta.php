<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class User_meta extends Model
{
    //
    use Searchable;
    protected $fillable
        = [
            'first_name',
            'last_name',
            'other_name',
            'account_number',
            'wallet_address',
            'private_key',
            'dob',
            'marital_status',
            'mega-gender-group',
            'phone_no',
            'nationality',
            'state',
            'lga',
            'residential_address',
            'contact_address',
            'id_card_type',
            'id_card_no',
            'bvn',
            'bank_name',
            'bank_acc_name',
            'bank_acc_no',
            'occupation',
            'next_of_kin',
            'nok_relationship',
            'nok_contact_address',
            'nok_dob',
            'nok_gender',
            'nok_phone_number',
            'nok_email',
            'spouse_name',
            'mother_maiden_name',
            'office_phone_no',
            'landmark',
            'form_location',
            'signature_location',
            'utility_bill_location',
            'idcard_location',
            'passport_location',
            'status',
        ];
}
