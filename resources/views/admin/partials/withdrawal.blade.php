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
                    <td>PNM</td>
                @elseif($action == 'ngn')
                    <td>NGN</td>
                @endif
                <th>From</th>
                <th>To</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
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
                        <a href="{{url('withdrawal/'.$withdrawal->transaction_id)}}">{{$withdrawal->transaction_id}}</a>
                    </td>
                    @if($action == 'pnm')
                        <td>{{$withdrawal->amount}}</td>
                    @elseif($action == 'ngn')
                        <td>{{$withdrawal->amount * $withdrawal->value}}</td>
                    @endif
                    <td>{{$withdrawal->from}}</td>
                    <td>{{$withdrawal->to}}</td>
                    <td>{{$withdrawal->type}}</td>
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
                @php $i++; @endphp
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