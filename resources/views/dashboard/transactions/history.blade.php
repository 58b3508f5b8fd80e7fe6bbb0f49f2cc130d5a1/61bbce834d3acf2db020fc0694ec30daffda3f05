@php $data = session('data'); @endphp @extends('layouts.app')
@section('title', 'Transactions History')
@section('content')

    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/home')}}">Home</a>
        <span class="breadcrumb-item active">Transaction History</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Transactions
                <small>History</small>
            </h3>
        </div>
        @if(sizeof($transactions)>0)

                <div class="block-title">
                    <p style = "font-size:1.5em;">Your <strong>Transactions</strong></p>
                </div>
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
                        </tr>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$i}}</td>
                                <td><a href="{{url('transaction/'.$transaction->transaction_id)}}">{{$transaction->transaction_id}}</a></td>
                                <td>{{$transaction->amount}}</td>
                                <td>{{$transaction->amount * $value}}</td>
                                <td>{{$transaction->from}}</td>
                                <td>{{$transaction->to}}</td>
                                <td>{{$transaction->type}}</td>
                                <td>{{$transaction->status}}</td>
                                <td>{{date('d-m-Y',strtotime($transaction->created_at))}}</td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                        </tbody>
                        <tfoot>
                        {{--<tr>
                            <td colspan="6">
                                <div class="btn-group btn-group-sm pull-right">
                                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="tooltip"
                                       title="Settings"><i class="fa fa-cog"></i></a>
                                    <div class="btn-group btn-group-sm dropup">
                                        <a href="javascript:void(0)" class="btn btn-primary pull-right dropdown-toggle"
                                           data-toggle="dropdown"><span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                            <li><a href="javascript:void(0)"><i class="fa fa-print pull-right"></i>
                                                    Print</a></li>
                                            <li class="dropdown-header"><i class="fa fa-share pull-right"></i> Export As
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">.pdf</a>
                                                <a href="javascript:void(0)">.cvs</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="tooltip"
                                       title="Edit Selected"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="tooltip"
                                       title="Delete Selected"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>--}}
                        </tfoot>
                    </table>
                </div>

        @else
            <div class="block">
                <div class="alert alert-warning">
                    <h2>No data to display</h2>
                    <p>Sorry, but there are no transactions to display from the database.</p>
                </div>
            </div>
    @endif

@endsection
