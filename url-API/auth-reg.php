<?php
    session_start();
    require("../setting/connection.php");

    $method	= $_REQUEST;
    $table  = $db->user;

    if($method['status'] == 'siswa'){
        $nama       = mysql_escape_string(trim(strip_tags(stripslashes($method['nama_siswa']))));
        $username   = mysql_escape_string(trim(strip_tags(stripslashes($method['username_siswa']))));
        $password   = mysql_escape_string(trim(strip_tags(stripslashes($method['password_siswa']))));
    }else{
        $nama       = mysql_escape_string(trim(strip_tags(stripslashes($method['nama_guru']))));
        $username   = mysql_escape_string(trim(strip_tags(stripslashes($method['username_guru']))));
        $password   = mysql_escape_string(trim(strip_tags(stripslashes($method['password_guru']))));
    }

    $options = [
        'cost' => 12,
    ];
    $pass   = password_hash ( $password , PASSWORD_BCRYPT, $options );

    $data   = $table->findOne(['username' => $username]);

    if (!is_null($data)) {
        $resp = array('response'=>'Error!', 'message'=>'Username sudah digunakan silakan menggunakan username lainnya!', 'icon'=>'error');
    }else{
        if($method['status'] == 'siswa'){
            $query  = $db->kelas->findOne(array("kode" => $method['kode_kelas']));
            if (!isset($query['_id'])) {
                $resp = array('response'=>'Error!', 'message'=>'Maaf, tidak ada kelas dengan kode tersebut!', 'icon'=>'error');
            }else{
                $id_kelas   = $query['_id'];
                $query      = array("username" => $username, "password" => $pass,"nama"=>$nama,"email"=>'',"jk"=>'',"sekolah"=>'',"status"=>$method['status'],"sosmed" => array('facebook' => '', 'website' => '','linkedin' => '','twitter' => '' ), "date_created" => date("d-M-Y H:i:s"),"date_modified"=>'', "foto"=>'');
                $insert     = $table->insert($query);

                if ($insert) {
                    $IDUser= $query['_id'];
                    $_SESSION['lms_id']             = $IDUser;
                    $_SESSION['lms_username']       = $username;
                    $_SESSION['lms_name']           = $nama;
                    $_SESSION['lms_status']         = $method['status'];

                    $relation   = $db->anggota_kelas->insert( array( "id_user"=>"$IDUser", "id_kelas"=>"$id_kelas", "status"=>"4", "date_modified"=>date('Y-m-d H:i:s') ) );

                    $resp = array('response'=>'Success!', 'message'=>'Registrasi Berhasil !', 'icon'=>'success');
                }else{
                    $resp = array('response'=>'Error!', 'message'=>'Registrasi Gagal!', 'icon'=>'error');
                }
            }
        }else{
            $query  = array("username" => $username, "password" => $pass,"nama"=>$nama,"email"=>'',"jk"=>'',"sekolah"=>'',"status"=>$method['status'],"sosmed" => array('facebook' => '', 'website' => '','linkedin' => '','twitter' => '' ), "date_created" => date("d-M-Y H:i:s"),"date_modified"=>'', "foto"=>'');
            $insert = $table->insert($query);

            if ($insert) {
                $IDUser= $query['_id'];
                $_SESSION['lms_id']             = $IDUser;
                $_SESSION['lms_username']       = $username;
                $_SESSION['lms_name']           = $nama;
                $_SESSION['lms_status']         = $method['status'];
                $resp = array('response'=>'Success!', 'message'=>'Registrasi Berhasil !', 'icon'=>'success');
            }else{
                $resp = array('response'=>'Error!', 'message'=>'Registrasi Gagal!', 'icon'=>'error');
            }
        }
    }

	$Json   = json_encode($resp);
	header('Content-Type: application/json');

	echo $Json;
?>
