@extends('layouts.admin')
@section('title', title_case($action).' users')
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if($type=='admin')
        function viewEditUser(id, type) {
            var data = {
                'id': id,
                'type': type,
            };
            $.post('/admin/edit/viewadmin', data, function (result) {
                $('#user').html(result.html);
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

            $.post('/admin/edit/admin', data, function (result) {
                alert(result.message);

                $('#user-modal').modal('hide');

                $('#users').fadeOut(300);
                $('#users').html(result.html);
                $('#users').fadeIn(300);
            }).fail(function () {
                $('#user-modal').modal('hide');
                alert('Sorry, an error occurred');
            });
        }

        @elseif ($type == 'user')
        function editUser() {
            var formData = {
                'name': $('input[name=name]').val(),
                'email': $('input[name=email]').val(),
                'last_name': $('input[name=last_name]').val(),
                'first_name': $('input[name=first_name]').val(),
                'access_level': $('input[name=level]').val(),
            };

            $.post('/admin/edit/user', data, function (result) {
                $('#user').html(result.html);
                $('#user-modal').modal('show');
            }).fail(function () {
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
            $.post('/admin/users/verify', data, function (result) {

                alert(result.message);

                $('#users').fadeOut(300);
                $('#users').html(result.html);
                $('#users').fadeIn(300);
            }).fail(function () {
                alert('Sorry, an error occurred');
            });
        }
    </script>
@endsection