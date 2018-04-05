@if(isset($users) && sizeof($users)>0)
    @php
        $results=$users;
    @endphp
    @if(isset($results['registered']) && sizeof($results['registered'])>0)
        <div class="block-header block-header-default">
            <h3 class="block-title">Users
                <small>Viewing Registered</small>
            </h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table id="general-table" class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>S/No.</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Wallet ID</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach($results['registered'] as $user)
                        @php
                            $i++;
                         if($user->status=='pending'||$user->status =='unregistered')
                            $badge ="badge-warning";
                        elseif ($user->status=='active'||$user->status =='registered')
                            $badge ="badge-success";
                        elseif ($user->status=='blocked')
                            $badge ="badge-danger";
                        @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td class="font-w600">{{$user->first_name." ".$user->last_name}}
                            </td>
                            <td><a href="javascript:void(0)">{{$user->name}}</a></td>
                            <td><a href="javascript:void(0)" class="js-tooltip-enabled" data-toggle="tooltip"
                                   data-original-title="Click me to Copy" title="Click me to copy"
                                   onclick="copyToClipboard('#wallet')"><span id="wallet">{{$user->wallet_id}}</span>
                                </a>
                            </td>

                            <td>
                                <span class="badge {{$badge}}">{{$user->status}}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endif
@if(isset($results['unregistered']) && sizeof($results['unregistered'])>0)
    <div class="block-header block-header-default">
        <h3 class="block-title">Users
            <small>Viewing</small>
        </h3>
    </div>
    <div class="block-content">
        <div class="table-responsive">
            <table id="general-table" class="table table-striped table-vcenter">
                <thead>
                <tr>
                    <th>S/No.</th>
                    <th>Name</th>
                    <th>Wallet Address</th>
                    <th>Private Key</th>
                    <th>Account No.</th>
                    <th>Status</th>
                    {{--@if(Auth::user()->access_level>=3)
                        <th class="text-center">Actions</th>
                    @endif--}}
                </tr>
                </thead>
                <tbody>
                @php
                    $i=0;
                @endphp
                @foreach($results['unregistered'] as $user)
                    @php
                        $i++;
                     if($user->status=='pending'||$user->status =='unregistered')
                        $badge ="badge-warning";
                    elseif ($user->status=='active'||$user->status =='registered')
                        $badge ="badge-success";
                    elseif ($user->status=='blocked')
                        $badge ="badge-danger";
                    @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td class="font-w600">{{$user->first_name." ". $user->other_name ." ".$user->last_name}}
                        </td>

                        <td>
                            <a href="javascript:void(0)">{{$user->wallet_address}}</a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="js-tooltip-enabled" data-toggle="tooltip"
                               data-original-title="Click me to Copy" title="Click me to copy"
                               onclick="copyToClipboard('#wallet')"><span
                                        id="wallet">{{$user->private_key}}</span></a>
                        </td>
                        <td>
                            <span>{{$user->account_number}}</span>
                        </td>
                        <td>
                            <span class="badge {{$badge}}">{{$user->status}}</span>
                        </td>
                        @if(Auth::user()->access_level>=3)
                            <td class="text-center">
                                <div class="btn-group">
                                    <button data-original-title="Edit" type="button"
                                            class="btn btn-sm btn-alt-primary"
                                            data-toggle="tooltip"
                                            title="Edit {{$user->first_name}}"
                                            onclick="viewEditUser({{($user->id+9407)}},'{{$action}}')">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    @if(!in_array($action,['registered','unregistered']))
                                        @if($user->status=='blocked' || $user->status=='pending')
                                            <button data-original-title="Delete" type="button"
                                                    class="btn btn-sm btn-alt-success"
                                                    data-toggle="tooltip"
                                                    title="Approve {{$user->first_name}}"
                                                    onclick="verifyUser({{($user->id+1107)}}, 'approve')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif
                                        @if($user->status=='active')
                                            <button data-original-title="Delete" type="button"
                                                    class="btn btn-sm btn-alt-danger"
                                                    data-toggle="tooltip"
                                                    title="Block {{$user->first_name}}"
                                                    onclick="verifyUser({{($user->id+1107)}}, 'block')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@if(isset($transactions) && sizeof($transactions)>0)
    <div class="block-header block-header-default">
        <h3 class="block-title">Transactions
            <small>Viewing Transactions</small>
        </h3>
    </div>
    <div class="block-content">
        <div class="table-responsive">
            <table id="general-table" class="table table-striped table-vcenter">
                <thead>
                <tr>
                    <th class="text-center">S/No.</th>
                    <th class="text-center">Transaction ID</th>
                    <th>PNM</th>
                    <th>NGN</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    @if (Auth::user()->access_level >= 4)
                        <th>Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($transactions as $transaction)
                    @php
                        $trans1 = substr($transaction->transaction_id,0,6 );
                        $trans2 = substr($transaction->transaction_id,-6);
                        $to1 = substr($transaction->to,0,6 );
                        $to2 = substr($transaction->to,-6);
                        $from1 = substr($transaction->from,0,6 );
                        $from2 = substr($transaction->from,-6);
                        if($transaction->status=='successful')
                            $status ='success';
                        elseif($transaction->status=='failed')
                            $status ='danger';
                        else
                            $status ='warning';
                    @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td>
                            @if (strlen($transaction->transaction_id) > 15)
                                {{"$trans1......$trans2"}}
                            @else
                                {{$transaction->transaction_id}}
                            @endif
                        </td>
                        <td>{{$transaction->amount/100000}}</td>
                        <td>{{$transaction->amount/100000 * $value}}</td>
                        <td>
                            @if (strlen($transaction->from) > 15)
                                {{"$from1......$from2"}}
                            @else
                                {{$transaction->from}}
                            @endif
                        </td>
                        <td>
                            @if (strlen($transaction->to) > 15)
                                {{"$to1......$to2"}}
                            @else
                                {{$transaction->to}}
                            @endif
                        </td>
                        <td>{{$transaction->type}}</td>
                        <td><span class="badge badge-sm badge-{{$status}}">{{$transaction->status}}</span></td>
                        <td>{{date('d-m-Y',strtotime($transaction->created_at))}}</td>
                        @if (Auth::user()->access_level >= 4)
                            <td class="text-center">
                                <div class="btn-group">
                                    @if($transaction->status=='failed' || in_array($transaction->status, ['pending','requested']) )
                                        <button data-original-title="approve" type="button"
                                                class="btn btn-sm btn-alt-success"
                                                data-toggle="tooltip"
                                                title="Approve"
                                                onclick="verifyTransaction({{($transaction->id+1127)}}, 'approve')">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    @endif
                                    @if($transaction->status=='successful' || in_array($transaction->status, ['pending','requested']))
                                        <button data-original-title="Revoke" type="button"
                                                class="btn btn-sm btn-alt-danger"
                                                data-toggle="tooltip"
                                                title="Revoke"
                                                onclick="verifyTransaction({{($transaction->id+1127)}}, 'revoke')">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                    @php $i++; @endphp
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@if(!(isset($transactions) && sizeof($transactions)>0) && !(isset($users) && sizeof($users)>0))
    <div class="col-sm-12 col-lg-12">
        <div class="block p-3">
            <div class="alert alert-warning">
                <h2>No data to display</h2>
                <p>Sorry, but there are no data to display from the database.</p>
            </div>
        </div>
    </div>
@endif
