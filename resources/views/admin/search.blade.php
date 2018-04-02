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
        <div id="search">
            @include('admin.partials.search')
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

        @if (Auth::user()->access_level >= 4)
        function verifyTransaction(id, action) {
            var data = {
                'id': id,
                'action': action,
                'search': '{{$query or ''}}'
            };
            $.post('/admin/transactions/verify', data, function (result) {
                alert(result.message);
                $('#search').fadeOut(300);
                $('#search').html(result.html);
                $('#search').fadeIn(300);
            }).fail(function () {
                alert('Sorry, an error occurred');
            });
        }
        @endif
    </script>
@endsection