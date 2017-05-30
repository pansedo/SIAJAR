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
	<title>StartUI - Premium Bootstrap 4 Admin Dashboard Template</title>

	<link href="../Assets/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="../Assets/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="../Assets/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="../Assets/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="../Assets/img/favicon.png" rel="icon" type="image/png">
	<link href="../Assets/img/favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" href="../Assets/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="../Assets/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../Assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
    <link rel="stylesheet" href="../Assets/css/separate/vendor/select2.min.css">
    <link rel="stylesheet" href="../Assets/css/main.css">

    <script src="../Assets/js/lib/jquery/jquery.min.js"></script>
    <!--Sweetalert-->
    <script  src="../Assets/js/lib/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet"  href="../Assets/js/lib/sweetalert/sweetalert2.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
</head>
<body>
<?php
if (isset($_POST['register'])) {
        $nama       = mysql_escape_string(trim(strip_tags(stripslashes($_POST['nama']))));
        $username   = mysql_escape_string(trim(strip_tags(stripslashes($_POST['username']))));
        $password   = mysql_escape_string(trim(strip_tags(stripslashes($_POST['password']))));
        $status     = mysql_escape_string(trim(strip_tags(stripslashes($_POST['status']))));
        $ClassLogin->RegisterUsers($nama,$username,$password,$status);
    }
?>

    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box" method="POST" id="form-signin_v2" style="margin-top:8%">
                    <div class="sign-avatar no-photo">&plus;</div>
                    <header class="sign-title">Sign Up</header>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required/>
                    </div>
                    <div class="form-group">
                        <select name="status" class="bootstrap-select">
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                        </select>
                    </div>
                    <input type="submit" value='Sign up' name='register' class="btn btn-rounded btn-success sign-up">
                    <p class="sign-note">Already have an account? <a href="Signin.php">Sign in</a></p>
                    <!--<button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </form>
            </div>
        </div>
    </div><!--.page-center-->

    <script src="../Assets/js/lib/tether/tether.min.js"></script>
    <script src="../Assets/js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="../Assets/js/lib/jquery-tag-editor/jquery.caret.min.js"></script>
    <script src="../Assets/js/lib/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="../Assets/js/plugins.js"></script>
    <script src="../Assets/js/app.js"></script>

</body>
</html>