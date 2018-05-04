@php $data = session('data'); @endphp @php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.app')

@section('title', $title)
@section('content')

    <div class="content">
        <h2 class="content-heading">Transaction
            <small>{!! $title!!}</small>
        </h2>
        <div class="row">
            <div class="col-12 col-md-6 col-xs-12">
                <div class="block block-bordered">
                    <div class="block-content">
                        <div class="block">
                            <div class="alert alert-info">
                                <p class="text-center" style="font-size:1.5rem; font-weight: bold;">{{$title}}</p>
                                <p>Please Note:</p>
                                <ul>
                                    <li>This withdrawal might take {{$duration}}.</li>
                                    <li>Your current NGN balance is {{$ngn_balance}} NGN</li>
                                    <li>Your current PNM balance is {{$pnm_balance}} PNM</li>
                                    <li>Maximum withdrawal for this transaction is {{$max_withdrawal}}</li>
                                    <li>Your maximum withdrawal per day is {{$max_daily_withdrawal}}</li>
                                    <li>You will be charged a commission of {{$commission}} PNM for this transaction.
                                    </li>
                                    <li>A message alert will be sent to your phone on every transaction.</li>
                                </ul>
                                <p>Thanks<br>{{config('app.name')}}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xs-12">
                <div class="block block-bordered">
                    <div class="col-12" style="float: none; margin: auto;">
                        <div class="block-header block-header">
                            <h3 class="block-title text-center">{!! $heading !!}</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div>
                        </div>
                        @if(isset($data['message']))
                            <div class="block-content">
                                <div class="block">
                                    <div class="alert alert-{{$data['alert']}} text-center">
                                        <strong>{{$data['message']}}</strong>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="block-content" id="errors" style="display: none;">
                            <div class="block">
                                <div class="alert alert-danger" class="text-center">
                                    <strong id="error"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
                            <form action='{{url("/transaction/$for/$action")}}' method="post" class="text-center">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-4 col-xs-6 form-group" id="today-input">
                                        <div class="form-material">
                                            <input class="form-control" id="today"
                                                   placeholder="Today's Withdrawal" type="text" readonly
                                                   value="{{$today}}">
                                            <label for="material-text">Today</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6 form-group" id="pnm-input">
                                        <div class="form-material form-group">
                                            <input class="form-control" id="new-pnm"
                                                   placeholder="New PNM" type="text" readonly>
                                            <label for="material-text">New PNM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6  form-group" id="ngn-input">
                                        <div class="form-material">
                                            <input class="form-control" id="new-ngn" name="material-text"
                                                   placeholder="New NGN" type="text" readonly>
                                            <label for="material-text">New NGN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="amount-input">
                                    <div class="col-md-12">
                                        <div class="form-material form-material-lg form-material-info floating">
                                            <input class="form-control form-control-lg text-center" id="amount"
                                                   name="amount"
                                                   type="text">
                                            <label for="pnm">@if($for=='pnm')<i class="si si-fire"></i>@else
                                                    &#8358; @endif
                                                Enter Amount</label>
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
                                                id="transferBtn"
                                                class="btn btn-outline-secondary min-width-125 js-click-ripple-enabled"
                                                data-toggle="click-ripple"><span
                                                    style="height: 125px; width: 125px; top: -44.5667px; left: 13.1667px;"
                                                    class="click-ripple animate"></span>Withdraw
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                    <form id="transaction-confirm" action='{{url("/transactions/$for/$action")}}' method="post">
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
                                <label class="col-md-4 control-label" for="password">Enter
                                    Password</label>
                                <div class="col-md-8">
                                    <input type="password" id="password" name="password"
                                           class="form-control" placeholder="Your password" required>
                                </div>
                            </div>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="submit" id="transferBtn" class="btn btn-sm btn-primary">Transfer
                                    </button>
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

        var commision ={{$commission}};
        var ngnBalance ={{$ngn_balance}};
        var pnmBalance ={{$pnm_balance}};
        var newPNM = pnmBalance - commision;
        var today = $('#today').val();
        var maxWithdrawal ={{$max_withdrawal}};
        var maxDailyWithdrawal ={{$max_daily_withdrawal}};
        setInterval(function () {
            var amount = $('#amount').val();
            var newNGN = ngnBalance - amount;
            // drg >> check for pnm availability
            if (newPNM <= 0) {
                $('#pnm-input').attr('class', 'col-md-4 col-xs-6 form-group is-invalid');
                $('#amount-input').attr('class', 'form-group row is-invalid');
                $('#transferBtn').attr('class', 'btn btn-danger min-width-125 js-click-ripple-enabled').text("Can't Withdraw").attr('disabled', '');
                showError('You have insufficient PNM balance');
            }
            // drg >> check for ngn availability
            else if (newNGN <= 0) {
                $('#ngn-input').attr('class', 'col-md-4 col-xs-6 form-group is-invalid');
                $('#amount-input').attr('class', 'form-group row is-invalid');
                $('#transferBtn').attr('class', 'btn btn-danger min-width-125 js-click-ripple-enabled').text("Can't Withdraw").attr('disabled', '');
                showError('You have insufficient NGN balance');
            }
            // drg >> check for daily withdrawal
            else if ((today + amount) > maxDailyWithdrawal) {
                $('#today-input').attr('class', 'col-md-4 col-xs-6 form-group is-invalid');
                $('#amount-input').attr('class', 'form-group row is-invalid');
                $('#transferBtn').attr('class', 'btn btn-danger min-width-125 js-click-ripple-enabled').text("Can't Withdraw").attr('disabled', '');
                showError('You have reached your NGN withdrawal Limit for today');
            }// drg >> check for maximum withdrawal
            else if (amount > maxWithdrawal) {
                $('#amount-input').attr('class', 'form-group row is-invalid');
                $('#transferBtn').attr('class', 'btn btn-danger min-width-125 js-click-ripple-enabled').text("Can't Withdraw").attr('disabled', '');
                showError("You can't withdraw above "+amount+' on a single transaction');
            }
            else {
                $('#ngn-input').attr('class', 'col-md-4 col-xs-6 form-group');
                $('#pnm-input').attr('class', 'col-md-4 col-xs-6 form-group');
                $('#today-input').attr('class', 'col-md-4 col-xs-6 form-group');
                $('#amount-input').attr('class', 'form-group row');
                $('#transferBtn').attr('class', 'btn btn-outline-secondary min-width-125 js-click-ripple-enabled').text('Withdraw').removeAttr('disabled');
                hideError();
            }

            $('#new-pnm').val(newPNM);
            $('#new-ngn').val(newNGN);
        }, 500);

        function showError(message){
            $('#error').text(message);
            $('#errors').fadeIn(1000);
        }

        function hideError(){

            $('#errors').fadeOut(500);
        }

        @if(isset($data['message']))
        alert('{{$data['message']}}');
        @endif
    </script>
@endsection