<?php
    include '../Connection/connection.php';
    spl_autoload_register(function ($class) {
      include '../Controller/' .$class . '.php';
    });
 
    $classRating = new Rating(); 
    if (isset($_POST['idusers'])){
    	if (isset($_POST['rate']) && isset($_POST['iddokumen'])) {
			$classRating->InsertRating($_POST['rate'],$_POST['iddokumen'],$_POST['idusers']);
		}
    }else{
    	echo "Silahkan Login Terlebih Dahulu";
    }

	
?>