@php
    $data = session('data');
@endphp

@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.admin')
=======
@extends('layouts.admin')

@section('title', title_case($action))
@section('content')
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/admin')}}">Admin</a>
        <span class="breadcrumb-item active">View {{title_case($action)}}</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Users
                <small>Viewing {{title_case($action)}}</small>
            </h3>
        </div>
        @if(isset($data['message']))
            <div class="block-content">
                <div class="block">
                    <div class="alert alert-{{$data['alert']}}">
                        <p style="font-size:1.5rem; font-weight: bold;">{{$data['message']}}</p>
                    </div>
                </div>
            </div>
        @endif
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
                <form action="{{url('/admin/add/pnm')}}" method="post" class="text-center">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-material form-material-lg form-material-info floating">
                                <input class="form-control form-control-lg text-center" id="pnm" name="amount" required=""
                                       type="text">
                                <label for="pnm"><i class="si si-fire"></i> Enter Amount</label>
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
                            <button style="overflow: hidden; position: relative; z-index: 1;" type="submit"
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
@section('scripts')
    <script>
        @if(isset($data['message']))
        alert('{{$data['message']}}');
        @endif
    </script>
@endsection