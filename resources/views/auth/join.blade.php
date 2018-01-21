@extends('layouts.auth')
@section('title', 'Join')
@section('content')
    <div class="py-30 px-5 text-center">
        <a class="link-effect font-w700" href="index-2.html">
            <i class="si si-fire"></i>
            <span class="font-size-xl text-primary-dark">{{config('app.name')}}</span>
        </a>
        <h1 class="h2 font-w700 mt-50 mb-10">Create New Account</h1>
        <h2 class="h4 font-w400 text-muted mb-0">Please enter the details you were given</h2>
    </div>
    <div class="row justify-content-center px-5">
        <div class="col-sm-8 col-md-6 col-xl-4">
            <form class="js-validation-signup" action="{{url('/register')}}"
                  method="post">
                {{csrf_field()}}
                <div class="form-group{{ $errors->has('account') ? ' is-invalid' : '' }} row">
                    <div class="col-12">
                        <div class="form-material floating">
                            <input class="form-control" id="account" name="account" type="text" value="{{old('account')}}">
                            <label for="account">Enter Account Number</label>
                        </div>
                        @if ($errors->has('account'))
                            <span class="invalid-feedback">
                                        {{ $errors->first('account') }}
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('wallet') ? ' is-invalid' : '' }} row">
                    <div class="col-12">
                        <div class="form-material floating">
                            <input class="form-control" id="wallet" name="wallet" type="text" value="{{old('wallet')}}">
                            <label for="wallet">Any 6 Characters of Wallet Address</label>
                        </div>
                        @if ($errors->has('wallet'))
                            <span class="invalid-feedback">
                                        {{ $errors->first('wallet') }}
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row gutters-tiny">
                    <div class="col-12 mb-10">
                        <button type="submit" class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-success">
                            <i class="si si-user-follow mr-10"></i> Join
                        </button>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="#" data-toggle="modal"
                           data-target="#modal-terms">
                            <i class="si si-book-open text-muted mr-10"></i> Read Terms
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="{{url('/login')}}">
                            <i class="si si-login text-muted mr-10"></i> Sign In
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="modal-terms"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-slidedown" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Terms &amp; Conditions</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat
                            magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna
                            molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero
                            condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat
                            nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas
                            vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi
                            suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh
                            orci.</p>
                        <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat
                            magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna
                            molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero
                            condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat
                            nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas
                            vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi
                            suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh
                            orci.</p>
                        <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat
                            magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna
                            molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero
                            condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat
                            nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas
                            vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi
                            suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh
                            orci.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                        <i class="fa fa-check"></i> Perfect
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection