@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div class="bg-gd-dusk">
        <div class="hero-static content content-full bg-white js-appear-enabled animated fadeIn" data-toggle="appear">
            <div class="py-30 px-5 text-center">
                <a class="link-effect font-w700" href="index-2.html">
                    <i class="si si-fire"></i>
                    <span class="font-size-xl text-primary-dark">{{config('app.name')}}</span>
                </a>
                <h1 class="h2 font-w700 mt-50 mb-10">Welcome to Your Dashboard</h1>
                <h2 class="h4 font-w400 text-muted mb-0">Please sign in</h2>
            </div>
            <div class="row justify-content-center px-5">
                <div class="col-sm-8 col-md-6 col-xl-4">
                    <form class="js-validation-signin" action="{{ route('login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input class="form-control" id="login-username" name="name" type="text" required>
                                    <label for="login-username">Username</label>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }} row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input class="form-control" id="login-password" name="password"
                                           type="password" required>
                                    <label for="login-password">Password</label>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-12">
                                <label class="css-control css-control-primary css-checkbox">
                                    <input class="css-control-input" id="remember" name="remember"  {{ old('remember') ? 'checked' : '' }} type="checkbox">
                                    <span class="css-control-indicator"></span>
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <div class="form-group row gutters-tiny">
                            <div class="col-12 mb-10">
                                <button type="submit"
                                        class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-primary">
                                    <i class="si si-login mr-10"></i> Sign In
                                </button>
                            </div>
                            <div class="col-sm-6 mb-5">
                                <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary"
                                   href="{{ url('/join') }}">
                                    <i class="fa fa-plus text-muted mr-5"></i> New Account
                                </a>
                            </div>
                            <div class="col-sm-6 mb-5">
                                <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary"
                                   href="{{ route('password.request') }}">
                                    <i class="fa fa-warning text-muted mr-5"></i> Forgot password
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
