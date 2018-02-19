@php
    $data = session('data');
@endphp
@extends('layouts.admin')
@section('title', 'Settings')
@section('content')

    <div class="content">
        <h2 class="content-heading">
            Settings
        </h2>
        <div>
            @if(isset($data['message']))
                <div class="block-content">
                    <div class="block">
                        <div class="alert alert-{{$data['alert']}}">
                            <p style="font-size:1.5rem; font-weight: bold;">{{$data['message']}}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6 pull-left">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title text-center">Change Password</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="si si-wrench"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">

                        <form action="{{url('settings/password')}}" method="post">
                            {{csrf_field()}}
                            <fieldset class="col-md-10 col-md-offset-1">
                                <legend>Password Update</legend>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="form-material form-material-lg form-material-primary floating">
                                            <input class="form-control form-control-lg text-center" id="current"
                                                   name="current_password"
                                                   type="password">
                                            <label for="current"> Current Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="form-material form-material-lg form-material-success floating">
                                            <input class="form-control form-control-lg text-center" id="password"
                                                   name="new_password"
                                                   type="password" required>
                                            <label for="password"><i class="si si-lock"></i> New Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="form-material form-material-lg form-material-danger floating">
                                            <input class="form-control form-control-lg text-center"
                                                   id="confirm-password"
                                                   name="confirm_password"
                                                   type="password" required>
                                            <label for="confirm-password"><i class="si si-lock"></i> Confirm
                                                Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button style="overflow: hidden; position: relative; z-index: 1;"
                                                type="submit"
                                                class="btn btn-outline-secondary min-width-125 js-click-ripple-enabled"
                                                data-toggle="click-ripple"><span
                                                    style="height: 125px; width: 125px; top: -44.5667px; left: 13.1667px;"
                                                    class="click-ripple animate"></span>Update Password
                                        </button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pull-left">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title text-center">Change Pin</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="si si-wrench"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">

                        <form action="{{url('admin/settings/pin')}}" method="post">
                            {{csrf_field()}}
                            <fieldset class="col-md-10 col-md-offset-1">
                                <legend>Pin Update</legend>
                                <form action='{{url("/settings/pin")}}' method="post" class="text-center">
                                    {{csrf_field()}}
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="form-material form-material-lg form-material-primary floating">
                                                <input class="form-control form-control-lg text-center" id="current"
                                                       name="current_pin"
                                                       type="password">
                                                <label for="current"> Current Pin</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="form-material form-material-lg form-material-success floating">
                                                <input class="form-control form-control-lg text-center" id="pin"
                                                       name="new_pin"
                                                       type="password" required>
                                                <label for="pin"><i class="si si-lock"></i> New Pin</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="form-material form-material-lg form-material-danger floating">
                                                <input class="form-control form-control-lg text-center" id="confirm-pin"
                                                       name="confirm_pin"
                                                       type="password" required>
                                                <label for="confirm-pin"><i class="si si-lock"></i> Confirm Pin</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button style="overflow: hidden; position: relative; z-index: 1;"
                                                    type="submit"
                                                    class="btn btn-outline-secondary min-width-125 js-click-ripple-enabled"
                                                    data-toggle="click-ripple"><span
                                                        style="height: 125px; width: 125px; top: -44.5667px; left: 13.1667px;"
                                                        class="click-ripple animate"></span>Update Pin
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            @if(Auth::user()->access_level >= 4)
                <div class="col-md-12 pull-left">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h2 class="block-title text-center">Admin Settings</h2>
                            <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form action="{{url('/admin/settings/app')}}" method="post">
                                {{csrf_field()}}
                                <fieldset class="col-md-12 col-md-offset-1">
                                    <legend class="text-center">Application Settings</legend>
                                    @foreach($settings as $setting)
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="form-material form-material-lg form-material-primary floating">
                                                    <input class="form-control form-control-lg text-center" id="current"
                                                           name="{{$setting->name}}"
                                                           type="text" placeholder="{{$setting->description}}"
                                                           value="{{$setting->value}}" title="{{$setting->title}}">
                                                    <label for="current"> {{$setting->title}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button style="overflow: hidden; position: relative; z-index: 1;"
                                                    type="submit"
                                                    class="btn btn-outline-secondary min-width-125 js-click-ripple-enabled"
                                                    data-toggle="click-ripple"><span
                                                        style="height: 125px; width: 125px; top: -44.5667px; left: 13.1667px;"
                                                        class="click-ripple animate"></span>Update Settings
                                            </button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        @if(isset($data['message']))
        alert('{{$data['message']}}');
        @endif
    </script>
@endsection