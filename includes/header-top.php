<?php
define('base_url', 'http://'.$_SERVER['SERVER_NAME'].'/siajar/');
date_default_timezone_set('Asia/Jakarta');
// error_reporting(0);
session_start();
ob_start();

if(!isset($_SESSION['lms_id']) && is_null($_SESSION['lms_id'])){
	header('Location: lms.php');
}

include 'setting/connection.php';
spl_autoload_register(function ($class) {
  include 'setting/controller/' .$class . '.php';
});

function selisih_waktu($timestamp){
    $selisih = time() - strtotime($timestamp) ;
    $detik  = $selisih ;
    $menit  = round($selisih / 60 );
    $jam    = round($selisih / 3600 );
    $hari   = round($selisih / 86400 );
    $minggu = round($selisih / 604800 );
    $bulan  = round($selisih / 2419200 );
    $tahun  = round($selisih / 29030400 );
    if ($detik <= 60) {
        $waktu = $detik.' detik yang lalu';
    } else if  ($menit <= 60) {
        $waktu = $menit.' menit yang lalu';
    } else if ($jam <= 24) {
        $waktu = $jam.' jam yang lalu';
    } else if ($hari <= 7) {
        $waktu = $hari.' hari yang lalu';
    } else if ($minggu <= 4) {
        $waktu = $minggu.' minggu yang lalu';
    } else if ($bulan <= 12) {
        $waktu = $bulan.' bulan yang lalu';
    } else {
        $waktu = $tahun.' tahun yang lalu';
    }
    return $waktu;
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SIAJAR LMS - Learning Path || <?=ucfirst($_SESSION['lms_status'])?></title>
	<link href="assets/img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="assets/css/separate/elements/player.min.css">
	<link rel="stylesheet" href="assets/css/separate/vendor/fancybox.min.css">
	<link rel="stylesheet" href="assets/css/lib/bootstrap-sweetalert/sweetalert.css">
	<link rel="stylesheet" href="assets/css/separate/pages/profile-2.min.css">
    <link rel="stylesheet" href="assets/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/separate/pages/widgets.min.css">
	<link rel="stylesheet" href="assets/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="assets/css/separate/vendor/datatables-net.min.css">
    <script src="assets/js/lib/jquery/jquery.min.js"></script>
	<script src="assets/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	<style>
		input[type="number"]::-webkit-outer-spin-button,
		input[type="number"]::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
		input[type="number"] {
			-moz-appearance: textfield;
		}
		input[type="date"]::-webkit-outer-spin-button,
		input[type="date"]::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
		input[type="date"] {
			-moz-appearance: textfield;
		}
	</style>
</head>
<body>
