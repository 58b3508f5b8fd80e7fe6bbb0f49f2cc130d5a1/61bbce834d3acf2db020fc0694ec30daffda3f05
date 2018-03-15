@if(sizeof($withdrawals)>0)

    <div class="block-title">
        <p style="font-size:1.5em;">Your <strong>Withdrawals</strong></p>
    </div>
    <div class="table-responsive">
        <table id="general-table" class="table table-striped table-vcenter">
            <thead>
            <tr>
                <th class="text-center">S/No.</th>
                <th class="text-center">Withdrawal ID</th>
                @if($action == 'pnm')
                    <th>PNM</th>
                @elseif($action == 'ngn')
                    <th>NGN</th>
                @endif
                <th>From</th>
                <th>To</th>
                <th>Type</th>
                @if($action == 'pnm')
                    <th>Wallet Address</th>
                @elseif($action == 'ngn')
                    <th>Bank Name</th>
                    <th>Acc. Number</th>
                @endif
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $i=0; @endphp
            @foreach($withdrawals as $withdrawal)
                @php
                    $i++;
                 if($withdrawal->status=='pending'||$withdrawal->status =='requested')
                    $badge ="badge-warning";
                elseif ($withdrawal->status=='successful')
                    $badge ="badge-success";
                elseif ($withdrawal->status=='failed')
                    $badge ="badge-danger";
                @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>
                        <a href="javascript:void (0)">{{$withdrawal->transaction_id}}</a>
                    </td>
                    @if($action == 'pnm')
                        <td>{{$withdrawal->amount/100}}</td>
                    @elseif($action == 'ngn')
                        <td>{{$withdrawal->amount/100 * $withdrawal->value}}</td>
                    @endif
                    <td>{{$withdrawal->from}}</td>
                    <td>{{$withdrawal->to}}</td>
                    <td>{{$withdrawal->type}}</td>
                    @if($action == 'pnm')
                        <td>{{$withdrawal->wallet_address}}</td>
                    @elseif($action == 'ngn')
                        <td>{{$withdrawal->bank_name}}</td>
                        <td>{{$withdrawal->bank_acc_no}}</td>
                    @endif
                    <td class="text-center">
                        <span class="badge {{$badge}}">{{$withdrawal->status}}</span>
                    </td>
                    <td>{{date('d/m/Y',strtotime($withdrawal->created_at))}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            @if($withdrawal->status=='failed' || in_array($withdrawal->status, ['pending','requested']) )
                                <button data-original-title="approve" type="button"
                                        class="btn btn-sm btn-alt-success"
                                        data-toggle="tooltip"
                                        title="Approve"
                                        onclick="verifyWithdrawal({{($withdrawal->id+1127)}}, 'approve')">
                                    <i class="fa fa-check"></i>
                                </button>
                            @endif
                            @if($withdrawal->status=='successful' || in_array($withdrawal->status, ['pending','requested']))
                                <button data-original-title="Revoke" type="button"
                                        class="btn btn-sm btn-alt-danger"
                                        data-toggle="tooltip"
                                        title="Revoke" onclick="verifyWithdrawal({{($withdrawal->id+1127)}}, 'revoke')">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="block">
        <div class="alert alert-warning">
            <h2>No data to display</h2>
            <p>Sorry, but there are no withdrawals to display from the database.</p>
        </div>
    </div>
@endif