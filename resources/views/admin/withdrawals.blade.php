@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.admin')
@section('title', strtoupper($action). ' withdrawals')
@section('content')

    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/admin')}}">Admin</a>
        <span class="breadcrumb-item active"></span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{title_case($grade)}} Withdrawals
                <small>{{strtoupper($action)}}</small>
            </h3>
        </div>
        <div id="withdrawals">
            @include('admin.partials.withdrawal')
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function verifyWithdrawal(id, action) {
            var data = {
                'id': id,
                'action': action,
                'type': '{{$action}}',
                'for': '{{$type}}',
                'grade': '{{$grade}}'
            };
            $.post('/admin/transactions/withdrawal', data, function (result) {

                alert(result.message);

                $('#withdrawals').fadeOut(300);
                $('#withdrawals').html(result.html);
                $('#withdrawals').fadeIn(300);
            }).fail(function () {
                alert('Sorry, an error occurred');
            });
        }
    </script>
@endsection