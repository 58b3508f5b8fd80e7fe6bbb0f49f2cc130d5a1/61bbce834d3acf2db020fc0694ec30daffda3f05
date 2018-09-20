<div class="block-header block-header-default">
    <h3 class="block-title">Users
        <small>Viewing {{title_case($action)}}</small>
    </h3>
</div>
<div class="block-content">
    @if(isset($users) && sizeof($users)>0)
        <div class="table-responsive">
            <table id="general-table" class="table table-striped table-vcenter" style="width:100% !important;">
                <thead>
                <tr>
                    <th>F. Name</th>
                    <th>L. Name</th>
                    <th>@if($action=='registered' || $action=='unregistered')Wallet Address @else
                            Username @endif</th>
                    <th>@if($action=='registered' || $action=='unregistered')Private Key @else Wallet
                        ID @endif</th>
                    <th>@if($type=='admin') Level @else Account No. @endif</th>
                    <th>Status</th>
                    @if(Auth::user()->access_level>=3)
                        <th class="text-center">Actions</th>
                    @endif
                </tr>
                </thead>
                {{--<tbody>
                @php
                    $i=0;
                @endphp
                @foreach($users as $user)
                    @php
                        if($action=='registered' || $action=='unregistered'){
                            $wallet1 = substr($user->wallet_address,0,6 );
                            $wallet2 = substr($user->wallet_address,-6);
                            $private1 = substr($user->private_key,0,6 );
                            $private2 = substr($user->private_key,-6);
                        }
                        else{
                            $wallet1 = substr($user->wallet_id,0,6 );
                            $wallet2 = substr($user->wallet_id,-6);
                        }
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
                        @if($action=='registered' || $action=='unregistered')
                            <td>
                                <a href="javascript:void(0)">
                                    @if (strlen($user->wallet_address) > 15)
                                        {{"$wallet1......$wallet2"}}
                                    @else
                                        {{$user->wallet_address}}
                                    @endif
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="js-tooltip-enabled" data-toggle="tooltip"
                                   data-original-title="Click me to Copy" title="Click me to copy"
                                   onclick="copyToClipboard('#wallet{{$i}}')">
                                    @if (strlen($user->private_key) > 15)
                                        {{"$private1......$private2"}}

                                    @else
                                        {{$user->private_key}}
                                    @endif
                                </a>
                            </td>
                        @else
                            <td><a href="javascript:void(0)">{{$user->name}}</a></td>
                            <td><a href="javascript:void(0)" class="js-tooltip-enabled" data-toggle="tooltip"
                                   data-original-title="Click me to Copy" title="Click me to copy"
                                   onclick="copyToClipboard('#wallet{{$i}}')">
                                    @if (strlen($user->wallet_id) > 15)
                                        {{"$wallet1......$wallet2"}}
                                        <span id="wallet{{$i}}" style="display:none;">{{$user->wallet_id}}</span>
                                    @else
                                        <span id="wallet{{$i}}">{{$user->wallet_id}}</span>
                                    @endif
                                </a>
                            </td>
                        @endif
                        <td>@if($type=='admin') {{ $user->access_level }} @else {{$user->account_number}} @endif</td>
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
                </tbody>--}}
            </table>
        </div>
    @else
        <div class="col-sm-12 col-lg-12">
            <div class="block">
                <div class="alert alert-warning">
                    <h2>No data to display</h2>
                    <p>Sorry, but there are no users to display from the database.</p>
                </div>
            </div>
        </div>
    @endif

</div>