@extends('layouts.admin')
@section('title', title_case($action).' users')
@section('content')
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/admin')}}">Admin</a>
        <span class="breadcrumb-item active">View {{title_case($action)}} Users</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Users
                <small>Viewing {{title_case($action)}}</small>
            </h3>
        </div>
        <div class="col-12 col-lg-4 col-md-6 col-xs-8" style="float: none; margin: auto;">
            <div class="block-header block-header-default">
                <h3 class="block-title text-center"><i class="si si-fire"></i> PNM to User <i class="si si-user"></i>
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form action="http://127.0.0.1:8000/transaction/pnm/transfer" method="post" class="text-center">
                    <input name="_token" value="YhMRJ5749NSM7bvQvhojJg3uBJSR8JhmVCRkZGIY" type="hidden">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-material form-material-lg form-material-info floating">
                                <input class="form-control form-control-lg text-center" id="pnm" name="pnm" required=""
                                       type="text">
                                <label for="pnm"><i class="si si-fire"></i> Enter Amount</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-material form-material-lg form-material-success floating">
                                <input class="form-control form-control-lg text-center" id="wallet" name="wallet"
                                       required="" type="text">
                                <label for="wallet"><i class="si si-user"></i> Enter Wallet ID</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-material form-material-lg form-material-success floating">
                                <input class="form-control form-control-lg text-center" id="pin" name="pin" required=""
                                       type="password">
                                <label for="pin"><i class="si si-lock"></i> Enter Pin</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button style="overflow: hidden; position: relative; z-index: 1;" type="button"
                                    class="btn btn-outline-secondary min-width-125 js-click-ripple-enabled"
                                    data-toggle="click-ripple"><span
                                        style="height: 125px; width: 125px; top: -44.5667px; left: 13.1667px;"
                                        class="click-ripple animate"></span>Transfer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection