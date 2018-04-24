@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp @extends('layouts.admin')
@section('title', title_case($action).' users')
@section('style')
    {{--<link href="{{asset($public.'/css/glDatePicker.flatwhite.css')}}" rel="stylesheet" media="screen">--}}
    <link href="{{asset($public.'/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">

    @if($type=='user')
        <style>
            .modal-dialog {
                max-width: 80%;
            }
        </style>
    @endif
@endsection
@section('content')
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{url('/admin')}}">Admin</a>
        <span class="breadcrumb-item active">View {{title_case($action)}} Users</span>
    </nav>
    <div class="block">
        <div id="users">
            @include('admin.partials.user')
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
    <script src="{{asset($public.'/js/loadingoverlay.min.js')}}"></script>--}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#user-modal').on('shown.bs.modal', function () {
            $("#state").change(function () {
                var data = {'state': $('#state').val()};
                $.post('/admin/add/user/getlgas', data, function (result) {
                    $('#lga').html(result.html);
                });
            });

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

            $('#user-form').on('submit', function (e) {
                e.preventDefault();
                var form = e.target;
                var data = new FormData(form);
                $(".modal").LoadingOverlay("show");
                $.ajax({
                    url: form.action,
                    method: form.method,
                    contentType: false,
                    data: data,
                    processData: false,
                    success: function (result) {
                        $(".modal").LoadingOverlay("hide");
                        alert(result.message);

                        $('#user-modal').modal('hide');

                        $('#users').fadeOut(300);
                        $('#users').html(result.html);
                        $('.table').DataTable();
                        $('#users').fadeIn(300);
                    },
                    error: function () {
                        $(".modal").LoadingOverlay("hide");
                        alert('Sorry, an error occurred');
                    }
                });
                return false;
            })
        });

        @if($type=='admin')
        function viewEditUser(id, type) {
            var data = {
                'id': id,
                'type': type,
            };
            $.post('/admin/edit/viewadmin', data, function (result) {
                $('#user').html(result.html);
                $('.table').DataTable();
                $('#user-modal').modal('show');
            }).fail(function () {
                alert('Sorry, an error occurred');
            });
        }

        function editUser() {

            var data = {
                'id': $('#id').val(),
                'name': $('#name').val(),
                'email': $('#email').val(),
                'last_name': $('#last_name').val(),
                'first_name': $('#first_name').val(),
                'access_level': $('select[name=level]').val(),
                'for': '{{$action}}',
            };

            $(".modal").LoadingOverlay("show");
            $.post('/admin/edit/admin', data, function (result) {
                $(".modal").LoadingOverlay("hide");
                alert(result.message);

                $('#user-modal').modal('hide');

                $('#users').fadeOut(300);
                $('#users').html(result.html);
                $('.table').DataTable();
                $('#users').fadeIn(300);
            }).fail(function () {
                $(".modal").LoadingOverlay("hide");
                alert('Sorry, an error occurred');
            });
        }

        @elseif ($type == 'user')
        function changeSelect(selector, value) {
            $(selector).val(value);
        }

        function linkAccount() {
            $('#linkAccButton').attr('class', 'fa fa-spinner fa-spin');

            var data = {
                'id': $('#id').val(),
                'bvn': $('#bvn').val(),
                'bank_name': $('#bankname').val(),
                'acc_name': $('#bankaccname').val(),
                'acc_no': $('#bankaccno').val()
            };
            $.post('/admin/edit/user/account', data, function (result) {
                alert(result.message);
                $('#linkAccButton').attr('class', 'fa fa-link');
                $('.modal').modal('hide');
            }).fail(function () {
                alert('Sorry, an error occurred');
            });

        }

        function viewEditUser(id, action) {
            var data = {
                'id': id,
                'action': action,
            };
            $(".modal").LoadingOverlay("show");
            $.post('/admin/edit/viewuser', data, function (result) {
                $(".modal").LoadingOverlay("hide");
                $('#user').html(result.html);
                $('#user-modal').modal('show');
            }).fail(function () {
                $(".modal").LoadingOverlay("hide");
                alert('Sorry, an error occurred');
            });
        }

        @endif
        function verifyUser(id, action) {
            var data = {
                'id': id,
                'action': action,
                'for': '{{$action}}'
            };
            $(".modal").LoadingOverlay("show");
            $.post('/admin/users/verify', data, function (result) {
                $(".modal").LoadingOverlay("hide");
                alert(result.message);
                $('#users').fadeOut(300);
                $('#users').html(result.html);
                $('.table').DataTable();
                $('#users').fadeIn(300);
            }).fail(function () {
                $(".modal").LoadingOverlay("hide");
                alert('Sorry, an error occurred');
            });
        }



    </script>
@endsection