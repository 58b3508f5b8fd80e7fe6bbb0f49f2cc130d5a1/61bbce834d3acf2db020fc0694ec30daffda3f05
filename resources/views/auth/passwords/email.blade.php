@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
    <div class="bg-gd-dusk">
        <div class="hero-static content content-full bg-white js-appear-enabled animated fadeIn" data-toggle="appear">
            <div class="py-30 px-5 text-center">
                <a class="link-effect font-w700" href="index-2.html">
                    <i class="si si-fire"></i>
                    <span class="font-size-xl text-primary-dark">{{config('app.name')}}</span>
                </a>
                <h1 class="h2 font-w700 mt-50 mb-10">Need to reset your password?</h1>
                <h2 class="h4 font-w400 text-muted mb-0">Enter your email</h2>
            </div>
            <div class="row justify-content-center px-5">
                <div class="col-sm-8 col-md-6 col-xl-4">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ $email or old('email') }}" required autofocus>
                                    <label for="email">E-mail Address</label>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row gutters-tiny">
                            <div class="col-12 mb-10">
                                <button type="submit"
                                        class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-primary">
                                    <i class="si si-login mr-10"></i> Send reset link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection