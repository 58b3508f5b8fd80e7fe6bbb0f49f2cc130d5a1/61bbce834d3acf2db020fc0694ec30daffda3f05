@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.error')
@section('title', '404 - Page not found')
@section('content')

    <div class="display-3 text-danger">
        <i class="fa fa-warning"></i> 404
    </div>
    <h1 class="h2 font-w700 mt-30 mb-10">Oops.. You just found an error page..</h1>
    <h2 class="h3 font-w400 text-muted mb-50">We are sorry but the page you are looking for was not found..</h2>

    @endsection