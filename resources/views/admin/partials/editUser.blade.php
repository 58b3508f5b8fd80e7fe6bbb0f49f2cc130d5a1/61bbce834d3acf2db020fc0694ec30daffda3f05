<?php
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
if (Auth::user()->access_level < 3)
    $readonly = 'readonly';
else $readonly = null;
?>

<div class="row block justify-content-center px-5">
    <div class="col-12">
        <form action="{{url('/admin/edit/user')}}" method="post" enctype="multipart/form-data" id="user-form"
              {{--onsubmit="editUser(); return false;"--}}>
            {{ csrf_field() }}
            <input {{$readonly}} type="hidden" value="{{$user['id']+1427}}" name="id" id="id">
            <div class="row block">
                <div class="col-md-4 col-xs-12">

                    <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="firstname">Firstname</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="firstname"
                                   name="first_name"
                                   placeholder="Enter user firstname.." type="text" value="{{$user['first_name']}}">
                        </div>
                        @if ($errors->has('first_name'))
                            <span class="invalid-feedback">
                                {{ $errors->first('first_name') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="lastname">Lastname</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="lastname" name="last_name"
                                   placeholder="Enter user lastname.." type="text" value="{{$user['last_name']}}">
                        </div>
                        @if ($errors->has('last_name'))
                            <span class="invalid-feedback">
                                {{ $errors->first('last_name') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('other_name') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="othername">Other name(s)</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="othername"
                                   name="other_name"
                                   placeholder="Enter user other name.." type="text" value="{{$user['other_name']}}">
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
                            <label for="accountnumber">Account number</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="accountnumber"
                                   name="account_number"
                                   placeholder="Enter user account number.." type="text"
                                   value="{{$user['account_number']}}">
                        </div>
                        @if ($errors->has('account_number'))
                            <span class="invalid-feedback">
                                {{ $errors->first('account_number') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('wallet_address') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="walletaddress">Wallet Address</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="walletaddress"
                                   name="wallet_address"
                                   placeholder="Enter user wallet address.." type="text"
                                   value="{{$user['wallet_address']}}">
                        </div>
                        @if ($errors->has('wallet_address'))
                            <span class="invalid-feedback">
                                {{ $errors->first('wallet_address') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('private_key') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="privatekey">Private Key</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="privatekey"
                                   name="private_key"
                                   placeholder="Enter user private key.." type="text"
                                   value="{{$user['private_key']}}">
                        </div>
                        @if ($errors->has('private_key'))
                            <span class="invalid-feedback">
                                {{ $errors->first('private_key') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group{{ $errors->has('dob') ? ' is-invalid' : '' }} row"
                         style="position:relative;">
                        <label for="dob">Date of birth</label>
                        <input type="text" id="dob" name="dob" class="form-control form-control-lg"
                               placeholder="YYYY/MM/DD" value="{{$user['dob']}}"/>

                    </div>
                    <div class="form-group{{ $errors->has('marital_status') ? ' is-invalid' : '' }} row">
                        <label class="col-12">Marital Status</label>
                        <div class="col-12">
                            <label class="css-control css-control-primary css-radio">
                                <input {{$readonly}} class="css-control-input" name="marital_status" type="radio"
                                       value="single" id="single"
                                       onchange="changeSelect('input[name=marital_status]','single')"
                                       @if($user['marital_status']=='single') checked @endif >
                                <span class="css-control-indicator"></span> Single
                            </label>
                            <label class="css-control css-control-primary css-radio">
                                <input {{$readonly}} class="css-control-input" name="marital_status" type="radio"
                                       value="married" id="married"
                                       onchange="changeSelect('input[name=marital_status]','married')"
                                       @if($user['marital_status']=='married') checked @endif>
                                <span class="css-control-indicator"></span> Married
                            </label>
                            <label class="css-control css-control-primary css-radio">
                                <input {{$readonly}} class="css-control-input" name="marital_status" type="radio"
                                       value="divorced" id="divorced"
                                       onchange="changeSelect('input[name=marital_status]','divorced')"
                                       @if($user['marital_status']=='divorced') checked @endif>
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
                                <input {{$readonly}} class="css-control-input" name="gender" type="radio"
                                       onchange="changeSelect('input[name=gender]','female')" value="female"
                                       @if($user['gender']=='female') checked @endif>
                                <span class="css-control-indicator"></span> Female
                            </label>
                            <label class="css-control css-control-primary css-radio">
                                <input {{$readonly}} class="css-control-input" name="gender" type="radio"
                                       onchange="changeSelect('input[name=gender]','male')" value="male"
                                       @if($user['gender']=='male') checked @endif>
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
            <div class="row block">
                <div class="col-md-3 col-xs-6">
                    <div class="form-group{{ $errors->has('phone_no') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="phoneno">Phone Number</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="phoneno"
                                   name="phone_no"
                                   placeholder="Enter your Phone Number" type="text" value="{{$user['phone_no']}}">
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
                            <label for="nationality">Nationality</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="nationality"
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
                            <label for="state">State</label>
                            <select {{$readonly}} class="form-control form-control-lg" id="state" name="state">
                                <optgroup label="">
                                    <option selected disabled>Select state</option>
                                    @foreach($states as $state)
                                        <option @if ($user['state']== $state || $user['state'] == $state) selected @endif>{{$state}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="form-group{{ $errors->has('lga') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="lga">LGA</label>
                            <select {{$readonly}} class="form-control form-control-lg" id="lga" name="lga">
                                <option selected>{{$user['lga']}}</option>
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
            <div class="row block">
                <div class="col-md-6 col-xs-6">
                    <div class="form-group{{ $errors->has('residential_address') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="residential">Residential Address</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="residential_address"
                                   name="residential_address" placeholder="Enter your residential address.."
                                   type="text" value="{{$user['residential_address']}}">
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
                            <label for="contactaddress">Contact Address</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="contactaddress"
                                   name="contact_address"
                                   placeholder="Enter your Contact Address" type="text"
                                   value="{{$user['contact_address']}}">
                        </div>
                    </div>
                    @if ($errors->has('contact_address'))
                        <span class="invalid-feedback">
                                {{ $errors->first('contact_address') }}
                            </span>
                    @endif
                </div>
            </div>
            <div class="row block">
                <div class="col-md-4 col-xs-6">
                    <div class="form-group{{ $errors->has('id_card_type') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="idcardtype">ID Card Type</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="idcardtype"
                                   name="id_card_type" placeholder="Enter ID Card Type.." type="text"
                                   value="{{$user['id_card_type']}}">
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
                            <label for="idcardno">ID Card No</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="idcardno"
                                   name="id_card_no"
                                   placeholder="Enter your ID Card No.." type="text" value="{{$user['id_card_no']}}">
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
                            <label for="occupation">Occupation</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="occupation"
                                   name="occupation"
                                   placeholder="Enter your Occupation" type="text" value="{{$user['occupation']}}">
                        </div>
                        @if ($errors->has('occupation'))
                            <span class="invalid-feedback">
                                {{ $errors->first('occupation') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row block">
                <div class="col-md-3 col-xs-6">
                    <div class="form-group{{ $errors->has('bvn') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="bvn">BVN</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="bvn"
                                   name="bvn"
                                   placeholder="Enter your Bank Verification Number" type="text"
                                   value="{{$user['bvn']}}">
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
                            <label for="bankname">Bank Name</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="bankname"
                                   name="bank_name"
                                   placeholder="Enter your Bank Name" type="text" value="{{$user['bank_name']}}">
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
                            <label for="idcardno">Bank Account Name</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="bankaccname"
                                   name="bank_acc_name"
                                   placeholder="Enter your ID Card No.." type="text"
                                   value="{{$user['bank_acc_name']}}">
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
                            <label for="bankaccno">Bank Account No.</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="bankaccno"
                                   name="bank_acc_no"
                                   placeholder="Enter your Occupation" type="text" value="{{$user['bank_acc_no']}}">
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
            <div class="row block">
                <div class="col-md-4 col-xs-12">
                    <div class="form-group{{ $errors->has('next_of_kin') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="nok">Next of kin</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="nok"
                                   name="next_of_kin" placeholder="Enter Next of Kin.." type="text"
                                   value="{{$user['next_of_kin']}}">
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
                            <label for="nokrelationship">NOK Relationship</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="nokrelationship"
                                   name="nok_relationship"
                                   placeholder="Enter Next on Kin Relationship.." type="text"
                                   value="{{$user['nok_relationship']}}">
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
                            <label for="nokcontactaddress">NOK Contact Address</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="nokcontactaddress"
                                   name="nok_contact_address"
                                   placeholder="Enter Next of Kin Contact Address" type="text"
                                   value="{{$user['nok_contact_address']}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row block">
                <div class="col-md-3 col-xs-6">
                    <div class="form-group{{ $errors->has('nok_dob') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="nok-dob">NOK Date of birth</label>
                            <input type="text" id="nok-dob" name="nok_dob" class="form-control form-control-lg"
                                   placeholder="YYYY/MM/DD" value="{{$user['nok_dob']}}"/>

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
                                <input {{$readonly}} class="css-control-input" name="nok_gender" type="radio"
                                       value="female" onchange="changeSelect('input[name=nok_gender]','female')"
                                       @if($user['nok_gender']=='female') checked @endif>
                                <span class="css-control-indicator"></span> Female
                            </label>
                            <label class="css-control css-control-primary css-radio">
                                <input {{$readonly}} class="css-control-input" name="nok_gender" type="radio"
                                       value="male" onchange="changeSelect('input[name=nok_gender]','male')"
                                       @if($user['nok_gender']=='male') checked @endif>
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
                            <label for="nokphonenum">NOK Phone Number</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="nokphonenum"
                                   name="nok_phone_no"
                                   placeholder="Enter Next of Kin Phone Number.." type="text"
                                   value="{{$user['nok_phone_no']}}">
                            @if ($errors->has('nok_phone_no'))
                                <span class="invalid-feedback">
                                        {{ $errors->first('nok_phone_no') }}
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12">
                    <div class="form-group{{ $errors->has('nok_email') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="nokemail">NOK Email</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="nokemail"
                                   name="nok_email"
                                   placeholder="Enter your Next of Kin Email" type="text"
                                   value="{{$user['nok_email']}}">
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
            <div class="row block">
                <div class="col-md-4 col-xs-12">
                    <div class="form-group{{ $errors->has('spouse_name') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="spousename">Spouse Name</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="spousename"
                                   name="spouse_name" placeholder="Enter spouse name.." type="text"
                                   value="{{$user['spouse_name']}}">
                            @if ($errors->has('spouse_name'))
                                <span class="invalid-feedback">
                                        {{ $errors->first('spouse_name') }}
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12">
                    <div class="form-group{{ $errors->has('mother_maiden_name') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="mothermaidenname">Mother Maiden Name</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="mega_mothermaidenname"
                                   name="mother_maiden_name"
                                   placeholder="Enter mother maiden name.." type="text"
                                   value="{{$user['mother_maiden_name']}}">
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
                            <label for="officephoneno">Office Phone No</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="officephoneno"
                                   name="office_phone_no"
                                   placeholder="Enter Office Phone No.." type="text"
                                   value="{{$user['office_phone_no']}}">
                            @if ($errors->has('office_phone_no'))
                                <span class="invalid-feedback">
                                        {{ $errors->first('office_phone_no') }}
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12">
                    <div class="form-group{{ $errors->has('landmark') ? ' is-invalid' : '' }} row">
                        <div class="col-12">
                            <label for="landmark">Landmark</label>
                            <input {{$readonly}} class="form-control form-control-lg" id="landmark"
                                   name="landmark"
                                   placeholder="Enter Office Phone No.." type="text" value="{{$user['landmark']}}">
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
            <div class="row block">
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
                    <div id="formImage">
                        <img src="{{Storage::url($user['form_location'])}}" style="max-width: 100%; max-height: 20em;">
                    </div>
                </div>
            </div>
            <div class="row block">
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
                    <div id="signatureImage"><img src="{{Storage::url($user['signature_location'])}}" style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>
            <div class="row block">
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
                    <div id="utilityImage"><img src="{{Storage::url($user['utility_bill_location'])}}" style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>
            <div class="row block">
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
                    <div id="idcardImage"><img src="{{Storage::url($user['idcard_location'])}}" style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>
            <div class="row block">
                <div class="col-md-5 col-xs-12">
                    <div class="form-group{{ $errors->has('passport_location') ? ' is-invalid' : '' }} row">
                        <label for="#">Upload Passport</label>
                        <div class="form-group input-group">
                            <label class="input-group-btn"> <span class="btn btn-danger">
									Browse<input type="file" name="passport_location" accept=".png,.jpg,.gif"
                                                 style="display: none;" id="passportlocation">
							</span>
                            </label><input type="text" id="file-info" class="form-control"
                                           readonly>
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
                    <div id="passportImage"><img src="{{Storage::url($user['passport_location'])}}" style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>
            {{--<div class="row block block">
                <div class="col-md-5 col-xs-12">
                    <h3 class="text-md-right text-sm-center text-muted">Form</h3>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div id="formImage" class="text-sm-center"><img src="{{Storage::url($user['form_location'])}}"
                                                                    style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>
            <div class="row block block">
                <div class="col-md-5 col-xs-12">
                    <h3 class="text-md-right text-sm-center text-muted">Signature</h3>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div id="signatureImage" class="text-sm-center" class="text-sm-center"><img
                                src="{{Storage::url($user['signature_location'])}}"
                                style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>
            <div class="row block block">
                <div class="col-md-5 col-xs-12">
                    <h3 class="text-md-right text-sm-center text-muted">Utility Bill</h3>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div id="utilityImage" class="text-sm-center"><img
                                src="{{Storage::url($user['utility_bill_location'])}}"
                                style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>
            <div class="row block block">
                <div class="col-md-5 col-xs-12">
                    <h3 class="text-md-right text-sm-center text-muted">Identity Card</h3>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div id="idcardImage" class="text-sm-center"><img src="{{Storage::url($user['idcard_location'])}}"
                                                                      style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>
            <div class="row block block">
                <div class="col-md-5 col-xs-12">
                    <h3 class="text-md-right text-sm-center text-muted">Passport</h3>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div id="passportImage" class="text-sm-center"><img
                                src="{{Storage::url($user['passport_location'])}}"
                                style="max-width: 100%; max-height: 20em;"></div>
                </div>
            </div>--}}
            @if (!Auth::user()->access_level < 3)
                <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }} row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check mr-5"></i> Update Profile
                        </button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
