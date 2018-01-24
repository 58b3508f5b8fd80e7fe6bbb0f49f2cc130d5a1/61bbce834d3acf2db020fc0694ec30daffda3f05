@extends('layouts.admin')
@section('title', title_case($action).' users')
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
            @if(isset($message))
                <div class="col-sm-12 col-lg-12">
                    <div class="block">
                        <div class="alert alert-{{$alert}}">
                            <h2>Status Message</h2>
                            <p>{{$message}}</p>
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{url('/admin/add/user')}}" method="post" enctype="multipart/form-data" id="user-form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4 col-xs-12">

                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-firstname">Firstname</label>
                                <input class="form-control form-control-lg" id="mega-firstname"
                                       name="first_name"
                                       placeholder="Enter user firstname.." type="text" value="{{old('first_name')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-lastname">Lastname</label>
                                <input class="form-control form-control-lg" id="mega-lastname" name="last_name"
                                       placeholder="Enter user lastname.." type="text" value="{{old('last_name')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-othername">Other name(s)</label>
                                <input class="form-control form-control-lg" id="mega-othername"
                                       name="other_name"
                                       placeholder="Enter user other name.." type="text" value="{{old('other_name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-accountnumber">Account number</label>
                                <input class="form-control form-control-lg" id="mega-accountnumber"
                                       name="account_number"
                                       placeholder="Enter user account number.." type="text"
                                       value="{{old('account_number')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-walletaddress">Wallet Address</label>
                                <input class="form-control form-control-lg" id="mega-walletaddress"
                                       name="wallet_address"
                                       placeholder="Enter user wallet address.." type="text"
                                       value="{{old('wallet_address')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-privatekey">Private Key</label>
                                <input class="form-control form-control-lg" id="mega-privatekey"
                                       name="private_key"
                                       placeholder="Enter user private key.." type="text"
                                       value="{{old('private_key')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-accountnumber">Date of birth</label>
                                <input class="form-control form-control-lg" id="mega-accountnumber"
                                       name="dob"
                                       placeholder="dd/mm/yyyy" type="date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12">Marital Status</label>
                            <div class="col-12">
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="marital_status" type="radio"
                                           value="single">
                                    <span class="css-control-indicator"></span> Single
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="marital_status" type="radio"
                                           value="married">
                                    <span class="css-control-indicator"></span> Married
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="marital_status" type="radio"
                                           value="divorced">
                                    <span class="css-control-indicator"></span> Divorced
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12">Gender</label>
                            <div class="col-12">
                                <label class="css-control css-control-primary css-radio mr-10">
                                    <input class="css-control-input" name="mega-gender-group" type="radio">
                                    <span class="css-control-indicator"></span> Female
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="mega-gender-group" type="radio">
                                    <span class="css-control-indicator"></span> Male
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-phoneno">Phone Number</label>
                                <input class="form-control form-control-lg" id="mega-phoneno"
                                       name="phone_no"
                                       placeholder="Enter your Phone Number" type="text" value="{{old('phone_no')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-nationality">Nationality</label>
                                <input class="form-control form-control-lg" id="mega-nationality"
                                       name="nationality"
                                       placeholder="Enter your Phone Number" type="text" value="Nigerian" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-state">State</label>
                                <select class="form-control form-control-lg" id="mega-state" name="state">
                                    <option>Imo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-lga">LGA</label>
                                <select class="form-control form-control-lg" id="mega-lga" name="lga">
                                    <option>Ahiazu Mbaise</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-residential">Residential Address</label>
                                <input class="form-control form-control-lg" id="mega-residential_address"
                                       name="residential_address" placeholder="Enter your residential address.."
                                       type="text" value="{{old('residential_address')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-contactaddress">Contact Address</label>
                                <input class="form-control form-control-lg" id="mega-contactaddress"
                                       name="contact_address"
                                       placeholder="Enter your Contact Address" type="text"
                                       value="{{old('contact_address')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-idcardtype">ID Card Type</label>
                                <input class="form-control form-control-lg" id="mega-idcardtype"
                                       name="id_card_type" placeholder="Enter ID Card Type.." type="text"
                                       value="{{old('id_card_type')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-idcardno">ID Card No</label>
                                <input class="form-control form-control-lg" id="mega-idcardno"
                                       name="id_card_no"
                                       placeholder="Enter your ID Card No.." type="text" value="{{old('id_card_no')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-bvn">BVN</label>
                                <input class="form-control form-control-lg" id="mega-bvn"
                                       name="bvn"
                                       placeholder="Enter your Bank Verification Number" type="text"
                                       value="{{old('bvn')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-occupation">Occupation</label>
                                <input class="form-control form-control-lg" id="mega-occupation"
                                       name="occupation"
                                       placeholder="Enter your Occupation" type="text" value="{{old('occupation')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-nok">Next of kin</label>
                                <input class="form-control form-control-lg" id="mega-nok"
                                       name="next_of_kin" placeholder="Enter Next of Kin.." type="text"
                                       value="{{old('next_of_kin')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-nokrelationship">NOK Relationship</label>
                                <input class="form-control form-control-lg" id="mega-nokrelationship"
                                       name="nok_relationship"
                                       placeholder="Enter Next on Kin Relationship.." type="text"
                                       value="{{old('nok_relationship')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-nokcontactaddress">NOK Contact Address</label>
                                <input class="form-control form-control-lg" id="mega-nokcontactaddress"
                                       name="nok_contact_address"
                                       placeholder="Enter Next of Kin Contact Address" type="text"
                                       value="{{old('nok_contact_address')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-6">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-nokdob">NOK Date of birth</label>
                                <input class="form-control form-control-lg" id="mega-nokdob"
                                       name="nok_dob"
                                       placeholder="dd/mm/yyyy" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="form-group row">
                            <label class="col-12">NOK Gender</label>
                            <div class="col-12">
                                <label class="css-control css-control-primary css-radio mr-10">
                                    <input class="css-control-input" name="nok_gender" type="radio">
                                    <span class="css-control-indicator"></span> Female
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="nok_gender" type="radio">
                                    <span class="css-control-indicator"></span> Male
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-nokphonenum">NOK Phone Number</label>
                                <input class="form-control form-control-lg" id="mega-nokphonenum"
                                       name="nok_phone_number"
                                       placeholder="Enter Next of Kin Phone Number.." type="text"
                                       value="{{old('nok_phone_number')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-nokemail">NOK Email</label>
                                <input class="form-control form-control-lg" id="mega-nokemail"
                                       name="nok_email"
                                       placeholder="Enter your Next of Kin Email" type="text"
                                       value="{{old('nok_email')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-spousename">Spouse Name</label>
                                <input class="form-control form-control-lg" id="mega-spousename"
                                       name="spouse_name" placeholder="Enter spouse name.." type="text"
                                       value="{{old('spouse_name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-mothermaidenname">Mother Maiden Name</label>
                                <input class="form-control form-control-lg" id="mega_mothermaidenname"
                                       name="mother_maiden_name"
                                       placeholder="Enter mother maiden name.." type="text"
                                       value="{{old('mother_maiden_name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-officephoneno">Office Phone No</label>
                                <input class="form-control form-control-lg" id="mega-officephoneno"
                                       name="office_phone_no"
                                       placeholder="Enter Office Phone No.." type="text"
                                       value="{{old('office_phone_no')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="mega-landmark">Landmark</label>
                                <input class="form-control form-control-lg" id="mega-landmark"
                                       name="landmark"
                                       placeholder="Enter Office Phone No.." type="text" value="{{old('landmark')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group row">
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
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="formImage"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group row">
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
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="signatureImage"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group row">
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
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="utilityImage"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group row">
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
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="idcardImage"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group row">
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
                            {{--<input type="file" name="file" id="file" />--}}
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div id="passportImage"></div>
                    </div>
                </div>
                <div class="form-group row">
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
    <script>
        @if(isset($message))
        alert('{{$message}}');
        @endif
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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

        /*var x = document.getElementById("user-form");
        var txt = "";
        var i;
        for (i = 0; i < x.length; i++) {
            txt = txt + x.elements[i].getAttribute('name') + "<br>";
        }
        document.getElementById("demo").innerHTML = txt;*/

    </script>
@endsection