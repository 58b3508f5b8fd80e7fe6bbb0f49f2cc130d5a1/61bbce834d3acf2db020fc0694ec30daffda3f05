@php
    $public='';
    if(App::environment('production'))
    $public ='public';
@endphp
        <!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Under Maintenance | {{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset($public.'/mtce/css/style.css')}}">
    <!--[if lt IE 10]>
    <link rel="stylesheet" type="text/css" href="{{asset($public.'/mtce/css/ie.css')}}"/>
    <![endif]-->
</head>

<body>
<!-- Preloader -->
<div id="loader">
    <div class="outer-circle fa-spin"></div>
    <div class="inner-circle"></div>
    <div class="loader-text">loading...</div>
</div>
<!-- /Preloader -->
<!-- Page -->
<div id="page-bg">
    <div id="overlay">
        <div class="wrapper">
            <!-- Header -->
            <header id="header">
                <!-- Logo -->
                {{--<div id="logo"><img src="{{asset($public.'/mtce/png/logo.png')}}" alt="Logo"></div>--}}
                <!-- /Logo -->
                <h2 style="padding-top: .5rem;">{{config('app.name')}}</h2>
                <!-- Menu -->
                <nav id="main-nav">
                    <div id="sync2" class="owl-carousel">
                        <div class="item">
                            <a href="#home">Home</a>
                        </div>
                        <div class="item">
                            <a href="#about">About</a>
                        </div>
                        <div class="item">
                            <a href="#contacts">Contacts</a>
                        </div>
                    </div>
                </nav>
                <!-- /Menu -->
            </header>
            <!-- /Header -->
            <div id="sync1" class="owl-carousel">
                <!-- Home Section -->
                <section id="home" class="item page-content">
                    <div class="page-inner">
                        <h3 class="section-title">Our website is under construction</h3>
                        <div id="counter"></div>
                        <div class="section-stitle">We'll be here soon with our new awesome site.<br> Subscribe to be
                            notified!
                        </div>
                        <div id="subscribe-btn"><a href="#" class="btn fa-envelope">Subscribe</a></div>
                    </div>
                </section>
                <!-- /Home Section -->
                <!-- About Section -->
                <section id="about" class="item page-content">
                    <div class="page-inner">
                        <h3 class="section-title with-border">About {{config('app.name')}}</h3>
                        <div class="section-stitle"><p>We aim is to reach out to the poor population with skills and empowerment for development, hence
                                fulfilling the vision of the United nations development Program UNDP.</p>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <i class="col-ico fa-desktop"></i>
                                <div class="col-text">
                                    <h5>Our Mission</h5>
                                    <p>To raise businesses and establish good living.</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <i class="col-ico fa-code"></i>
                                <div class="col-text">
                                    <h5>Our Vision</h5>
                                    <p>To raise a global productive business society.</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <i class="col-ico fa-life-saver"></i>
                                <div class="col-text">
                                    <h5>What we are</h5>
                                    <p>We are a non-profit, non-govermental organization.</p>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>
                    </div>
                </section>
                <!-- /About Section -->
                <!-- Contacts Section -->
                <section id="contacts" class="item page-content">
                    <div class="page-inner">
                        <h3 class="section-title with-border">Contact Us</h3>
                        <div class="section-stitle">Do you have a question or just want to say hello? <br> Please feel
                            free to contact us!
                        </div>
                        <!-- Contact form -->
                        <form action="http://adamostry.com/preview/html/dominion/slideshow/php/contact-form.php"
                              method="post" name="contact-form" id="contact-form">
                            <div id="contact-message" class="form-message"></div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="name" placeholder="Your name" id="user-name"
                                           class="required">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="email" placeholder="Your email" id="user-email"
                                           class="required">
                                </div>
                                <div class="col-12">
                                    <textarea placeholder="Enter your message..." name="message" id="user-message"
                                              rows="3" class="required"></textarea>
                                </div>
                                <div class="col-12 submit-box">
                                    <button type="submit" id="contact-submit" class="btn fa-envelope" name="submit">Send
                                        Email
                                    </button>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </form>
                        <!-- /Contact form -->
                    </div>
                </section>
                <!-- /Contacts Section -->
            </div>
        </div>
        <!-- Subscribe -->
        <section id="subscribe">
            <div class="wrapper">
                <div class="page-content">
                    <div class="page-inner">
                        <h3 class="section-title with-border">Subscribe</h3>
                        <div class="subscribe-box">
                            <!-- Subscribe form -->
                            <form action="{{url('/subscribe')}}"
                                  method="post" id="subscribe-form" onsubmit="subscribe(); return false;">
                                <p id="subscribe-message" class="form-message"></p>
                                <div class="form-wrap">
                                    <div class="form-field">
                                        <input type="email" name="email" id="subscribe-email"
                                               placeholder="Enter your email..." required/>
                                    </div>
                                    <div class="form-submit">
                                        <input type="submit" name="submit" id="subscribe-submit" value="Subscribe"/>
                                    </div>
                                </div>
                            </form>
                            <!-- /Subscribe form -->
                            <p class="subscribe-notes">Sign up for our newsletter and you'll be notified when the site
                                is ready.<br> We won't spam your email address.</p>
                        </div>
                        <!-- Social Icons -->
                        <div id="social-box">
                            <ul>
                                <li><a href="https://facebook.com/projectproduceabakinitiative/" class="btn" title="Facebook"><i class="fa-facebook"></i></a></li>
                                <li><a href="#" class="btn" title="Twitter"><i class="fa-twitter"></i></a></li>
                                <li><a href="#" class="btn" title="Pinterest"><i class="fa-pinterest"></i></a></li>
                                <li><a href="#" class="btn" title="Flickr"><i class="fa-flickr"></i></a></li>
                                <li><a href="#" class="btn" title="Dribble"><i class="fa-dribbble"></i></a></li>
                            </ul>
                        </div>
                        <!-- /Social Icons -->
                        <div id="close-popup"><a href="#"></a></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Subscribe -->
    </div>
</div>
<!-- /Page -->
<!-- JS Files -->
<script type="text/javascript" src="{{asset($public.'/mtce/js/jquery-1.11.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset($public.'/mtce/js/jquery.countdown.min.js')}}"></script>
<script type="text/javascript" src="{{asset($public.'/mtce/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{asset($public.'/mtce/js/jquery.backstretch.min.js')}}"></script>
<script type="text/javascript" src="{{asset($public.'/mtce/js/plugins.js')}}"></script>
<!-- /JS Files -->
<!-- Slideshow -->
<script type="text/javascript">
    $('#page-bg').backstretch([
        '{{$public}}/mtce/jpg/bg-1.jpg',
        '{{$public}}/mtce/jpg/bg-2.jpg',
        '{{$public}}/mtce/jpg/bg-3.jpg'
    ], {
        fade: 750,
        duration: 4000
    });
</script>
<script type="text/javascript">
    $("#counter")
        .countdown("{{config('app.mtce_end')}}", function(event) {
            $(this).text(
                event.strftime('%D days %H:%M:%S')
            );
        });

    function subscribe() {
        var data = {
            'email': $('#subscribe-form #subscribe-email').val()
        };
        $.post('/subscribe', data, function (result) {
            alert(result.message);
        }).fail(function () {
            alert('Sorry, an error occurred');
        });
    }
</script>
<script>

</script>
<!-- /Slideshow -->
</body>

<!-- Mirrored from adamostry.com/preview/html/dominion/slideshow/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Feb 2018 19:43:10 GMT -->
</html>