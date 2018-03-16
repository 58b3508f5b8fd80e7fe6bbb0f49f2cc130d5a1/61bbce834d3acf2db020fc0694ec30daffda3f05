@php
    $data = session('data');
@endphp
<<<<<<< HEAD
@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.admin')
=======
@extends('layouts.admin')
>>>>>>> 7482e2606e5a637078a50a4885642a5ae9c274bc
@section('title', 'Join')
@section('content')
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/admin')}}">Admin</a>
        <span class="breadcrumb-item active">Add {{title_case($action)}}</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add
                <small>{{title_case($action)}}</small>
            </h3>
        </div>
        <div class="block-content">
            @if(isset($data['message']))
                <div class="col-sm-12 col-lg-12">
                    <div class="block">
                        <div class="alert alert-{{$data['alert']}}">
                            <h2>{{$data['message']}}</h2>
                        </div>
                    </div>
                </div>
            @endif

            <div class="py-30 px-5 text-center">
                <h1 class="h2 font-w700 mt-50 mb-10">Create New Admin</h1>
                <h2 class="h4 font-w400 text-muted mb-0">Please add your details</h2>
            </div>
            <div class="row justify-content-center px-5">
                <div class="col-sm-8 col-md-6 col-xl-4">
                    <form class="js-validation-signup" action="{{url('/admin/add/admin')}}"
                          method="post">
                        {{csrf_field()}}
                        <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}  row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input class="form-control" id="name" name="name" type="text"
                                           value="{{old('name')}}"
                                           required>
                                    <label for="name">Username</label>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }}  row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input class="form-control" id="first_name" name="first_name" type="text"
                                           value="{{old('first_name')}}"
                                           required>
                                    <label for="first_name">First Name</label>
                                </div>
                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                {{ $errors->first('first_name') }}
                            </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }}  row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input class="form-control" id="last_name" name="last_name" type="text"
                                           value="{{old('last_name')}}"
                                           required>
                                    <label for="name">Last Name</label>
                                </div>
                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                {{ $errors->first('last_name') }}
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input class="form-control" id="email" name="email" type="email"
                                           value="{{old('email')}}"
                                           required>
                                    <label for="email">Email</label>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12">Access Level</label>
                            <div class="col-12">
                                @if(Auth::user()->access_level>=4)
                                    <label class="css-control css-control-primary css-radio mr-10">
                                        <input class="css-control-input" name="level" type="radio" value="{{17*31+3}}">
                                        <span class="css-control-indicator"></span> Senior Admin
                                    </label>
                                @endif
                                <label class="css-control css-control-primary css-radio">
                                    <input class="css-control-input" name="level" type="radio" value="{{17*14+2}}">
                                    <span class="css-control-indicator"></span> Admin
                                </label>
                            </div>
                        </div>
                        <div class="form-group row gutters-tiny">
                            <div class="col-12 mb-10">
                                <button type="submit"
                                        class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-success">
                                    <i class="si si-user-follow mr-10"></i> Add Admin
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    @if(isset($data['message']))
    alert('{{$data['message']}}');
    @endif
</script>