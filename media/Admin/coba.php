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

    echo $classPopular->DataTerbanyak();

?>