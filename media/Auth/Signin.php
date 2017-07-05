<?php
    session_start();
    include '../Connection/connection.php';
    
    spl_autoload_register(function ($class) {
      include '../Controller/' .$class . '.php';
    });

    $ClassLogin = new Login();
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Learning Magement System</title>

	<link href="../Assets/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="../Assets/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="../Assets/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="../Assets/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="../Assets/img/favicon.png" rel="icon" type="image/png">
	<link href="../Assets/img/favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" href="../Assets/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="../Assets/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../Assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/css/main.css">
    <script src="../Assets/js/lib/jquery/jquery.min.js"></script>
    <!--Sweetalert-->
    <script  src="../Assets/js/lib/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet"  href="../Assets/js/lib/sweetalert/sweetalert2.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
</head>
<body>
<?php
    if (isset($_POST['login'])) {
        $username = mysql_escape_string(trim(strip_tags(stripslashes($_POST['username']))));
        $password = mysql_escape_string(trim(strip_tags(stripslashes($_POST['password']))));
        $ClassLogin->LoginUsers($username,$password);
    }
?>  
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form action="" method="post" class="sign-box">
                    <div class="sign-avatar">
                        <img src="../Assets/img/avatar-sign.png" alt="">
                    </div>
                    <header class="sign-title">Sign In</header>
                    <div class="form-group">
                        <input type="text" name="username" placeholder="username" class="form-control" required>
                    </div> 
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <div class="checkbox float-left">
                           <input type="checkbox" name="autologin" value="1" id="signed-in" >
                            <label for="signed-in">Keep me signed in</label>
                        </div>
                         <div class="float-right reset">
                            <a href="reset-password.html">Reset Password</a>
                        </div>
                    </div>
                     <input type="submit" value='Sign in' name='login' class="btn btn-rounded">
                    <p class="sign-note">Belum mempunyai akun? <a href="Signup.php">Daftar</a></p>
                </form>
            </div>
        </div>
    </div>



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