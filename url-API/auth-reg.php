<?php
    session_start();
    require("../setting/connection.php");

    $method	= $_REQUEST;
    $table  = $db->user;

    if(isset($method['submit_guru'])){
        $resp = array('response'=>'Guru', 'message'=>"$method['submit_guru']", 'icon'=>'error');
    }
    if(isset($method['submit_siswa'])){
        $resp = array('response'=>'Siswa', 'message'=>"$method['submit_siswa']", 'icon'=>'error');
    }

    $Json   = json_encode($resp);
    header('Content-Type: application/json');

    echo $Json;
?>
