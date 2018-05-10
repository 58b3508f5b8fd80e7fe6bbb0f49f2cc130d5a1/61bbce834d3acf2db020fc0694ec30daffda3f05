@php    $public='';    if(config('app.env') == 'production')    $public ='public'; @endphp
<!DOCTYPE HTML>
<html>


<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="squirrellabs"/>
    <meta name="keywords" content="squirrellabs"/>
    <meta name="description" content="@yield('title')"/>
	
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" media="all" href="{{asset($public.'/css/style.css')}}">

    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" media="all" href="{{asset($public.'/css/ie.css')}}" />
    <script type="text/javascript" src="{{asset($public.'/js/html5.js')}}" ></script>
    <![endif]-->

	<!-- Javascripts -->
	<script type="text/javascript" charset="utf-8" src="{{asset($public.'/js/jquery-1.8.3.js')}}"></script>
	<script type="text/javascript" charset="utf-8" src="{{asset($public.'/js/plax.js')}}"></script>
	<script type="text/javascript" charset="utf-8" src="{{asset($public.'/js/404.js')}}"></script>
</head>
	<body id="errorpage" class="error404">
        <div id="pagewrap">
            <!--Header Start-->
            <div id="header" class="header">
                <div class="container">
                    <img class="logo" src="{{asset($public.'/png/logo.png')}}" alt=""/>
					<a href="#" title="logo" class="link">{{config('app.name')}}</a>
                </div>
            </div><!--Header End-->

			<!--page content-->
            <div id="wrapper" class="clearfix">     
                <div id="parallax_wrapper">    
                    <div id="content">
                        @yield('content')
                        <a href="{{url()->previous()}}" title="" class="button">Go Back</a>
                    </div>
                </div>
            </div>

        </div><!-- end pagewrap -->
		
		<!--page footer-->
        <div id="footer">  
            <div class="container">
                <ul class="copyright_info">
                    <li>&copy; {{date('Y')}} {{config('app.name')}}</li>
					<li>&middot;</li>
					<li>Made with love by <a href="{{config('app.designerWebsite')}}"
                                             target="_blank">{{config('app.designer')}}</a></li>
                </ul>
            </div>
        </div><!--end page footer-->

    </body>

<!-- Mirrored from povestea-noastra.com/theme/lostcloud404/layout7/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 May 2018 05:35:37 GMT -->
</html>

