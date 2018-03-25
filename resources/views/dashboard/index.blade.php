@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <div class="content">
        <div class="row gutters-tiny js-appear-enabled animated fadeIn" data-toggle="appear">
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-bag fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000"
                             data-to="1500"><i class="si si-fire"></i>{{$currentValue}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Value per PNM</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-wallet fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600"><span class="js-count-to-enabled" data-toggle="countTo"
                                                                  data-speed="1000" data-to="780"><i
                                        class="si si-fire"></i>{{$transferredPNM/100000}}</span></div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">PNM Transferred</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000"
                             data-to="15"><i class="si si-fire"></i>{{$convertedPNM/100000}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">PNM Converted</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-users fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000"
                             data-to="4252"><i class="si si-fire"></i>{{$withdrawnPNM/100000}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">PNM Withdrawn</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row gutters-tiny">
            <div class="col-6">
                <a class="block block-transparent text-center bg-primary" href="javascript:void(0)">
                    <div class="block-content bg-black-op-5">
                        <p class="font-w600 text-white-op">PNM</p>
                    </div>
                    <div class="block-content">
                        <p class="font-size-h1 text-white">
                            <strong><i class="si si-fire"></i>{{$totalPNM/100000}}</strong>
                        </p>
                    </div>
                </a>
                <div class="row gutters-tiny">
                    <div class="col-12 col-md-4">
                        <a class="block block-rounded block-bordered block-link-shadow text-center"
                           href="{{url('/transaction/pnm/convert')}}">
                            <div class="block-content">
                                <p class="mt-5">
                                    <i class="fa fa-exchange fa-4x text-success"></i>
                                </p>
                                <p class="font-w600">Convert PNM</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a class="block block-rounded block-bordered block-link-shadow text-center"
                           href="{{url('/transaction/pnm/transfer')}}">
                            <div class="block-content">
                                <p class="mt-5">
                                    <i class="fa fa-share fa-4x text-warning"></i>
                                </p>
                                <p class="font-w600">Transfer PNM</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a class="block block-rounded block-bordered block-link-shadow text-center"
                           href="{{url('/transaction/pnm/withdraw')}}">
                            <div class="block-content">
                                <p class="mt-5">
                                    <i class="fa fa-shopping-bag fa-4x text-danger"></i>
                                </p>
                                <p class="font-w600">Withdraw PNM</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <a class="block block-transparent text-center bg-success" href="javascript:void(0)">
                    <div class="block-content bg-black-op-5">
                        <p class="font-w600 text-white-op">NGN</p>
                    </div>
                    <div class="block-content">
                        <p class="font-size-h1 text-white">
                            <strong>&#8358;{{$totalNGN/100000}}</strong>
                        </p>
                    </div>
                </a>
                <div class="row gutters-tiny">
                    <div class="col-12 col-md-6">
                        <a class="block block-rounded block-bordered block-link-shadow text-center"
                           href="{{url('/transaction/ngn/convert')}}">
                            <div class="block-content">
                                <p class="mt-5">
                                    <i class="fa fa-exchange fa-4x text-elegance"></i>
                                </p>
                                <p class="font-w600">Convert NGN</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6">
                        <a class="block block-rounded block-bordered block-link-shadow text-center"
                           href="{{url('/transaction/ngn/withdraw')}}">
                            <div class="block-content">
                                <p class="mt-5">
                                    <i class="fa fa-shopping-bag fa-4x text-primary"></i>
                                </p>
                                <p class="font-w600">Withdraw NGN</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection