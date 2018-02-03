<div class="row justify-content-center px-5">
    <div class="col-sm-12 col-md-10 col-xl-8">
        <form class="js-validation-signup" id = "editForm" action="{{url('/admin/edit/admin')}}"
              method="post" onsubmit="editUser(); return false;">
            {{csrf_field()}}
            <input type="hidden" value="{{$admin['id']+1427}}" name="id" id="id">
            <div class="form-group{{ $errors->has('first_name') ? ' is-invalid' : '' }}  row">
                <div class="col-12">
                    <div class="form-material">
                        <input class="form-control" id="first_name" name="first_name" type="text"
                               value="{{$admin['first_name']}}"
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
                    <div class="form-material">
                        <input class="form-control" id="last_name" name="last_name" type="text"
                               value="{{$admin['last_name']}}"
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
                    <div class="form-material">
                        <input class="form-control" id="email" name="email" type="email"
                               value="{{$admin['email']}}"
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
                <div class="col-md-9">
                    <div class="form-material">
                        <select class="form-control" id="level" name="level">
                            <option disabled></option>
                            <option value="3" @if($admin['access_level']==3) selected @endif>Senior Admin</option>
                            <option value="2" @if($admin['access_level']==2) selected @endif>Admin</option>
                        </select>
                        <label for="level">Access Level</label>
                    </div>
                </div>
            </div>
            <div class="form-group row gutters-tiny">
                <div class="col-12 mb-10">
                    <button type="submit"
                            class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-success">
                        <i class="si si-user-follow mr-10"></i> Edit Admin
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>