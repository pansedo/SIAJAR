<?php
    session_start();
    ob_start(); 
	// error_reporting(0); 
	include '../Connection/connection.php';
     
    spl_autoload_register(function ($class) {
      include '../Controller/' .$class . '.php';
    });

	if (!isset($_SESSION['lms_id']) && !isset($_SESSION['lms_username']) && !isset($_SESSION['lms_status'])) {
        header("Location:../Auth/logout.php");
        exit();
    }elseif($_SESSION['lms_status'] == "admin"){
    	set_time_limit(10000); 
        $id_users   = $_SESSION['lms_id'];
        $email    = $_SESSION['lms_username'];
        $status     = $_SESSION['lms_status'];
    }else{ 
         header("Location:../Auth/logout.php");
        exit();

    }

?>  


<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>ADMIN - MEDIA SEAMOLEC</title>
	<link rel="stylesheet" href="../Assets/css/lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../Assets/css/lib/lobipanel/lobipanel.min.css">
	<link rel="stylesheet" href="../Assets/css/separate/vendor/lobipanel.min.css">
	<link rel="stylesheet" href="../Assets/css/lib/jqueryui/jquery-ui.min.css">
	<link rel="stylesheet" href="../Assets/css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="../Assets/css/separate/vendor/select2.min.css">
	<link rel="stylesheet" href="../Assets/css/separate/pages/widgets.min.css">
	<link rel="stylesheet" href="../Assets/css/lib/font-awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../Assets/css/main.css">
	<link rel="stylesheet" href="../Assets/css/style_manual.css"> 
	<link rel="stylesheet" href="../Assets/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../Assets/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="../Assets/css/separate/vendor/tags_editor.min.css">

		<!--Sweetalert-->
	<script  src="../Assets/js/lib/sweetalert/sweetalert2.min.js"></script>
	<link rel="stylesheet"  href="../Assets/js/lib/sweetalert/sweetalert2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>


	<link rel="stylesheet" type="text/css" href="../Assets/css/lib/uploadfile/component.css" />
	<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
</head>

<body class="with-side-menu-compact">
	<header class="site-header">
	    <div class="container-fluid">
	        <a href="#" class="site-logo">
	            <img class="hidden-md-down" src="../Assets/img/logo-2.png" alt="">
	            <img class="hidden-lg-up" src="../Assets/img/logo-2.png" alt="">
	        </a>
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">
	                      <div class="dropdown dropdown-notification notif">
	                        <a href="#"
	                           class="header-alarm dropdown-toggle active"
	                           id="dd-notification"
	                           data-toggle="dropdown"
	                           aria-haspopup="true"
	                           aria-expanded="false">
	                            <i class="font-icon-alarm"></i>
	                        </a>
	                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
	                            <div class="dropdown-menu-notif-header">
	                                Notifications
	                                <span class="label label-pill label-danger">4</span>
	                            </div>
	                            <div class="dropdown-menu-notif-list">
	                                <div class="dropdown-menu-notif-item">
	                                    <div class="photo">
	                                        <img src="img/photo-64-1.jpg" alt="">
	                                    </div>
	                                    <div class="dot"></div>
	                                    <a href="#">Morgan</a> was bothering about something
	                                    <div class="color-blue-grey-lighter">7 hours ago</div>
	                                </div>
	                            </div>
	                            <div class="dropdown-menu-notif-more">
	                                <a href="#">See more</a>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                            <img src="../Assets/img/avatar-2-64.png" alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
	                            <a class="dropdown-item" href="Index.php"><span class="font-icon glyphicon glyphicon-home"></span>Home</a>
	                            <a class="dropdown-item" href="Profile.php"><span class="font-icon glyphicon glyphicon-user"></span>Profile</a>
	                            <a class="dropdown-item" href="Setting.php"><span class="font-icon glyphicon glyphicon-cog"></span>Settings</a>
	                            <div class="dropdown-divider"></div>
	                            <a class="dropdown-item" href="../Auth/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Logout</a>
	                        </div>
	                    </div>
	                </div>
	                <div class="mobile-menu-right-overlay"></div>
	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->