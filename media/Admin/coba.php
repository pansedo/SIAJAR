<?php
 session_start();
    ob_start(); 

	include '../Connection/connection.php';
     
    spl_autoload_register(function ($class) {
      include '../Controller/' .$class . '.php';
    });

    $classMedia = new Media();
    // $text = "haha";
    // $tes = $classMedia->SearchData($text);
    // $tes = $classMedia->accentToRegex($text);
    $classPopular = new Popular();

    // $x =  $classPopular->DataTerbanyak();
    // foreach ($x as $key) {
    // 	 echo $key['nama_user'];
    // 	 echo $key['count'];
    // }
    // $x = $classPopular->TagTerbanyak();
    // foreach ($x as $key) {
    // 	echo $key['_id'];
    // }
    // 	print_r($x);

    $x = $classMedia->classMediaByKategori("591012131192a6dc1800002a");
   
?>