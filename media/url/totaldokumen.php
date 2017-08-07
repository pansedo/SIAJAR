<?php
  	include '../Connection/connection.php';
    spl_autoload_register(function ($class) {
      include '../Controller/' .$class . '.php';
    });
 
    $classMedia = new Media(); 
    $CountData = $classMedia->GetCountData();
	echo $CountData['dokumen'];

?>