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
        <div class="block-content">
            @if(isset($users) && sizeof($users)>0)
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th>S/No.</th>
                            <th>Name</th>
                            <th>@if($action=='registered' || $action=='unregistered')Wallet Address @else
                                    Username @endif</th>
                            <th>@if($action=='registered' || $action=='unregistered')Private Key @else Wallet
                                ID @endif</th>
                            <th>Account No.</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach($users as $user)
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
                                @if(isset($user->wallet_address))
                                    <td><a href="{{url('admin/view/user/'.$user->wallet_address)}}">{{$user->name}}</a></td>
                                    <td><a href="{{url('admin/view/user/'.$user->wallet_address)}}">{{$user->wallet_id}}</a>
                                    </td>
                                @elseif(isset($user->wallet_id))
                                    <td><a href="{{url('admin/view/user/'.$user->wallet_id)}}">{{$user->name}}</a></td>
                                    <td><a href="{{url('admin/view/user/'.$user->wallet_id)}}">{{$user->wallet_id}}</a>
                                    </td>
                                @endif
                                <td>{{$user->account_number}}</td>
                                <td>
                                    <span class="badge {{$badge}}">{{$user->status}}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button data-original-title="Edit" type="button"
                                                class="btn btn-sm btn-alt-primary"
                                                data-toggle="tooltip"
                                                title="Edit {{$user->first_name}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button data-original-title="Delete" type="button"
                                                class="btn btn-sm btn-alt-danger"
                                                data-toggle="tooltip"
                                                title="Block {{$user->first_name}}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="col-sm-12 col-lg-12">
                    <div class="block">
                        <div class="alert alert-warning">
                            <h2>No data to display</h2>
                            <p>Sorry, but there are no transactions to display from the database.</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection