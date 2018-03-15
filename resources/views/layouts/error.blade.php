@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp <!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('title')">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:site_name" content="@yield('title')">
    <meta property="og:description" content="@yield('title')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" href="{{asset($public.'/png/favicon.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset($public.'/png/favicon-192x192.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset($public.'/png/apple-touch-icon-180x180.png')}}">
    <link rel="stylesheet" id="css-main" href="{{asset($public.'/css/tlsavings.min.css')}}">
</head>
<body>
<div id="page-container" class="main-content-boxed">
    <main id="main-container">
        <div class="hero bg-white">
            <div class="hero-inner">
                <div class="content content-full">
                    <div class="py-30 text-center">
                        @yield('content')

                        <a class="btn btn-hero btn-rounded btn-alt-secondary" href="{{ url()->previous() }}">
                            <i class="fa fa-arrow-left mr-10"></i> Go Back
                        </a>
                     </div>
                </div>
            </div>
        </div>
    </main>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<script src="{{asset($public.'/js/codebase.min-1.4.js')}}"></script>
</body>

<!-- Mirrored from demo.pixelcave.com/codebase/op_error_404.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2018 22:08:21 GMT -->
</html>