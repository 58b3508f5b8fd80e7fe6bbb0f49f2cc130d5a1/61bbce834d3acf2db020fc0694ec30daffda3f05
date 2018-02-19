@if((isset($results['registered']) || isset($results['unregistered'])) && ((sizeof($results['registered'])>0) ||(sizeof($results['unregistered'])>0)))

    @if(isset($results['registered']) && sizeof($results['registered'])>0)
        <div class="block-header block-header-default">
            <h3 class="block-title">Users
                <small>Viewing Registered</small>
            </h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>S/No.</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Wallet ID</th>
                        <th>Status</th>
                        @if(Auth::user()->access_level>=3)
                            <th class="text-center">Actions</th>
                        @endif
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
                            @if(Auth::user()->access_level>=3)
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button data-original-title="Edit" type="button"
                                                class="btn btn-sm btn-alt-primary"
                                                data-toggle="tooltip"
                                                title="Edit {{$user->first_name}}"
                                                onclick="viewEditUser({{($user->id+9407)}},'{{''}}')">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        {{--@if(!in_array($action,['registered','unregistered']))--}}
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
                                        {{--@endif--}}
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

    @if(isset($results['unregistered']) && sizeof($results['unregistered'])>0)
        <div class="block-header block-header-default">
            <h3 class="block-title">Users
                <small>Viewing</small>
            </h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
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
                                <span class="badge {{$badge}}">{{$user->status}}</span>
                            </td>
                            @if(Auth::user()->access_level>=3)
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button data-original-title="Edit" type="button"
                                                class="btn btn-sm btn-alt-primary"
                                                data-toggle="tooltip"
                                                title="Edit {{$user->first_name}}"
                                                onclick="viewEditUser({{($user->id+9407)}},'{{''}}')">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        {{--@if(!in_array($action,['registered','unregistered']))--}}{{--
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
                                        @endif--}}
                                        {{--@endif--}}
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
@else
    <div class="col-sm-12 col-lg-12">
        <div class="block p-3">
            <div class="alert alert-warning">
                <h2>No data to display</h2>
                <p>Sorry, but there are no users to display from the database.</p>
            </div>
        </div>
    </div>
@endif

