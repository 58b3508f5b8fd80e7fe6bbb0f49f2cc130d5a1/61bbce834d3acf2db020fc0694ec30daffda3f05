@php $data = session('data'); @endphp @php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.app')
@section('title', $title)
@section('content')

    <div class="content">
        <h2 class="content-heading">Transaction
            <small>{!! $title!!}</small>
        </h2>
        <div class="block">
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
                    <h3 class="block-title text-center">{!! $heading !!}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option">
                            <i class="si si-wrench"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form action='{{url("/transaction/$for/$action")}}' method="post" class="text-center">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-material form-material-lg form-material-info floating">
                                    <input class="form-control form-control-lg text-center" id="pnm" name="amount"
                                           type="text" required>
                                    <label for="pnm"><i class="si si-fire"></i> Enter Amount</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-material form-material-lg form-material-success floating">
                                    <input class="form-control form-control-lg text-center" id="wallet" name="wallet"
                                           type="text" required>
                                    <label for="wallet"><i class ="si si-user"></i> Enter Wallet ID</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-material form-material-lg form-material-success floating">
                                    <input class="form-control form-control-lg text-center" id="pin" name="pin"
                                           type="password" required>
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
    </div>
    <div id="modal-transaction" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title">Wallet <i class="fa fa-angle-double-right text-danger"></i> Card</h2>
                </div>
                <div class="modal-body">
                    <form id="transaction-confirm" action="{{url('/transactions/card')}}" method="post">
                        {{csrf_field()}}
                        <fieldset>
                            <legend>Confirm your transaction</legend>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Wallet balance</label>
                                <div class="col-md-8">
                                    <p class="form-control-static">$50</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Card balance</label>
                                <div class="col-md-8">
                                    <p class="form-control-static">$0</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Transfer Amount</label>
                                <div class="col-md-8">
                                    <p class="form-control-static">$50</p>
                                </div>
                            </div>
                            <input type="hidden" id="amount" name="amount" required>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="user-settings-password">Enter
                                    Password</label>
                                <div class="col-md-8">
                                    <input type="password" id="password" name="password"
                                           class="form-control" placeholder="Your password" required>
                                </div>
                            </div>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Transfer</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function confirmTransaction() {
            var amount = $('#transfer').val();
            $('#amount').val(amount);
            $('#modal-transaction').modal('show');

        }

        @if(isset($data['message']))
        alert('{{$data['message']}}');
        @endif
    </script>
@endsection