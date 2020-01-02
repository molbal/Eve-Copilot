<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your EVE Co-pilot token ({{$name}})</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/token/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/token/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/token/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/token/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/token/css/util.css">
    <link rel="stylesheet" type="text/css" href="/token/css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-t-85 p-b-20">
            <form class="login100-form validate-form">
                <span class="login100-form-avatar mb-3" style="width:360px;height:141px;border-radius: 0">
						<img src="{{$avatar}}" style="height:128px;width:128px;border-radius: 50%" alt="AVATAR">
                        <span style="font-size: 72px;position: relative;top: 22px;left: 11px;">+</span>
						<img src="/images/eve/pod-1024.png" style="height:128px;width:128px;border-radius: 50%" alt="AVATAR">
					</span>
                <span class="login100-form-title p-b-5">
						{{$name}}
					</span>
                <span class="text-center p-b-4 d-block"> This is your control token: <br>
                        <code>{{$token}}</code>
                    </span>
                <span class="text-center d-block"><small>You can now return to the chat with this code.</small></span>

                <span class="d-block p-t-250 text-center">
                    You can return to the <a href="/">homepage</a> after you used the token. <br>
                    One code can be used only once. <br>
                    Logging in with EVE Online removes the previous code set for this character.
                </span>


            </form>
        </div>
    </div>
</div>


<script src="/token/vendor/bootstrap/js/popper.js"></script>
<script src="/token/vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>