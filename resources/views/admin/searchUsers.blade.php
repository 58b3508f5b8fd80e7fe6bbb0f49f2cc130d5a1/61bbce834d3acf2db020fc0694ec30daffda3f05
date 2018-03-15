@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.admin')
@section('title','Search users')

@section('content')
    <div id="page-header-search">
        <div class="content-header content-header-fullrow col-sm-10 col-sm-offset-1">
            <form action="{{url('/admin/search')}}" method="get">
                <div class="input-group">
                    <input class="form-control" placeholder="Enter your search query or hit ESC.."
                           id="page-header-search-input"
                           name="search" type="text" value="{{$query or null}}" required>
{{--
                    <select class="form-control col-md-3 col-sm-4" id="page-header-search-type"
                            name="type" title="Select type">
                        <option value="users">Users</option>
                        <option value="transactions">Transactions</option>
                    </select>
--}}
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-secondary">
                        <i class="fa fa-search"></i>
                        </button>
                        </span>
                </div>
            </form>
        </div>
    </div>

    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/admin')}}">Admin</a>
        <span class="breadcrumb-item active">Search Users</span>
    </nav>
    <div class="block">
        <div id="users">
            @include('admin.partials.searchUser')
        </div>
    </div>
    <div aria-hidden="true" style="display: none;" class="modal modal-dialog-top modal-dialog-popout" id="user-modal"
         tabindex="-1" role="dialog"
         aria-labelledby="modal-normal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Edit Users</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content" id="user">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function viewEditUser(id, type) {
            var data = {
                'id': id,
                'type': type,
            };
            $.post('/admin/edit/viewuser', data, function (result) {
                $('#user').html(result.html);
                $('#user-modal').modal('show');
            }).fail(function () {
                alert('Sorry, an error occurred');
            });
        }

        function editUser() {
            var data = {
                'id': $("input[name=id]").val(),
                'first_name': $("input[name=first_name]").val(),
                'last_name': $("input[name=last_name]").val(),
                'other_name': $("input[name=other_name]").val(),
                'account_number': $("input[name=account_number]").val(),
                'wallet_address': $("input[name=wallet_address]").val(),
                'private_key': $("input[name=private_key]").val(),
                'marital_status': $("input[name=marital_status]").val(),
                'gender': $("input[name=gender]").val(),
                'phone_no': $("input[name=phone_no]").val(),
                'nationality': $("input[name=nationality]").val(),
                'state': $("input[name=state]").val(),
                'lga': $("input[name=lga]").val(),
                'residential_address': $("input[name=residential_address]").val(),
                'contact_address': $("input[name=contact_address]").val(),
                'id_card_type': $("input[name=id_card_type]").val(),
                'id_card_no': $("input[name=id_card_no]").val(),
                'occupation': $("input[name=occupation]").val(),
                'bvn': $("input[name=bvn]").val(),
                'bank_name': $("input[name=bank_name]").val(),
                'bank_acc_name': $("input[name=bank_acc_name]").val(),
                'bank_acc_no': $("input[name=bank_acc_no]").val(),
                'next_of_kin': $("input[name=next_of_kin]").val(),
                'nok_relationship': $("input[name=nok_relationship]").val(),
                'nok_contact_address': $("input[name=nok_contact_address]").val(),
                'nok_gender': $("input[name=nok_gender]").val(),
                'nok_phone_no': $("input[name=nok_phone_no]").val(),
                'nok_email': $("input[name=nok_email]").val(),
                'spouse_name': $("input[name=spouse_name]").val(),
                'mother_maiden_name': $("input[name=mother_maiden_name]").val(),
                'office_phone_no': $("input[name=office_phone_no]").val(),
                'landmark': $("input[name=landmark]").val(),
                'form_location': $("input[name=form_location]").val(),
                'signature_location': $("input[name=signature_location]").val(),
                'utility_bill_location': $("input[name=utility_bill_location]").val(),
                'idcard_location': $("input[name=idcard_location]").val(),
                'passport_location': $("input[name=passport_location]").val(),
                'for': 'user',
            };

            $.post('/admin/edit/user', data, function (result) {
                alert(result.message);

                $('#user-modal').modal('hide');

                $('#users').fadeOut(300);
                $('#users').html(result.html);
                $('#users').fadeIn(300);
            }).fail(function () {
                alert('Sorry, an error occurred');
            });
        }

        function verifyUser(id, action) {
            var data = {
                'id': id,
                'action': action,
                'for': 'user'
            };
            $.post('/admin/users/verify', data, function (result) {

                alert(result.message);

                $('#users').fadeOut(300);
                $('#users').html(result.html);
                $('#users').fadeIn(300);
            }).fail(function () {
                alert('Sorry, an error occurred');
            });
        }

        $(function () {

            // We can attach the `fileselect` event to all file inputs on the page
            $(document).on('change', ':file', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                //$('#file-info').val(label);
                input.trigger('fileselect', [numFiles, label]);
            });

            // We can watch for our custom `fileselect` event like this
            $(document).ready(function () {
                $(':file').on('fileselect', function (event, numFiles, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log) alert(log);
                    }

                });
            });

        });

        function filePreview(input, id) {
            $(id).html('');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(id).siblings('embed').remove();
                    $(id).after('<embed src="' + e.target.result + '" style = "max-width: 100%; max-height: 20em;"/>');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#formlocation").change(function () {
            filePreview(this, '#formImage');
        });
        $("#signaturelocation").change(function () {
            filePreview(this, '#signatureImage');
        });
        $("#utilitylocation").change(function () {
            filePreview(this, '#utilityImage');
        });
        $("#idcardlocation").change(function () {
            filePreview(this, '#idcardImage');
        });
        $("#passportlocation").change(function () {
            filePreview(this, '#passportImage');
        });

    </script>
@endsection