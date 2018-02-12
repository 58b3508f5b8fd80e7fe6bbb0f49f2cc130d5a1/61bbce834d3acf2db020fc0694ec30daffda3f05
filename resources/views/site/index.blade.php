<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from tlsavings.xyz/About-us by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Jan 2018 00:47:52 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8"/><!-- /Added by HTTrack -->
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>{{config('app.name')}}</title>
    <base/>
    <meta name="viewport" content="width=992"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <!-- Facebook Open Graph -->
    <meta name="og:title" content="{{config('app.name')}}"/>
    <meta name="og:description" content=""/>
    <meta name="og:image" content=""/>
    <meta name="og:type" content="article"/>
    <meta name="og:url" content="{{config('app.name')}}"/>
    <!-- Facebook Open Graph end -->

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/mainde0d.js?v=20171208161001" type="text/javascript"></script>

    <link href="css/font-awesome.min3e6e.css?v=4.7.0" rel="stylesheet" type="text/css"/>
    <link href="css/site2e13.css?v=20180103162959" rel="stylesheet" type="text/css"/>
    <link href="css/common0969.css?ts=1515221880" rel="stylesheet" type="text/css"/>
    <link href="css/20969.css?ts=1515221880" rel="stylesheet" type="text/css"/>

    <script type="text/javascript">var currLang = '';</script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <![endif]-->
</head>


<body>
<div class="root">
    <div class="vbox wb_container" id="wb_header">

        <div class="wb_cont_inner">
            <div id="wb_element_instance32" class="wb_element wb-menu">
                <ul class="hmenu">
                    <li class="active"><a href="{{url('')}}" target="_self" title="Home">Home</a></li>
                    @guest <li><a href="{{url('/login')}}" target="_blank" title="Login">LOGIN</a></li>
                    <li><a href="{{url('/join')}}" target="_blank" title="Join">JOIN</a></li> @endguest
                    @auth <li><a href="{{url('/dashboard')}}" target="_blank" title="Dashboard">Dashboard</a></li> @endauth
                </ul>
                <div class="clearfix"></div>
            </div>
            <div id="wb_element_instance33" class="wb_element wb_element_shape">
                <div class="wb_shp"></div>
            </div>
            <div id="wb_element_instance34" class="wb_element" style=" line-height: normal;"><h1
                        class="wb-stl-heading1"><span style="background-color:#ffffff;">{{config('app.name')}}</span></h1>
            </div>
            <div id="wb_element_instance35" class="wb_element wb_element_picture"><img alt="gallery/tlsavings jpg"
                                                                                       src="jpg/f7923973432d866a679e08b1e952e7ec_80x80.jpg">
            </div>
        </div>

        <div class="wb_cont_bg"></div>
    </div>
    <div class="vbox wb_container" id="wb_main">

        <div class="wb_cont_inner">
            <div id="wb_element_instance37" class="wb_element" style=" line-height: normal;"><p class="wb-stl-normal"
                                                                                                style="text-align: justify;">
                    Touching Lives Skills Multipurpose Co. Ltd commonly known as TLSavings is a subsidiary organization
                    of Touching Lives Skills International registered in Germany with branches spread accross the globe
                    in every nation where Touching Lives Skills Project Exist.</p>

                <p class="wb-stl-normal" style="text-align: justify;"> </p>

                <p class="wb-stl-normal" style="text-align: justify;">TLSavings official currency is the Pneuma Coin
                    (NUMA COIN). We accept other currencies but they are exchanged to Pneuma before payment is made to
                    an individuals account. To learn more about Pneuma visit the NUMA page above.</p>

                <p class="wb-stl-normal" style="text-align: justify;">Our vision is to encourage savings and interest on
                    savings. We have several savings opportunity to encourage individuals save funds for big projects
                    and get good interest rates on their savings. To learn more visit the savings page.</p>

                <p class="wb-stl-normal" style="text-align: justify;"> </p>

                <p class="wb-stl-normal" style="text-align: justify;">Our savings platform also gives our clients the
                    opportunity to participate in our Empowerment program and Credit Program. Interested individuals can
                    visit the Empowerment page to get more information.</p>

                <p class="wb-stl-normal" style="text-align: justify;"> </p>

                <p class="wb-stl-normal" style="text-align: justify;">We also have a 24hours support services. Our
                    Dynamic team are kin to ensure that you have an excellent experience while saving with us.</p>
            </div>
            <div id="wb_element_instance38" class="wb_element" style=" line-height: normal;"><h1
                        class="wb-stl-heading1">About us</h1></div>
        </div>
    </div>
    <div class="vbox wb_container" id="wb_footer">

        <div class="wb_cont_inner" style="height: 104px;">
            <div id="wb_element_instance36" class="wb_element" style=" line-height: normal;"><p class="wb-stl-footer">©
                    2018 <a href="{{url('index')}}>tlsavings.xyz</a></p></div><div id=" wb_element_instance45"
                    class="wb_element" style="text-align: center; width: 100%;">
                <div class="wb_footer"></div>
                <script type="text/javascript">
                    $(function () {
                        var footer = $(".wb_footer");
                        var html = (footer.html() + "").replace(/^\s+|\s+$/g, "");
                        if (!html) {
                            footer.parent().remove();
                            footer = $("#wb_footer, #wb_footer .wb_cont_inner");
                            footer.css({height: ""});
                        }
                    });
                </script>
            </div>
        </div>
        <div class="wb_cont_outer"></div>
        <div class="wb_cont_bg"></div>
    </div>
    <div class="wb_sbg"></div>
</div>
</body>

<!-- Mirrored from tlsavings.xyz/About-us by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Jan 2018 00:47:52 GMT -->
</html>
