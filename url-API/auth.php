<?php
session_start();
require("../setting/connection.php");

$method	= $_REQUEST;
$table  = $db->user;

if(isset($method['action'])){
    if($method['action'] == 'login'){
        $username = mysql_escape_string(trim(strip_tags(stripslashes($method['username']))));
        $password = mysql_escape_string(trim(strip_tags(stripslashes($method['password']))));

        $data   = $table->findOne(['username' => $username]);
        if (!is_null($data)) {
            $hash = $data['password'];
            if(password_verify($password,$hash)){
                $_SESSION['lms_id']             = $data['_id'];
                $_SESSION['lms_username']       = $data['username'];
                $_SESSION['lms_name']           = $data['nama'];
                $_SESSION['lms_status']         = $data['status'];

                $resp = array('response'=>'Success!', 'message'=>'Berhasil Login !', 'icon'=>'success');
            }else{
                $resp = array('response'=>$password, 'message'=>'Kata sandi yang anda masukkan Salah!', 'icon'=>$username);
                // $resp = array('response'=>'Gagal!', 'message'=>'Kata sandi yang anda masukkan Salah!', 'icon'=>'error');
            }
        }else{
            $resp = array('response'=>'Error!', 'message'=>'Maaf, akun anda belum terdaftar!', 'icon'=>'error');
        }
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}
}

?>
