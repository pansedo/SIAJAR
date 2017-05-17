<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>StartUI - Premium Bootstrap 4 Admin Dashboard Template</title>

    <link href="../Assets/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="../Assets/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="../Assets/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="../Assets/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="../Assets/img/favicon.png" rel="icon" type="image/png">
    <link href="../Assets/img/favicon.ico" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<link rel="stylesheet" href="../Assets/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="../Assets/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../Assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/css/main.css">
</head>
<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box reset-password-box">
                    <!--<div class="sign-avatar">
                        <img src="../Assets/img/avatar-sign.png" alt="">
                    </div>-->
                    <header class="sign-title">Reset Password</header>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="E-Mail or Phone"/>
                    </div>
                    <button type="submit" class="btn btn-rounded">Reset</button>
                    or <a href="Signin.php">Sign in</a>
                </form>
            </div>
        </div>
    </div><!--.page-center-->

<script src="../Assets/js/lib/jquery/jquery.min.js"></script>
<script src="../Assets/js/lib/tether/tether.min.js"></script>
<script src="../Assets/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="../Assets/js/plugins.js"></script>
    <script type="text/javascript" src="../Assets/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
<script src="../Assets/js/app.js"></script>
</body>
</html>