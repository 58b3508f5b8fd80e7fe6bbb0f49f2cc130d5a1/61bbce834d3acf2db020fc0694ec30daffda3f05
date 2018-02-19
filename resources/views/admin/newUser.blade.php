<?php
$data = session('data');
$states = [
    'Abia',
    'Adamawa',
    'Anambra',
    'Akwa Ibom',
    'Bauchi',
    'Bayelsa',
    'Benue',
    'Borno',
    'Cross River',
    'Delta',
    'Ebonyi',
    'Enugu',
    'Edo',
    'Ekiti',
    'Gombe',
    'Imo',
    'Jigawa',
    'Kaduna',
    'Kano',
    'Katsina',
    'Kebbi',
    'Kogi',
    'Kwara',
    'Lagos',
    'Nasarawa',
    'Niger',
    'Ogun',
    'Ondo',
    'Osun',
    'Oyo',
    'Plateau',
    'Rivers',
    'Sokoto',
    'Taraba',
    'Yobe',
    'Zamfara',
];

?>
@extends('layouts.admin')
@section('title', title_case($action).' users')
@section('style')
    <link href="{{asset('css/bootstrap-formhelpers.min.css')}}" rel="stylesheet" media="screen">
@endsection
@section('content')
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/admin')}}">Admin</a>
        <span class="breadcrumb-item active">Add {{title_case($action)}}</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add
                <small>{{title_case($action)}}</small>
            </h3>
        </div>
        <div class="block-content">
            @if(isset($data['message']))
                <div class="col-sm-12 col-lg-12">
                    <div class="block">
                        <div class="alert alert-{{$data['alert']}}">
                            <h2>{{$data['message']}}</h2>
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{url('/admin/add/user')}}" method="post" enctype="multipart/form-data" id="user-form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4 col-xs-12">

                        <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-firstname">Firstname</label>
                                <input class="form-control form-control-lg" id="mega-firstname"
                                       name="first_name"
                                       placeholder="Enter user firstname.." type="text" value="{{old('first_name')}}">
                            </div>
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback">
                                {{ $errors->first('first_name') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-lastname">Lastname</label>
                                <input class="form-control form-control-lg" id="mega-lastname" name="last_name"
                                       placeholder="Enter user lastname.." type="text" value="{{old('last_name')}}">
                            </div>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                {{ $errors->first('last_name') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('other_name') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-othername">Other name(s)</label>
                                <input class="form-control form-control-lg" id="mega-othername"
                                       name="other_name"
                                       placeholder="Enter user other name.." type="text" value="{{old('other_name')}}">
                            </div>
                            @if ($errors->has('other_name'))
                                <span class="invalid-feedback">
                                {{ $errors->first('other_name') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group{{ $errors->has('account_number') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-accountnumber">Account number</label>
                                <input class="form-control form-control-lg" id="mega-accountnumber"
                                       name="account_number"
                                       placeholder="Enter user account number.." type="text"
                                       value="{{old('account_number')}}">
                            </div>
                            @if ($errors->has('account_number'))
                                <span class="invalid-feedback">
                                {{ $errors->first('account_number') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('wallet_address') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-walletaddress">Wallet Address</label>
                                <input class="form-control form-control-lg" id="mega-walletaddress"
                                       name="wallet_address"
                                       placeholder="Enter user wallet address.." type="text"
                                       value="{{old('wallet_address')}}">
                            </div>
                            @if ($errors->has('wallet_address'))
                                <span class="invalid-feedback">
                                {{ $errors->first('wallet_address') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('private_key') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-privatekey">Private Key</label>
                                <input class="form-control form-control-lg" id="mega-privatekey"
                                       name="private_key"
                                       placeholder="Enter user private key.." type="text"
                                       value="{{old('private_key')}}">
                            </div>
                            @if ($errors->has('private_key'))
                                <span class="invalid-feedback">
                                {{ $errors->first('private_key') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group{{ $errors->has('dob') ? ' is-invalid' : '' }} row">
                            <label for="dob">Date of birth</label>
                            <div id="dob" class=" col-12 bfh-datepicker" data-name="dob" data-format="y-m-d"
                                 data-date="today" data-placeholder="YYYY/MM/DD"
                                 data-class="form-control form-control-lg ">
                            </div>
                            @if ($errors->has('dob'))
                                <span class="invalid-feedback">
                                {{ $errors->first('dob') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('marital_status') ? ' is-invalid' : '' }} row">
                            <label class="col-12">Marital Status</label>
                            <div class="col-12">
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="marital_status" type="radio"
                                           value="single" id="single"
                                           @if(old('marital_status')=='single') checked @endif>
                                    <span class="css-control-indicator"></span> Single
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="marital_status" type="radio"
                                           value="married" id="married"
                                           @if(old('marital_status')=='married') checked @endif>
                                    <span class="css-control-indicator"></span> Married
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="marital_status" type="radio"
                                           value="divorced" id="divorced"
                                           @if(old('marital_status')=='divorced') checked @endif>
                                    <span class="css-control-indicator"></span> Divorced
                                </label>
                            </div>
                            @if ($errors->has('marital_status'))
                                <span class="invalid-feedback">
                                {{ $errors->first('marital_status') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('gender') ? ' is-invalid' : '' }} row">
                            <label class="col-12">Gender</label>
                            <div class="col-12">
                                <label class="css-control css-control-primary css-radio mr-10">
                                    <input class="css-control-input" name="gender" type="radio" value="female"
                                           @if(old('gender')=='female') checked @endif>
                                    <span class="css-control-indicator"></span> Female
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="gender" type="radio" value="male"
                                           @if(old('gender')=='male') checked @endif>
                                    <span class="css-control-indicator"></span> Male
                                </label>
                            </div>
                            @if ($errors->has('gender'))
                                <span class="invalid-feedback">
                                {{ $errors->first('gender') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('phone_no') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-phoneno">Phone Number</label>
                                <input class="form-control form-control-lg" id="mega-phoneno"
                                       name="phone_no"
                                       placeholder="Enter your Phone Number" type="text" value="{{old('phone_no')}}">
                            </div>
                            @if ($errors->has('phone_no'))
                                <span class="invalid-feedback">
                                {{ $errors->first('phone_no') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('nationality') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-nationality">Nationality</label>
                                <input class="form-control form-control-lg" id="mega-nationality"
                                       name="nationality"
                                       placeholder="Enter your Nationality" type="text" value="Nigerian" readonly>
                                @if ($errors->has('nationality'))
                                    <span class="invalid-feedback">
                                {{ $errors->first('nationality') }}
                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('state') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-state">State</label>
                                <select class="form-control form-control-lg" id="mega-state" name="state">
                                    <optgroup label="">
                                        <option selected disabled>Select state</option>
                                        @foreach($states as $state)
                                            <option @if (old('state')== $state) selected @endif>{{$state}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('lga') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-lga">LGA</label>
                                <select class="form-control form-control-lg" id="mega-lga" name="lga">
                                    <option selected disabled>Select LGA</option>
                                </select>
                                @if ($errors->has('lga'))
                                    <span class="invalid-feedback">
                                {{ $errors->first('lga') }}
                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <div class="form-group{{ $errors->has('residential_address') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-residential">Residential Address</label>
                                <input class="form-control form-control-lg" id="mega-residential_address"
                                       name="residential_address" placeholder="Enter your residential address.."
                                       type="text" value="{{old('residential_address')}}">
                                @if ($errors->has('residential_address'))
                                    <span class="invalid-feedback">
                                {{ $errors->first('residential_address') }}
                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <div class="form-group{{ $errors->has('contact_address') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-contactaddress">Contact Address</label>
                                <input class="form-control form-control-lg" id="mega-contactaddress"
                                       name="contact_address"
                                       placeholder="Enter your Contact Address" type="text"
                                       value="{{old('contact_address')}}">
                            </div>
                        </div>
                        @if ($errors->has('contact_address'))
                            <span class="invalid-feedback">
                                {{ $errors->first('contact_address') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-6">
                        <div class="form-group{{ $errors->has('id_card_type') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-idcardtype">ID Card Type</label>
                                <input class="form-control form-control-lg" id="mega-idcardtype"
                                       name="id_card_type" placeholder="Enter ID Card Type.." type="text"
                                       value="{{old('id_card_type')}}">
                                @if ($errors->has('id_card_type'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('id_card_type') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <div class="form-group{{ $errors->has('id_card_no') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-idcardno">ID Card No</label>
                                <input class="form-control form-control-lg" id="mega-idcardno"
                                       name="id_card_no"
                                       placeholder="Enter your ID Card No.." type="text" value="{{old('id_card_no')}}">
                                @if ($errors->has('id_card_no'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('id_card_no') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group{{ $errors->has('occupation') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-occupation">Occupation</label>
                                <input class="form-control form-control-lg" id="mega-occupation"
                                       name="occupation"
                                       placeholder="Enter your Occupation" type="text" value="{{old('occupation')}}">
                            </div>
                            @if ($errors->has('occupation'))
                                <span class="invalid-feedback">
                                {{ $errors->first('occupation') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('bvn') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-bvn">BVN</label>
                                <input class="form-control form-control-lg" id="mega-bvn"
                                       name="bvn"
                                       placeholder="Enter your Bank Verification Number" type="text"
                                       value="{{old('bvn')}}">
                            </div>
                            @if ($errors->has('bvn'))
                                <span class="invalid-feedback">
                                {{ $errors->first('bvn') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('bank_name') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-bankname">Bank Name</label>
                                <input class="form-control form-control-lg" id="mega-bankname"
                                       name="bank_name"
                                       placeholder="Enter your Bank Name" type="text" value="{{old('bank_name')}}">
                            </div>
                            @if ($errors->has('bank_name'))
                                <span class="invalid-feedback">
                                {{ $errors->first('bank_name') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('bank_acc_name') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-idcardno">Bank Account Name</label>
                                <input class="form-control form-control-lg" id="mega-bankaccname"
                                       name="bank_acc_name"
                                       placeholder="Enter your ID Card No.." type="text"
                                       value="{{old('bank_acc_name')}}">
                                @if ($errors->has('bank_acc_name'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('bank_acc_name') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('bank_acc_no') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-bankaccno">Bank Account No.</label>
                                <input class="form-control form-control-lg" id="mega-bankaccno"
                                       name="bank_acc_no"
                                       placeholder="Enter your Occupation" type="text" value="{{old('bank_acc_no')}}">
                                @if ($errors->has('bank_acc_no'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('bank_acc_no') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group{{ $errors->has('next_of_kin') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-nok">Next of kin</label>
                                <input class="form-control form-control-lg" id="mega-nok"
                                       name="next_of_kin" placeholder="Enter Next of Kin.." type="text"
                                       value="{{old('next_of_kin')}}">
                                @if ($errors->has('next_of_kin'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('next_of_kin') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group{{ $errors->has('nok_relationship') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-nokrelationship">NOK Relationship</label>
                                <input class="form-control form-control-lg" id="mega-nokrelationship"
                                       name="nok_relationship"
                                       placeholder="Enter Next on Kin Relationship.." type="text"
                                       value="{{old('nok_relationship')}}">
                                @if ($errors->has('nok_relationship'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('nok_relationship') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group{{ $errors->has('nok_contact_address') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-nokcontactaddress">NOK Contact Address</label>
                                <input class="form-control form-control-lg" id="mega-nokcontactaddress"
                                       name="nok_contact_address"
                                       placeholder="Enter Next of Kin Contact Address" type="text"
                                       value="{{old('nok_contact_address')}}">
                                @if ($errors->has('nok_contact_address'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('nok_contact_address') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-6">
                        <div class="form-group{{ $errors->has('nok_dob') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-nokdob">NOK Date of birth</label>
                                <div id="nok-dob" class=" col-12 bfh-datepicker" data-name="nok_dob" data-format="y-m-d"
                                     data-date="today" data-placeholder="YYYY/MM/DD"
                                     data-class="form-control form-control-lg ">
                                </div>
                                @if ($errors->has('nok_dob'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('nok_dob') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group{{ $errors->has('nok_gender') ? ' is-invalid' : '' }} row">
                            <label class="col-12">NOK Gender</label>
                            <div class="col-12">
                                <label class="css-control css-control-primary css-radio mr-10">
                                    <input class="css-control-input" name="nok_gender" type="radio" value="female"
                                           @if(old('nok_gender')=='female') checked @endif>
                                    <span class="css-control-indicator"></span> Female
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="nok_gender" type="radio" value="male"
                                           @if(old('nok_gender')=='male') checked @endif>
                                    <span class="css-control-indicator"></span> Male
                                </label>
                            </div>
                            @if ($errors->has('nok_gender'))
                                <span class="invalid-feedback">
                                {{ $errors->first('nok_gender') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group{{ $errors->has('nok_phone_no') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-nokphonenum">NOK Phone Number</label>
                                <input class="form-control form-control-lg" id="mega-nokphonenum"
                                       name="nok_phone_no"
                                       placeholder="Enter Next of Kin Phone Number.." type="text"
                                       value="{{old('nok_phone_no')}}">
                                @if ($errors->has('nok_phone_no'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('nok_phone_no') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group{{ $errors->has('nok_email') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-nokemail">NOK Email</label>
                                <input class="form-control form-control-lg" id="mega-nokemail"
                                       name="nok_email"
                                       placeholder="Enter your Next of Kin Email" type="text"
                                       value="{{old('nok_email')}}">
                                @if ($errors->has('nok_email'))
                                    <span class="invalid-feedback">
                                    {{ $errors->first('nok_email') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group{{ $errors->has('spouse_name') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-spousename">Spouse Name</label>
                                <input class="form-control form-control-lg" id="mega-spousename"
                                       name="spouse_name" placeholder="Enter spouse name.." type="text"
                                       value="{{old('spouse_name')}}">
                                @if ($errors->has('spouse_name'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('spouse_name') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group{{ $errors->has('mother_maiden_name') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-mothermaidenname">Mother Maiden Name</label>
                                <input class="form-control form-control-lg" id="mega_mothermaidenname"
                                       name="mother_maiden_name"
                                       placeholder="Enter mother maiden name.." type="text"
                                       value="{{old('mother_maiden_name')}}">
                                @if ($errors->has('mother_maiden_name'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('mother_maiden_name') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group{{ $errors->has('office_phone_no') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-officephoneno">Office Phone No</label>
                                <input class="form-control form-control-lg" id="mega-officephoneno"
                                       name="office_phone_no"
                                       placeholder="Enter Office Phone No.." type="text"
                                       value="{{old('office_phone_no')}}">
                                @if ($errors->has('office_phone_no'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('office_phone_no') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group{{ $errors->has('landmark') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <label for="mega-landmark">Landmark</label>
                                <input class="form-control form-control-lg" id="mega-landmark"
                                       name="landmark"
                                       placeholder="Enter Office Phone No.." type="text" value="{{old('landmark')}}">
                                @if ($errors->has('landmark'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('landmark') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group{{ $errors->has('form_location') ? ' is-invalid' : '' }} row">
                            <label for="#">Upload Form</label>
                            <div class="form-group input-group">
                                <label class="input-group-btn"> <span class="btn btn-primary">
									Browse<input type="file" name="form_location" accept=".png,.jpg,.gif"
                                                 style="display: none;" id="formlocation"
                                        >
							</span>
                                </label><input type="text" id="form-info" class="form-control"
                                               readonly
                                >
                            </div>
                            @if ($errors->has('form_location'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('form_location') }}
                                </span>
                            @endif
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="formImage"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group{{ $errors->has('signature_location') ? ' is-invalid' : '' }} row">
                            <label for="#">Upload Signature</label>
                            <div class="form-group input-group">
                                <label class="input-group-btn"> <span class="btn btn-success">
									Browse<input type="file" name="signature_location" accept=".png,.jpg,.gif"
                                                 style="display: none;" id="signaturelocation"
                                        >
							</span>
                                </label><input type="text" id="signature-info" class="form-control"
                                               readonly
                                >
                            </div>
                            @if ($errors->has('signature_location'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('signature_location') }}
                                </span>
                            @endif
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="signatureImage"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group{{ $errors->has('utility_bill_location') ? ' is-invalid' : '' }} row">
                            <label for="#">Upload Utility Bill</label>
                            <div class="form-group input-group">
                                <label class="input-group-btn"> <span class="btn btn-warning">
									Browse<input type="file" name="utility_bill_location"
                                                 accept=".png,.jpg,.gif"
                                                 style="display: none;" id="utilitylocation"
                                        >
							</span>
                                </label><input type="text" id="utility-info" class="form-control"
                                               readonly
                                >
                            </div>
                            @if ($errors->has('utility_bill_location'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('utility_bill_location') }}
                                </span>
                            @endif
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="utilityImage"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group{{ $errors->has('idcard_location') ? ' is-invalid' : '' }} row">
                            <label for="#">Upload ID Card</label>
                            <div class="form-group input-group">
                                <label class="input-group-btn"> <span class="btn btn-dark">
									Browse<input type="file" name="idcard_location" accept=".png,.jpg,.gif"
                                                 style="display: none;" id="idcardlocation"
                                        >
							</span>
                                </label><input type="text" id="mega-idcardno-info" class="form-control"
                                               readonly
                                >
                            </div>
                            @if ($errors->has('idcard_location'))
                                <span class="invalid-feedback">
                                        {{ $errors->first('idcard_location') }}
                                    </span>
                            @endif
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="idcardImage"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group{{ $errors->has('passport_location') ? ' is-invalid' : '' }} row">
                            <label for="#">Upload Passport</label>
                            <div class="form-group input-group">
                                <label class="input-group-btn"> <span class="btn btn-danger">
									Browse<input type="file" name="passport_location" accept=".png,.jpg,.gif"
                                                 style="display: none;" id="passportlocation"
                                        >
							</span>
                                </label><input type="text" id="file-info" class="form-control"
                                               readonly
                                >
                            </div>
                            @if ($errors->has('passport_location'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('passport_location') }}
                                </span>
                            @endif
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="passportImage"></div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }} row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check mr-5"></i> Complete Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="demo"></div>
@endsection
@section('scripts')
    <script src="{{asset('js/bootstrap-formhelpers.min.js')}}"></script>
    <script>
        @if(isset($data['message']))
        alert('{{$data['message']}}');
        @endif
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#mega-state").change(function () {
            var data = {'state': $('#mega-state').val()};
            $.post('/admin/add/user/getlgas', data, function (result) {
                $('#mega-lga').html(result.html);
            });
        });
        $(function () {

            // We can attach the `fileselect` event to all file inputs on the page
            $(document).on('change', ':file', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                //$('#file-info').val(label);
                input.trigger('fileselect', [numFiles, label]);
            });

            // We can watch for our custom `fileselect` event like this
            $(document).ready(function () {
                $(':file').on('fileselect', function (event, numFiles, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log) alert(log);
                    }

                });
            });

        });

        function filePreview(input, id) {
            $(id).html('');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(id).siblings('embed').remove();
                    $(id).after('<embed src="' + e.target.result + '" style = "max-width: 100%; max-height: 20em;"/>');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#formlocation").change(function () {
            filePreview(this, '#formImage');
        });
        $("#signaturelocation").change(function () {
            filePreview(this, '#signatureImage');
        });
        $("#utilitylocation").change(function () {
            filePreview(this, '#utilityImage');
        });
        $("#idcardlocation").change(function () {
            filePreview(this, '#idcardImage');
        });
        $("#passportlocation").change(function () {
            filePreview(this, '#passportImage');
        });

    </script>
@endsection