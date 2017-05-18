<?php
define('base_url', 'http://localhost/siajar_lms');
date_default_timezone_set('Asia/Jakarta');
// error_reporting(0);
session_start();
ob_start();

if(!isset($_SESSION['lms_id']) && is_null($_SESSION['lms_id'])){
	header('Location: account-login.php');
}

include 'setting/connection.php';
spl_autoload_register(function ($class) {
  include 'setting/controller/' .$class . '.php';
});
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SEAMOLEC - Learning Path</title>
	<link href="assets/img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="assets/css/lib/ion-range-slider/ion.rangeSlider.css">
	<link rel="stylesheet" href="assets/css/lib/ion-range-slider/ion.rangeSlider.skinHTML5.css">
	<link rel="stylesheet" href="assets/css/separate/elements/player.min.css">
	<link rel="stylesheet" href="assets/css/separate/vendor/fancybox.min.css">
	<link rel="stylesheet" href="assets/css/separate/pages/profile-2.min.css">
    <link rel="stylesheet" href="assets/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
