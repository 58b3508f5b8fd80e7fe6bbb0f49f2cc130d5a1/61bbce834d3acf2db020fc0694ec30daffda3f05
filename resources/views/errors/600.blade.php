@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.error')
@section('title', '404 - Page not found')
@section('content')

    <div class="display-3 text-pulse">
        <i class="fa fa-ban"></i> 600
    </div>
    <h1 class="h2 font-w700 mt-30 mb-10">Oops.. You just found an error page..</h1>
    <h2 class="h3 font-w400 text-muted mb-50">We are sorry, you do not have access to view this page..</h2>

@endsection