<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ketosin | Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('main-assets/imgs/logo.png') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/login-assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="/login-assets/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form action="/login" method="POST" class="login100-form validate-form">
                    @csrf
                    <span class="login100-form-title p-b-26">
                        Selamat Datang
                    </span>
                    <span class="login100-form-title p-b-48">
                        <img src="{{ asset('main-assets/imgs/dark-logo.png') }}" style="width: 100px;height: 100px;"
                            alt="">
                    </span>

                    <div class="custom-form-group">
                        <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
                            <input class="input100" type="text" name="name">
                            <span class="focus-input100" data-placeholder="Name"></span>
                        </div>
                    </div>

                    <div class="custom-form-group">
                        <div class="wrap-input100 validate-input" data-validate="Enter password">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input class="input100" type="password" name="password">
                            <span class="focus-input100" data-placeholder="Password"></span>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="/login-assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="/login-assets/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="/login-assets/vendor/bootstrap/js/popper.js"></script>
    <script src="/login-assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="/login-assets/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="/login-assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="/login-assets/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="/login-assets/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="/login-assets/js/main.js"></script>

</body>

</html>
