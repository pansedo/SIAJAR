<?php

try
{
	$conn	= new MongoClient('127.0.0.1:27017');
	$db		= $conn->siajar_lms;
}
catch(Exception $e)
{
	// echo $e->getMessage();
	echo "An error has occured";
}
?>
