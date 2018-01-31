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
                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

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

                        <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input id="password" type="password" class="form-control" name="password"
                                           value="" required autofocus>
                                    <label for="password"> Password</label>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input id="password" type="password" class="form-control"
                                           name="password_confirmation"
                                           value="" required autofocus>
                                    <label for="password"> Password</label>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            {{config('mail.username')}}<br>
                            {{config('mail.password')}}
                            {{config('mail.host')}}<br>
                            {{config('mail.driver')}}<br>
                            {{config('mail.encryption')}}<br>
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

