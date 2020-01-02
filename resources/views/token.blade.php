<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V6</title>
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
                <span class="login100-form-avatar">
						<img src="{{$avatar}}" alt="AVATAR">
					</span>
					<span class="login100-form-title p-b-70">
						Hello {{$name}}, <br> This is your token: <br>
					</span>
                    <span>
                        <code>{{$token}}</code>
                    </span>

            </form>
        </div>
    </div>
</div>


<script src="/token/vendor/bootstrap/js/popper.js"></script>
<script src="/token/vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>