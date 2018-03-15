@php
    $data= session('stats');
@endphp
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
    <meta property="og:title" content="@yield('title')">
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
<div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-boxed">
    <nav id="sidebar">
        <div id="sidebar-scroll">
            <div class="sidebar-content">
                <div class="content-header content-header-fullrow px-15">
                    <div class="content-header-section sidebar-mini-visible-b">
<span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
<span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
</span>
                    </div>
                    <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                        <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r"
                                data-toggle="layout" data-action="sidebar_close">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                        <div class="content-header-item">
                            <a class="link-effect font-w700" href="#'">
                                <i class="si si-fire text-primary"></i>
                                <span class="font-size-xl text-dual-primary-dark">{{config('app.name')}}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="content-side content-side-full content-side-user px-10 align-parent">
                    <div class="sidebar-mini-visible-b align-v animated fadeIn">
                        <img class="img-avatar img-avatar32" src="{{Storage::url(Auth::user()->avatar)}}" alt="">
                    </div>
                    <div class="sidebar-mini-hidden-b text-center">
                        <a class="img-link" href="#">
                            <img class="img-avatar" src="{{Storage::url(Auth::user()->avatar)}}" alt="">
                        </a>
                        <ul class="list-inline mt-10">
                            <li class="list-inline-item">
                                <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase"
                                   href="#">{{Auth::user()->first_name}}</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="link-effect text-dual-primary-dark" data-toggle="layout"
                                   data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                                    <i class="si si-drop"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="link-effect text-dual-primary-dark" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="si si-logout"></i>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        <li>
                            <a href="{{url('/dashboard')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">Dashboard</span></a>
                        </li>
                       {{-- <li>
                            <a href="{{url('/statistics')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">Statistics</span></a>
                        </li>--}}
                        <li class="nav-main-heading"><span class="sidebar-mini-visible">PNM</span><span
                                    class="sidebar-mini-hidden">PNM</span></li>
                        <li>
                            <a href="{{url('transaction/pnm/convert')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">Convert PNM</span></a>
                        </li>
                        <li>
                            <a href="{{url('transaction/pnm/transfer')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">Transfer PNM</span></a>
                        </li>
                        <li>
                            <a href="{{url('transaction/pnm/withdraw')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">Withdraw PNM</span></a>
                        </li>

                        <li class="nav-main-heading"><span class="sidebar-mini-visible">NGN</span><span
                                    class="sidebar-mini-hidden">NGN</span></li>
                        <li>
                            <a href="{{url('transaction/ngn/convert')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">Convert NGN</span></a>
                        </li>
                        <li>
                            <a href="{{url('transaction/ngn/withdraw')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">Withdraw NGN</span></a>
                        </li>
                        <li class="nav-main-heading"><span class="sidebar-mini-visible">Usage</span><span
                                    class="sidebar-mini-hidden">Usage</span></li>
                        <li>
                            <a href="{{url('/transactions')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">Transactions History</span></a>
                        </li>
                        {{--<li>
                            <a href="{{url('/faq')}}"><i class="si si-compass"></i><span
                                        class="sidebar-mini-hide">FAQs</span></a>
                        </li>--}}
                        <li>
                            <a href="{{url('/settings')}}"><i class="si si-compass"></i><span class="sidebar-mini-hide">Settings</span></a>
                            <a href="{{url('/settings')}}"><i class="si si-compass"></i><span class="sidebar-mini-hide">Settings</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <header id="page-header">
        <div class="content-header">
            <div class="content-header-section">
                <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout"
                        data-action="sidebar_toggle">
                    <i class="fa fa-navicon"></i>
                </button>
            </div>
            <div class="content-header-section">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->first_name}}<i class="fa fa-angle-down ml-5"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right min-width-150"
                         aria-labelledby="page-header-user-dropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{url('/settings
                        ')}}" data-toggle="layout"
                           data-action="side_overlay_toggle">
                            <i class="si si-wrench mr-5"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="si si-logout mr-5"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </header>
    <main id="main-container">
        <div class="btn-group-justified">
        <button type="button" class="btn btn-dual-secondary text-muted js-tooltip-enabled" data-toggle="tooltip" data-original-title="Click me to Copy" title = "Click me to copy" onclick="copyToClipboard('#wallet')">
            <i class="fa fa-user"></i> Wallet ID: <span class="text-primary" id="wallet">{{Auth::user()->wallet_id}}</span>
        </button>
        <button type="button" class="btn btn-dual-secondary text-muted" data-toggle="layout">
            <i class="fa fa-line-chart"></i> Value per PNM: <span class="text-danger">{{$data['currentValue'] or 0}}
                NGN</span>
        </button>
        <button type="button" class="btn btn-dual-secondary text-muted" data-toggle="layout">
            <i class="si si-fire"></i> Total PNM: <span class="text-success">{{$data['totalPNM']/100}}
                PNM</span>
        </button>
        <button type="button" class="btn btn-dual-secondary text-muted" data-toggle="layout">
            &#8358; NGN Value: <span class="text-corporate">{{$data['totalPNM']/100 * $data['currentValue']}}
                NGN</span>
        </button>
        </div>
        @yield('content')
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
<script src="{{asset($public.'/js/chart.bundle.min.js')}}"></script>
<script src="{{asset($public.'/js/be_pages_dashboard.js')}}"></script>
<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
@yield('scripts')

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
</body>

<!-- Mirrored from demo.pixelcave.com/codebase/be_pages_dashboard.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jan 2018 21:36:53 GMT -->
</html>