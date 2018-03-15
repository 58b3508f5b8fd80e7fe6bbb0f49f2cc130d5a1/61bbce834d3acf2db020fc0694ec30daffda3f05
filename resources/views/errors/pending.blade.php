@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.error')
@section('title', 'Account Suspended')
@section('content')
    <div class="display-3 text-pulse">
        <i class="fa fa-ban"></i> 600
    </div>
    <h1 class="h2 font-w700 mt-30 mb-10">Oops.. You just found an error page..</h1>
    <h2 class="h3 font-w400 text-muted mb-50">Your account is suspended. You cannot view this page..</h2>
    <a class="btn btn-hero btn-rounded btn-alt-secondary" href="{{ route('logout') }}"
       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out mr-10"></i> Logout
    </a>
@endsection