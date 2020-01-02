<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Veetor Nara">
    <meta name="description" content="EVE Co-pilot landing page">
    <meta name="keywords" content="EVE Online, EVE, API, Co-pilot">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>EVE Co-pilot</title>

    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/animate.css">

    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="js/vendor/modernizr-2.8.3.min.js"></script>

    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->



    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/v1/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicons/v1/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicons/v1/favicon-16x16.png">
    <link rel="manifest" href="images/favicons/v1/site.webmanifest">
    <link rel="mask-icon" href="images/favicons/v1/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="images/favicons/v1/favicon.ico">
    <meta name="msapplication-TileColor" content="#6998de">
    <meta name="msapplication-config" content="images/favicons/v1/browserconfig.xml">
    <meta name="theme-color" content="#7bbceb">


</head>

<body data-spy="scroll" data-target="#primary-menu">

<div class="preloader">
    <div class="sk-folding-cube">
        <div class="sk-cube1 sk-cube"></div>
        <div class="sk-cube2 sk-cube"></div>
        <div class="sk-cube4 sk-cube"></div>
        <div class="sk-cube3 sk-cube"></div>
    </div>
</div>
<!--Mainmenu-area-->
<div class="mainmenu-area" data-spy="affix" data-offset-top="100">
    <div class="container">
        <!--Logo-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand logo">
                <h2><img style="height: 48px;position: relative;top: -2px;" src="images/logo-white.png" alt="Logo"></h2>
            </a>
        </div>
        <!--Logo/-->
        <nav class="collapse navbar-collapse" id="primary-menu">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="#home-page">Home</a></li>
                <li><a href="#activate-copilot">Getting started</a></li>
                <li><a href="#activate-copilot">Features</a></li>
                <li><a href="#faq-page">FAQ</a></li>
                <li><a href="https://m.me/eveonlinecopilot" target="_blank"><img src="/images/icons/fb-messenger.png" alt="."> Messenger</a></li>
                <li><a href="http://t.me/eveonlinecopilot_bot" target="_blank"><img src="images/icons/telegram.png" alt=""> Telegram</a></li>
            </ul>
        </nav>
    </div>
</div>
<!--Mainmenu-area/-->



<!--Header-area-->
<header class="header-area overlay full-height relative v-center" id="home-page">
{{--    <div class="absolute anlge-bg"></div>--}}
    <video id="video" class="video-cover" poster="videos/amarr.cdn.jpg" loop="loop" preload="auto" autoplay muted>
        <source src="videos/amarr.cdn.mp4" type="video/mp4">
        <source src="videos/amarr.cdn.ogv" type="video/ogg">
        <source src="videos/amarr.cdn.webm" type="video/webm">
    </video>
    <div class="container">s
        <div class="row v-center">
            <div class="hidden-xs hidden-sm col-md-5 text-right">
                    <div class="item">
                        <img src="images/aura.png" alt="">
                    </div>
            </div>
            <div class="col-xs-12 col-md-7 header-text">
                <h2>Chatbot Co-Pilot for EVE Online</h2>
                <p>Providing <strong>location</strong>, <strong>mailing</strong>, <strong>emergency</strong> and <strong>intelligence</strong> services.
                    <br>
                    On <strong>Facebook Messenger</strong> and <strong>Telegram</strong>.</p>
                <div class="btn-group">
                    <a href="#activate-copilot" class="btn button">Get started</a>
                    <a href="#" class="btn button">See functions</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!--Header-area/-->

<!--Feature-area-->
<section class="gray-bg section-padding" id="activate-copilot">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2>Getting started</h2>
                    <p>You can turn it on in 3 easy steps. Here is how:</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/eve/rifter.png" alt="">
                    </div>
                    <h4>1<sup>st</sup> step</h4>
                    <p>Log in with your Eve Online account here</p>
                    <a href="{{route("auth-start")}}" target="_blank"><img src="/images/sso_small.png" alt="SSO login"></a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/eve/rupture.png" alt="">
                    </div>
                    <h4>2<sup>nd</sup> step</h4>
                    <p>After you signed in, you will receive a token. The co-pilot will ask for it, so copy it to your clipboard.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/eve/tempest.png" alt="">
                    </div>
                    <h4>3<sup>rd</sup> step</h4>
                    <p>Open a conversation (<a class="btn-link" href="https://m.me/eveonlinecopilot" target="_blank">Facebook Messenger</a> or <a class="btn-link" href="http://t.me/eveonlinecopilot_bot" target="_blank">Telegram</a>) and say <code>Link character</code></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Feature-area/-->

<section class="angle-bg sky-bg section-padding overlay" >
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div id="caption_slide" class="carousel slide caption-slider" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="item active row">
                            <div class="v-center">
                                <div class="col-xs-12 col-md-6">
                                    <div class="caption-title" data-animation="animated fadeInUp">
                                        <h2>Multi character support</h2>
                                    </div>
                                    <div class="caption-desc" data-animation="animated fadeInUp">
                                        <p>You can authenticate more users on this website and then add the characters to your chat via <code>Link character</code>.
                                            <br> After you added the characters you can refer to them using their names, like  <code>Switch to [character name]</code></p>
                                    </div>
                                    <div class="caption-button" data-animation="animated fadeInUp">
                                        <a href="#" class="button">Read more</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo one" data-animation="animated fadeInRight">
                                        <img src="images/screen-1.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo two" data-animation="animated fadeInRight">
                                        <img src="images/screen-2.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="v-center">
                                <div class="col-xs-12 col-md-6">
                                    <div class="caption-title" data-animation="animated fadeInUp">
                                        <h2>Easy to use</h2>
                                    </div>
                                    <div class="caption-desc" data-animation="animated fadeInUp">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute</p>
                                    </div>
                                    <div class="caption-button" data-animation="animated fadeInUp">
                                        <a href="#" class="button">Read more</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo one" data-animation="animated fadeInRight">
                                        <img src="images/screen-3.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo two" data-animation="animated fadeInRight">
                                        <img src="images/screen-4.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="v-center">
                                <div class="col-xs-12 col-md-6">
                                    <div class="caption-title" data-animation="animated fadeInUp">
                                        <h2>Easy to customize</h2>
                                    </div>
                                    <div class="caption-desc" data-animation="animated fadeInUp">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute</p>
                                    </div>
                                    <div class="caption-button" data-animation="animated fadeInUp">
                                        <a href="#" class="button">Read more</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo one" data-animation="animated fadeInRight">
                                        <img src="images/screen-7.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo two" data-animation="animated fadeInRight">
                                        <img src="images/screen-2.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="v-center">
                                <div class="col-xs-12 col-md-6">
                                    <div class="caption-title" data-animation="animated fadeInUp">
                                        <h2>Awesome design</h2>
                                    </div>
                                    <div class="caption-desc" data-animation="animated fadeInUp">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute</p>
                                    </div>
                                    <div class="caption-button" data-animation="animated fadeInUp">
                                        <a href="#" class="button">Read more</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo one" data-animation="animated fadeInRight">
                                        <img src="images/screen-3.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo two" data-animation="animated fadeInRight">
                                        <img src="images/screen-4.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Indicators -->
                    <ol class="carousel-indicators caption-indector">
                        <li data-target="#caption_slide" data-slide-to="0" class="active">
                            <strong>Multi character support</strong> and easy switching
                        </li>
                        <li data-target="#caption_slide" data-slide-to="1">
                            <strong>Lorem ipsum </strong>consectetur adipisicing elit.
                        </li>
                        <li data-target="#caption_slide" data-slide-to="2">
                            <strong>Lorem ipsum </strong>consectetur adipisicing elit.
                        </li>
                        <li data-target="#caption_slide" data-slide-to="3">
                            <strong>Lorem ipsum </strong>consectetur adipisicing elit.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="gray-bg section-padding" id="feature-page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2>SPECIAL FEATURES</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit voluptates, temporibus at, facere harum fugiat!</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/portfolio-icon-1.png" alt="">
                    </div>
                    <h3>Creative Design</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque quas nulla est adipisci,</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/portfolio-icon-2.png" alt="">
                    </div>
                    <h3>Unlimited Features</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque quas nulla est adipisci,</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/portfolio-icon-3.png" alt="">
                    </div>
                    <h3>Full Free Chat</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque quas nulla est adipisci,</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/portfolio-icon-4.png" alt="">
                    </div>
                    <h3>Retina ready</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque quas nulla est adipisci,</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/portfolio-icon-5.png" alt="">
                    </div>
                    <h3>High Resolution</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque quas nulla est adipisci,</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/portfolio-icon-6.png" alt="">
                    </div>
                    <h3>Clean Codes</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque quas nulla est adipisci,</p>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="gray-bg section-padding" id="faq-page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2>Frequently Asked Questions</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit voluptates, temporibus at, facere harum fugiat!</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="panel-group" id="accordion">
                    <div class="panel">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true">Sedeiusmod tempor inccsetetur aliquatraiy?</a>
                        </h4>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodas temporo incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrd exercitation ullamco laboris nisi ut aliquip ex comodo consequat. Duis aute dolor in reprehenderit.</p>
                        </div>
                    </div>
                    <div class="panel">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Tempor inccsetetur aliquatraiy?</a>
                        </h4>
                        <div id="collapse2" class="panel-collapse collapse">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodas temporo incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrd exercitation ullamco laboris nisi ut aliquip ex comodo consequat. Duis aute dolor in reprehenderit.</p>
                        </div>
                    </div>
                    <div class="panel">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Lorem ipsum dolor amet, consectetur adipisicing ?</a>
                        </h4>
                        <div id="collapse3" class="panel-collapse collapse">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodas temporo incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrd exercitation ullamco laboris nisi ut aliquip ex comodo consequat. Duis aute dolor in reprehenderit.</p>
                        </div>
                    </div>
                    <div class="panel">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Lorem ipsum dolor amet, consectetur adipisicing ?</a>
                        </h4>
                        <div id="collapse4" class="panel-collapse collapse">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodas temporo incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrd exercitation ullamco laboris nisi ut aliquip ex comodo consequat. Duis aute dolor in reprehenderit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>






<section class="section-padding gray-bg" id="blog-page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="single-blog">
                    <div class="blog-photo">
                        <img src="images/small1.jpg" alt="">
                    </div>
                    <div class="blog-content">
                        <h3><a href="#">Beautiful Place for your Great Journey</a></h3>
                        <ul class="blog-meta">
                            <li><span class="ti-user"></span> <a href="#">Admin</a></li>
                            <li><span class="ti-calendar"></span> <a href="#">Feb 01, 2017</a></li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit nemo eaque expedita aliquid dolorem repellat perferendis, facilis aut fugit, impedit.</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="single-blog">
                    <div class="blog-photo">
                        <img src="images/small2.jpg" alt="">
                    </div>
                    <div class="blog-content">
                        <h3><a href="#">Beautiful Place for your Great Journey</a></h3>
                        <ul class="blog-meta">
                            <li><span class="ti-user"></span> <a href="#">Admin</a></li>
                            <li><span class="ti-calendar"></span> <a href="#">Feb 01, 2017</a></li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit nemo eaque expedita aliquid dolorem repellat perferendis, facilis aut fugit, impedit.</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="single-blog">
                    <div class="blog-photo">
                        <img src="images/small3.jpg" alt="">
                    </div>
                    <div class="blog-content">
                        <h3><a href="#">Beautiful Place for your Great Journey</a></h3>
                        <ul class="blog-meta">
                            <li><span class="ti-user"></span> <a href="#">Admin</a></li>
                            <li><span class="ti-calendar"></span> <a href="#">Feb 01, 2017</a></li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit nemo eaque expedita aliquid dolorem repellat perferendis, facilis aut fugit, impedit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer-area relative sky-bg" id="contact-page">
    <div class="absolute footer-bg"></div>
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 pull-right">
                    <ul class="social-menu text-right x-left">
                        <li><a href="https://facebook.com/eveonlinecopilot"><i class="ti-facebook"></i></a></li>
                        <li><a href="https://twitter.com/veetor_in_eve"><i class="ti-twitter"></i></a></li>
                        <li><a href="https://github.com/molbal"><i class="ti-github"></i></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p>
                    <p>Any assistance with the server upkeep is greatly appreciated.</p>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_donations" />
                        <input type="hidden" name="business" value="TZX5GJQA4USZQ" />
                        <input type="hidden" name="currency_code" value="EUR" />
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                        <img alt="" border="0" src="https://www.paypal.com/en_HU/i/scr/pixel.gif" width="1" height="1" />
                    </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                  </p>
                    <p class="text-justify" style="font-size: 0.95rem">All images are material are property of CCP Games: EVE Online and the EVE logo are the registered trademarks of CCP hf. All rights are reserved worldwide. All other trademarks are the property of their respective owners. EVE Online, the EVE logo, EVE and all associated logos and designs are the intellectual property of CCP hf. All artwork, screenshots, characters, vehicles, storylines, world facts or other recognizable features of the intellectual property relating to these trademarks are likewise the intellectual property of CCP hf. CCP hf. has granted permission to evewho.com to use EVE Online and all associated logos and designs for promotional and zKillboard.com purposes on its website but does not endorse, and is not in any way affiliated with, zKillboard.com. CCP is in no way responsible for the content on or functioning of this website, nor can it be liable for any damage arising from the use of this website.</p>
                    <p class="text-justify" style="font-size: 0.95rem">Contributions by <a href="https://colorlib.com" target="_blank" rel="nofollow">Colorlib</a> and  <a href="https://icons8.com" target="_blank" rel="nofollow">Icons8</a> - thank you.</p>
                </div>
            </div>
        </div>
    </div>
</footer>





<!--Vendor-JS-->
<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/vendor/bootstrap.min.js"></script>
<!--Plugin-JS-->
<script src="js/owl.carousel.min.js"></script>
<script src="js/contact-form.js"></script>
<script src="js/jquery.parallax-1.1.3.js"></script>
<script src="js/scrollUp.min.js"></script>
<script src="js/magnific-popup.min.js"></script>
<script src="js/wow.min.js"></script>
<!--Main-active-JS-->
<script src="js/main.js"></script>

@component("components.facebook-chat") @endcomponent
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-86961430-7"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-86961430-7');
</script>

</body>

</html>
