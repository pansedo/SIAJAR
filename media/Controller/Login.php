<?php

class Login
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'user';
            $this->table = $db -> $tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function LoginUsers($username,$pswd)
    {
        $getusers = $this -> table -> findOne(['username' => $username]);
        if (!is_null($getusers)) {
            $hash = $getusers['password'];
            if(password_verify($pswd,$hash)){
                 if ($getusers['status'] == 'admin') {
                        $_SESSION['lms_id']             = $getusers['_id'];
                        $_SESSION['lms_username']       = $getusers['username'];
                        $_SESSION['lms_name']           = $getusers['nama'];
                        $_SESSION['lms_status']         = $getusers['status'];
                        echo "<script type='text/javascript'> swal({
                                  title: 'Berhasil!',
                                  text: 'Selamat Datang Admin!',
                                  type: 'success',
                                  timer: 2000
                                }).then(
                                  function () {
                                    document.location.href='../Admin/index.php';
                                  },
                                  function (dismiss) {
                                    document.location.href='setting.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                </script>";
                    }elseif ($getusers['status'] == 'guru') {
                        # code...
                        $_SESSION['lms_id']             = $getusers['_id'];
                        $_SESSION['lms_username']       = $getusers['username'];
                        $_SESSION['lms_name']           = $getusers['nama'];
                        $_SESSION['lms_status']         = $getusers['status'];
                        
                        echo "<script type='text/javascript'> swal({
                                  title: 'Berhasil!',
                                  text: 'Selamat Datang !',
                                  type: 'success',
                                  timer: 2000
                                }).then(
                                  function () {
                                    document.location.href='../profile.php';
                                  },
                                  function (dismiss) {
                                    document.location.href='../profile.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                            </script>";
                    }else{
                        "<script type='text/javascript'> swal({
                                  title: 'Gagal!',
                                  text: 'Anda belum terdaftar sebagai guru',
                                  type: 'error',
                                  timer: 2000
                                }).then(
                                  function () {
                                    document.location.href='Logout.php';
                                  },
                                  function (dismiss) {
                                    document.location.href='Logout.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                </script>";
                        // echo "<script language='JavaScript'>alert('Anda Belum Terdaftar !')</script>";
                        // echo "<script language=javascript> document.location.href='logout.php'; </script>";
                    }
            }else{
                echo "<script type='text/javascript'> swal({
                                  title: 'Gagal!',
                                  text: 'Kata sandi anda tidak sesuai.',
                                  type: 'error',
                                  timer: 2000
                                }).then(
                                  function () {
                                    // document.location.href='setting.php';
                                  },
                                  function (dismiss) {
                                    // document.location.href='setting.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                </script>";
            }
        }else{
            echo "<script type='text/javascript'> swal({
                                  title: 'Gagal !',
                                  text: 'Kombinasi username dan password tidak ditemukan silakan cek kembali !',
                                  type: 'error',
                                  timer: 2000
                                }).then(
                                  function () {
                                    // document.location.href='setting.php';
                                  },
                                  function (dismiss) {
                                    // document.location.href='setting.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                </script>";
        }
    }

    public function RegisterUsers($nama,$username,$password,$status)
    {
        global $db;
        $options = [
            'cost' => 12,
        ];
        $pass = password_hash ( $password , PASSWORD_BCRYPT, $options );


        $date_create = date("d-M-Y H:i:s");
        $cek_user = $this-> table -> find(['username' => $username]);
        $jml = $cek_user->count();

        if ($jml > 0) {
            echo '<script type="text/javascript"> alert("Username Sudah digunakan silakan menggunakan nama pengguna lainnya"); </script>';
        }else{
            $query = array("username" => $username, "password" => $pass,"nama"=>$nama,"email"=>'',"jk"=>'',"sekolah"=>'',"status"=>$status, "foto"=>'',"sosmed" => array('facebook' => '', 'website' => '','linkedin' => '','twitter' => '' ), "date_create" =>$date_create,"date_modify"=>'');
            $insert = $this -> table -> insert($query);
            if ($insert) {
                # code...
                $IDUser= $query['_id'];
                $_SESSION['lms_id']             = $IDUser;
                $_SESSION['lms_username']       = $username;
                $_SESSION['lms_status']         = $status;
                echo '<script type="text/javascript"> alert("Registrasi Berhasil"); document.location.href="profile.php";</script>';

            }else{
                echo '<script type="text/javascript"> alert("Registrasi Gagal"); </script>';
            }
        }
    }
}

?>