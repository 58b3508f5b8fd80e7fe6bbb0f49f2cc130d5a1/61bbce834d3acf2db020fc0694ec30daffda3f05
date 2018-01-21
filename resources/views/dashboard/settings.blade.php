@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    <div id="page-content">
        <div class="content-header">
            <div class="header-section">
                <h1><i class="fa fa-eye"></i> Transactions<br>
                    <small>Make a transfer from Wallet to Card</small>
                </h1>
            </div>
        </div>
        <ul class="breadcrumb breadcrumb-top">
            <li>Transactions</li>
            <li>Transfer</li>
            <li><a href="{{url('/transactions/card')}}">Wallet to card</a></li>
        </ul>
        <div class="block">
            @if(isset($success) && isset($message))
                <div class="alert alert-success animation-hatch"><h3>{{$success}}</h3>
                    <p>{{$message}}</p></div>
            @elseif(isset($failed) && isset($message))
                    <div class="alert alert-danger animation-hatch"><h3>{{$failed}}</h3>
                        <p>{{$message}}</p></div>
            @endif
            <div>
                <form action="{{url('/settings/profile')}}" method="post" enctype="multipart/form-data"
                      class="form-horizontal form-bordered">
                    {{csrf_field()}}
                    <fieldset>
                        <legend>Vital Info</legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Referral ID</label>
                            <div class="col-md-8">
                                <a class="form-control-static" href="javascript:void(0)"
                                   onclick="copyToClipboard('#referral-link')"><i class="fa fa-link"></i>
                                    <span id="referral-link">{{url('register')}}
                                        /{{Auth::user()->user_id}}</span></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user-settings-email">Email</label>
                            <div class="col-md-8">
                                <p class="form-control-static">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="referrer">Referrer ID</label>
                            <div class="col-md-8">
                                <p class="form-control-static">{{ Auth::user()->referrer_id }}</p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Personal info</legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="fname">First Name</label>
                            <div class="col-md-8">
                                <input type="text" id="fname" name="fname"
                                       class="form-control" placeholder="Enter your first name" value="{{Auth::user()
                                       ->first_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="fname">Last Name</label>
                            <div class="col-md-8">
                                <input type="text" id="lname" name="lname"
                                       class="form-control" placeholder="Enter your last name" value="{{Auth::user()
                                       ->last_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="pnumber">Phone Number</label>
                            <div class="col-md-8">
                                <input type="text" id="pnumber" name="pnumber"
                                       class="form-control" placeholder="Enter your phone number" value="{{Auth::user()
                                       ->phone_number}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="maddress">Mailing Address</label>
                            <div class="col-md-8">
                                <input type="text" id="maddress" name="maddress"
                                       class="form-control" placeholder="Enter your mailing address" value="{{Auth::user()
                                       ->mailing_address}}">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="saddress">Street address</label>
                            <div class="col-md-8">
                                <input type="text" id="saddress" name="saddress"
                                       class="form-control" placeholder="Enter your street address"
                                       value="{{Auth::user()
                                       ->street_address}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="country">Country</label>
                            <div class="col-md-8">
                                <input type="text" id="country" name="country"
                                       class="form-control" placeholder="Enter your country" value="{{Auth::user()
                                       ->country}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="city">City</label>
                            <div class="col-md-8">
                                <input type="text" id="city" name="city"
                                       class="form-control" placeholder="Enter your city" value="{{Auth::user()
                                       ->city}}">
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-xs-12 text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <form action="{{url('settings/password')}}" method="post" class="form-horizontal form-bordered">
                    {{csrf_field()}}
                    <fieldset>
                        <legend>Password Update</legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="current-password">Current Password</label>
                            <div class="col-md-8">
                                <input type="password" id="current-password" name="current_password"
                                       class="form-control" placeholder="Enter your current password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="new-password">New Password</label>
                            <div class="col-md-8">
                                <input type="password" id="new-password" name="new_password" required
                                       class="form-control" placeholder="Please choose a complex one..">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="confirm-password">Confirm New
                                Password</label>
                            <div class="col-md-8">
                                <input type="password" id="confirm-password" name="confirm_password" required
                                       class="form-control" placeholder="..and confirm it!">
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-xs-12 text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection