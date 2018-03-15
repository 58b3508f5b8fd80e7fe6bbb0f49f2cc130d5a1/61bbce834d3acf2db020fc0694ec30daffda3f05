@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.app-example')
@section('title','API Clients')

@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>Manage API Clients</strong></div>
        <div class="panel-body">
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
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
    </script>
@endsection