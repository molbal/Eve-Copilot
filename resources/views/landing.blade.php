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
                <li><a href="#features-summary">Features</a></li>
                <li><a href="#faq-page">FAQ</a></li>
                <li><a href="https://m.me/eveonlinecopilot" target="_blank"><img src="/images/icons/fb-messenger.png"
                                                                                 alt="."> Messenger</a></li>
                <li><a href="http://t.me/eveonlinecopilot_bot" target="_blank"><img src="images/icons/telegram.png"
                                                                                    alt=""> Telegram</a></li>
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
    <div class="container">
        <div class="row v-center">
            <div class="hidden-xs hidden-sm col-md-5 text-right">
                <div class="item">
                    <img src="images/aura.png" alt="">
                </div>
            </div>
            <div class="col-xs-12 col-md-7 header-text">
                <h2>Chatbot Co-Pilot for EVE Online</h2>
                <p>Providing <strong>location &amp; navigation</strong>, <strong>intelligence</strong> and
                    <strong>emergency</strong> assistance.
                    <br>
                    On <strong>Facebook Messenger</strong> and <strong>Telegram</strong>.</p>
                <div class="btn-group">
                    <a href="#activate-copilot" class="btn button white">Get started</a>
                    <a href="#features-summary" class="btn button white">See functions</a>
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
                    <p>Here is how you can start using the co-pilot: just talk to it!</p>
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
                    <p>After you signed in, you will receive a token. The co-pilot will ask for it, so copy it to your
                        clipboard.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="box">
                    <div class="box-icon">
                        <img src="images/eve/tempest.png" alt="">
                    </div>
                    <h4>3<sup>rd</sup> step</h4>
                    <p>Open a conversation (<a class="btn-link" href="https://m.me/eveonlinecopilot" target="_blank">Facebook
                            Messenger</a> or <a class="btn-link" href="http://t.me/eveonlinecopilot_bot"
                                                target="_blank">Telegram</a>) and say
                        <br> <code>Add character</code></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Feature-area/-->

<section class="section-padding overlay" style="" id="features-summary">
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
                                        <p>You can authenticate more users on this website and then add the characters
                                            to your chat via <code>Add character</code>.
                                            <br> After you added the characters you can refer to them using their names,
                                            like <code>Switch to [character name]</code></p>
                                    </div>
                                    <div class="caption-button" data-animation="animated fadeInUp">
                                        <a href="#feature-multichar" class="button">Read more</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo one" data-animation="animated fadeInRight">
                                        <img class="img-rounded" src="images/eve/chars/2.png" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo two" data-animation="animated fadeInRight">
                                        <img class="img-rounded" src="images/eve/chars/2-ship.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="v-center">
                                <div class="col-xs-12 col-md-6">
                                    <div class="caption-title" data-animation="animated fadeInUp">
                                        <h2>Location Services</h2>
                                    </div>
                                    <div class="caption-desc" data-animation="animated fadeInUp">
                                        <p>Want to get from A to B quickly? Do you wish EVE had intelligent, conflict aware navigation?
                                            <br>Set waypoints easily by telling your co-pilot <code>Go {somewhere}</code> or <code>Navigate home</code>. or if you are AFK and on autopilot, you can have the co-pilot alert you when you reach your destination.</p>
                                    </div>
                                    <div class="caption-button" data-animation="animated fadeInUp">
                                        <a href="#feature-location" class="button">Read more</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo one" data-animation="animated fadeInRight">
                                        <img class="img-rounded" src="images/eve/chars/1.png" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo two" data-animation="animated fadeInRight">
                                        <img class="img-rounded" src="images/eve/chars/1-ship.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="v-center">
                                <div class="col-xs-12 col-md-6">
                                    <div class="caption-title" data-animation="animated fadeInUp">
                                        <h2>Emergency services</h2>
                                    </div>
                                    <div class="caption-desc" data-animation="animated fadeInUp">
                                        <p>Are you mining peacefully in hisec in your Hulk with no tank, when a catalyst arrives in the belt? Starting to panic? Send <code>Emergency warp</code> and the co-pilot will find you a safe warp-out location, from where you can get to a station.
                                            <br> Or are you peacefully ratting in bling ship when bombers arrive? Say <code>mayday</code> to instantly send a message to your emergency contact with your location, ship type, ship name to ask for reinforcement.</p>
                                    </div>
                                    <div class="caption-button" data-animation="animated fadeInUp">
                                        <a href="#feature-emergency" class="button">Read more</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo one" data-animation="animated fadeInRight">
                                        <img class="img-rounded" src="images/eve/chars/3.png" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo two" data-animation="animated fadeInRight">
                                        <img class="img-rounded" src="images/eve/chars/3-ship.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="v-center">
                                <div class="col-xs-12 col-md-6">
                                    <div class="caption-title" data-animation="animated fadeInUp">
                                        <h2>Intelligence services</h2>
                                    </div>
                                    <div class="caption-desc" data-animation="animated fadeInUp">
                                        <p>See someone appear in local? Tell your co-pilot his name (<code>identify {name}</code>)
                                            and it will return basic info, such as corp, alliance info. But you can do that ingame
                                            easier so the co-pilot will also give you the pilot's most commonly used ships and other details.
                                            <br>
                                            If you scanned the ship type you can guess his fit and capabilities by sending <code>intel {ship type}</code>
                                            after the identify command.
                                        </p>
                                    </div>
                                    <div class="caption-button" data-animation="animated fadeInUp">
                                        <a href="#feature-intel" class="button">Read more</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo one" data-animation="animated fadeInRight">
                                        <img class="img-rounded" src="images/eve/chars/4.png" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="caption-photo two" data-animation="animated fadeInRight">
                                        <img class="img-rounded" src="images/eve/chars/4-ship.jpg" alt="">
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
                            <strong>Location & navigation </strong>never get lost again
                        </li>
                        <li data-target="#caption_slide" data-slide-to="2">
                            <strong>Emergency response </strong>react to danger in seconds
                        </li>
                        <li data-target="#caption_slide" data-slide-to="3">
                            <strong>Intel service </strong> Identify and analyse easily
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
                    <h2 id="feature-multichar">Multi character features</h2>
                    <p>These commands help you manage your characters with the Co-pilot</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <img data-toggle="tooltip" src="images/eve/chars/2.png"
                     class="img-rounded pull-right shadow margin-left-md hidden-xs" style="height: 356px;width: 200px;" alt="">
                <div>
                    <h3>Add a new character</h3>
                    <small>
                        <code>Link character</code>
                        <code>Add character</code>
                        <code>Link char</code>
                        <code>Add char</code>
                    </small>
                    <p>
                        This command adds a new character to your current chat. It gives you a link where you can log in with your EVE Online account. The bot will never ask for your EVE Online password or username.
                    </p>

                    <h3>List my characters</h3>
                    <small>
                        <code>My chars</code>
                        <code>My characters</code>
                    </small>
                    <p>Unsure how many characters are added? This command will list your already added characters.
                        It will also show which character the Co-pilot is assigned to.</p>

                    <h3>Switch to account</h3>
                    <small>
                        <code>Switch to {Character name}</code>
                    </small>
                    <p>
                        Have more, than 1 characters added and you want to switch between them? This command lets you do
                        that easily. Pro tip: You don't have to write the entire name, just the first few letters.
                    </p>

                    <h3>Set character home</h3>
                    <small>
                        <code>Set home</code>
                        <code>New home</code>
                    </small>
                    <p>
                        Sets home station/structure for a character. This can come useful for the emergency warp and navigate home commands
                    </p>

                    <h3>Set emergency contact</h3>
                    <small>
                        <code>Set emergency contact</code>
                        <code>New emergency contact</code>
                    </small>
                    <p>
                        Sets the emergency contact for a character. This can come useful when you need to send a quick automated mayday message
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2 id="feature-location" class="margin-top-xl">Location services</h2>
                    <p>These commands help you find and navigate the universe of New Eden</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <img data-toggle="tooltip" src="images/eve/chars/1.png"
                     class="img-rounded pull-right shadow margin-left-md hidden-xs" style="height: 356px;width: 200px;" alt="">
                <div>
                    <h3>Quick status</h3>
                    <small>
                        <code>Status</code>
                    </small>
                    <p>
                        This command shows you where is the current character location and which ship is used.
                    </p>

                    <h3>Set route</h3>
                    <small>
                        <code>Go to {destination}</code>
                        <code>Navigate to {destination}</code>
                        <code>Navigate {destination}</code>
                        <code>Set route to {destination}</code>
                    </small>
                    <p>
                        This command will set your waypoints in EVE (clearing other waypoints). Target can be: <strong>Jita</strong>,
                        <strong>Amarr</strong>, <strong>Dodixie</strong>, <strong>Hek</strong>, <strong>Rens</strong> to set route
                        to the trade stations, <strong>home</strong> for your home set with <code>set home</code>, or any
                        <strong>structure</strong>, <strong>station</strong> or <strong>solar system</strong>.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2 id="feature-emergency" class="margin-top-xl">Emergency services</h2>
                    <p>Emergency services can provide assistance when in need</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <img data-toggle="tooltip" src="images/eve/chars/3.png"
                     class="img-rounded pull-right shadow margin-left-md hidden-xs" style="height: 356px;width: 200px;" alt="">
                <div>
                    <h3>TBA</h3>
                    <small>
                        <code>...</code>
                    </small>
                    <p>
                        ...
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2 id="feature-intel" class="margin-top-xl">Intelligence services</h2>
                    <p>Intelligence services help you quickly make decisions and identify other capsuleers</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <img data-toggle="tooltip" src="images/eve/chars/4.png"
                     class="img-rounded pull-right shadow margin-left-md hidden-xs" style="height: 356px;width: 200px;" alt="">
                <div>
                    <h3>TBA</h3>
                    <small>
                        <code>...</code>
                    </small>
                    <p>
                        ...
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2 id="feature-intel" class="margin-top-xl">Miscellaneous commands</h2>
                    <p>Other commands to make communication smoother</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <img data-toggle="tooltip" src="images/eve/chars/5.png"
                     class="img-rounded pull-right shadow margin-left-md hidden-xs" style="height: 356px;width: 200px;" alt="">
                <div>
                    <h3>Greeting</h3>
                    <small>
                        <code>hi</code>
                        <code>hey</code>
                        <code>sup</code>
                        <code>yo</code>
                        <code>o7</code>
                        <code>o/</code>
                    </small>
                    <p>
                        The co-pilot briefly introduces itself.
                    </p>

                    <h3>Clarification request</h3>
                    <p>When the co-pilot can not understand your message, it will ask you to check for typos and link this page.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section-padding overlay" id="faq-page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2>Frequently Asked Questions</h2>
                    <p>If you can't find the answer for your question here, drop me an ingame mail</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="panel-group" id="accordion">
                    <div class="panel">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true">Who can read my messages and data?</a>
                        </h4>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <p>If you are using this via Telegram, then noone, and if you are using Messenger, then page admins can. Currently the only admin is me, Veetor Nara and you have my word I won't read it.</p>
                        </div>
                    </div>
                    <div class="panel">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Is it not botting?</a>
                        </h4>
                        <div id="collapse2" class="panel-collapse collapse">
                            <p>No, the bot only gives simple commands via the <a class="btn-link" href="https://esi.evetech.net/ui" target="_blank">EVE API</a>. It uses the same API and zKillboard to get data. The rest is just clever combination of those resources. </p>
                        </div>
                    </div>
                    <div class="panel">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">I still have second thoughts about this</a>
                        </h4>
                        <div id="collapse3" class="panel-collapse collapse">
                            <p>I know the word of a capsuleer is not always enough so here is what I have done over the years where you could have heard about me:
                                <ul>
                                    <li>You might have met me in Gallente FW space</li>
                                    <li>You might have been to the Trillionare XMAS party in 2015, which was advertised by CCP Guard:
                                        <a class="btn-link" target="_blank" href="https://www.eveonline.com/article/trillionaires-xmas-party-this-saturday-dec-19">EVE News article</a></li>
                                    <li>You might have played on an old site Trillionaire, which was allowed to run for a while after IWantIsk and other sites were banned.</li>
                                <li>I was teaching newcomers to become pirates (with.. mixed success: <a href="https://zkillboard.com/corporation/98359883/" class="btn-link" target="_blank">Jumpstart Academy [JMPS]</a>)</li>
                                <li>You might have used the ship painter application <a href="https://eve-nt.uk/designer" class="btn-link" target="_blank">EVE_NT Designer</a></li>
                                <li>I am a member of the EVE_NT staff, if you watched any Alliance Tournaments you probably saw my work as most of the fit displays, graphs, voting screens, profile screens were designed by me</li>
                                <li>The source code for this service is available on <a href="https://https://github.com/molbal/Eve-Copilot" class="btn-link" target="_blank">GitHub</a> </li>
                            </ul>
                            </p>
                        </div>
                    </div>
                    <div class="panel">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">What is the cost for this?</a>
                        </h4>
                        <div id="collapse4" class="panel-collapse collapse">
                            <p>
                                <b>This is a hobby project and it's forever free to use.</b> However, if you would like to contribute to the server upkeep that is very welcome:
                            </p>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                <input type="hidden" name="cmd" value="_donations"/>
                                <input type="hidden" name="business" value="TZX5GJQA4USZQ"/>
                                <input type="hidden" name="currency_code" value="EUR"/>
                                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"
                                       border="0" name="submit" title="PayPal - The safer, easier way to pay online!"
                                       alt="Donate with PayPal button"/>
                                <img alt="" border="0" src="https://www.paypal.com/en_HU/i/scr/pixel.gif" width="1" height="1"/>
                            </form>

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
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                <div class="page-title">
                    <h2>Creators</h2>
                    <p>Who is responsible for this?</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="single-blog">
                    <div class="blog-photo">
                        <img src="https://images.evetech.net/characters/93940047/portrait?size=512" alt="">
                    </div>
                    <div class="blog-content">
                        <h3><a href="javascript:void(0)">Veetor Nara</a></h3>
                        <ul class="blog-meta">
                            <li><span class="ti-user"></span> <a href="#">FC & DPS</a></li>
                        </ul>
                        <p>Hello, I am Veetor Nara (IRL Balint Molnar) and I made this. <br>You can talk to me on <a href="https://twitter.com/veetor_in_eve" class="btn-link" target="_blank"><i class="ti-twitter"></i> Twitter</a></p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="single-blog">
                    <div class="blog-photo">
                        <img src="https://images.evetech.net/types/1529/render" alt="">
                    </div>
                    <div class="blog-content">
                        <h3><a href="javascript:void(0)">EVE Online Community</a></h3>
                        <ul class="blog-meta">
                            <li><span class="ti-user"></span> <a href="#">Support & Reps</a></li>
                        </ul>
                        <p>Thank you Squizz for letting this service rely on zKillboard stats</p>
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
                        <input type="hidden" name="cmd" value="_donations"/>
                        <input type="hidden" name="business" value="TZX5GJQA4USZQ"/>
                        <input type="hidden" name="currency_code" value="EUR"/>
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"
                               border="0" name="submit" title="PayPal - The safer, easier way to pay online!"
                               alt="Donate with PayPal button"/>
                        <img alt="" border="0" src="https://www.paypal.com/en_HU/i/scr/pixel.gif" width="1" height="1"/>
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
                    <p><a class="white" href="{{route("privacy")}}">Privacy policy</a></p>
                    <p class="text-justify" style="font-size: 0.95rem">All images are material are property of CCP
                        Games: EVE Online and the EVE logo are the registered trademarks of CCP hf. All rights are
                        reserved worldwide. All other trademarks are the property of their respective owners. EVE
                        Online, the EVE logo, EVE and all associated logos and designs are the intellectual property of
                        CCP hf. All artwork, screenshots, characters, vehicles, storylines, world facts or other
                        recognizable features of the intellectual property relating to these trademarks are likewise the
                        intellectual property of CCP hf. CCP hf. has granted permission to evewho.com to use EVE Online
                        and all associated logos and designs for promotional and zKillboard.com purposes on its website
                        but does not endorse, and is not in any way affiliated with, zKillboard.com. CCP is in no way
                        responsible for the content on or functioning of this website, nor can it be liable for any
                        damage arising from the use of this website.</p>
                    <p class="text-justify" style="font-size: 0.95rem">Contributions by <a href="https://colorlib.com"
                                                                                           target="_blank"
                                                                                           rel="nofollow">Colorlib</a>
                        and <a href="https://icons8.com" target="_blank" rel="nofollow">Icons8</a> - thank you.</p>
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

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-86961430-7');
</script>

<script type="text/javascript">

    function copyToClipboard(strToCopy) {
        console.log(strToCopy);
        // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var origSelectionStart, origSelectionEnd;
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "fixed";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = strToCopy;
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);

        // copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch (e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        target.textContent = "";
        return succeed;
    }

    $(function () {
        $('code').each(function () {
            $(this).click(function () {
                copyToClipboard($(this).text());
                alert( $(this).text() + " copied to clipboard.");
            });

           $(this)
               .attr("title", "Click to copy to clipboard")
               .attr("data-placement", "top");
        });

        setTimeout(function () {
            $('code').tooltip();
        }, 200);
    });


</script>

</body>

</html>
