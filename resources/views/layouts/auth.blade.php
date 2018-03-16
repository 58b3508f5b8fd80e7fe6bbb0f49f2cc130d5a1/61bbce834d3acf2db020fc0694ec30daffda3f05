@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp <!doctype html>
<!--[if lte IE 9]>
<html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="no-focus"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{config('app.name')}} - @yield('title')</title>
    <meta name="description"
          content="{{config('description')}}">
    <meta name="author" content="{{config('app.name')}}">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework | DEMO">
    <meta property="og:site_name" content="{{config('app.description')}}">
    <meta property="og:description"
          content="{{config('app.description')}}">
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
        <div class="bg-gd-sea">
            <div class="hero-static content content-full bg-white js-appear-enabled animated fadeIn"
                 data-toggle="appear">
                @yield('content')
            </div>
        </div>
    </main>
    <footer id="page-footer" class="opacity-0">
        <div class="content py-20 font-size-xs clearfix">
            <div class="float-right">
                <i class="fa fa-gear fa-spin text-success"></i> Designed by <a class="font-w600"
                                                                               href="{{config('app.designerWebsite')}}"
                                                                               target="_blank">{{config('app.designer')}}</a>
            </div>
            <div class="float-left">
                <a class="font-w600" href="{{url('/')}}" target="_blank"></a>{{ config('app.name') }} &copy; <span
                        class="js-year-copy">{{date('Y')}}</span>
            </div>
        </div>
    </footer>
</div>

<script src="{{asset($public.'/js/codebase.min-1.4.js')}}"></script>
<script src="{{asset($public.'/js/jquery.validate.min.js')}}"></script>
<script src="{{asset($public.'/js/op_auth_signup.js')}}"></script>
=======
<script src="{{url('css/codebase.min-1.4.js')}}"></script>
<script src="css/jquery.validate.min.js"></script>
<script src="{{url('css/op_auth_signup.js')}}"></script>


</body>

<!-- Mirrored from demo.pixelcave.com/codebase/be_pages_dashboard.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2018 21:36:53 GMT -->
</html>