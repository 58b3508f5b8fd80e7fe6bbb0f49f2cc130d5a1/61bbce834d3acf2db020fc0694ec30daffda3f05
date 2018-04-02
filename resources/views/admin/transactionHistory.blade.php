@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.admin')
@section('title', 'Transactions History')
@section('content')

    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/admin')}}">Admin</a>
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
                <p style="font-size:1.5em;">Your <strong>Transactions</strong></p>
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
                                $status ='pending';
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
                    <p>Sorry, but there are no transactions to display from the database.</p>
                </div>
            </div>
    @endif

@endsection
