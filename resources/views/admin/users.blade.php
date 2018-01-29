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
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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