<div class="row justify-content-center px-5">
    <div class="col-sm-8 col-md-6 col-xl-4">
        <form class="js-validation-signup" action="{{url('/admin/edit/admin'}})}}"
              method="post">
            {{csrf_field()}}
            <input type="hidden" value="{{$id+337}}" name="id">
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
                    <label class="css-control css-control-primary css-radio mr-10">
                        <input class="css-control-input" name="level" type="radio" value="3">
                        <span class="css-control-indicator"></span> Senior Admin
                    </label>
                    <label class="css-control css-control-primary css-radio">
                        <input class="css-control-input" name="level" type="radio" value="2">
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