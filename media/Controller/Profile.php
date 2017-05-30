<?php
/** Rifai
//Rifai Lagi
*/
class Profile
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

	public function GetData($id_profile) {
        $criteria = array('_id' => new MongoId($id_profile));
		$getprofile = $this -> table -> findOne($criteria);

		return $getprofile; 
	}

    public function UpdateProfile($id_profile, $password,$username,$nama,$email,$jenis_kelamin,$sekolah,$status,$foto){
        global $db;
        
        $update = array("username"=>$username,"password"=>$password, "nama"=>$nama,  "email"=>$email, "jk"=>$jenis_kelamin, "sekolah"=>$sekolah, "status"=>$status, "foto"=>$foto);
        $sukses = $this -> table -> update(array("_id"=> new MongoId($id_profile)),array('$set'=>$update));
        if ($sukses) {
            # code...
            echo "<script type='text/javascript'> swal({
                                  title: 'Berhasil diperbarui!',
                                  text: 'Profil anda berhasil diperbarui',
                                  type: 'success',
                                  timer: 2000
                                }).then(
                                  function () {
                                    document.location.href='profile.php';
                                  },
                                  function (dismiss) {
                                    document.location.href='profile.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                </script>";
        }else{
            echo "<script type='text/javascript'> swal({
                                  title: 'Gagal diperbarui!',
                                  text: 'Profil anda gagal diperbarui',
                                  type: 'error',
                                  timer: 2000
                                }).then(
                                  function () {
                                    document.location.href='profile.php';
                                  },
                                  function (dismiss) {
                                    document.location.href='profile.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                </script>";
        }
        
    }

    public function CheckPassword($id_profile, $password, $password_baru, $pasword_confirm,$username,$nama,$email,$jenis_kelamin,$sekolah,$status,$foto){
        global $db;
        $getusers = $this -> table -> findOne(['_id' => $id_profile]);
        if (!is_null($getusers)) {
            $hash = $getusers['password'];
            // echo $hash;
            if(password_verify($password,$hash)){
                 if ($password_baru == $pasword_confirm) {
                     # code...
                   
                    $options = [
                        'cost' => 12,
                    ];
                    $pass = password_hash ( $password_baru , PASSWORD_BCRYPT, $options );

                    $update = array("username"=>$username,"password"=>$pass, "nama"=>$nama,  "email"=>$email, "jk"=>$jenis_kelamin, "sekolah"=>$sekolah, "status"=>$status, "foto"=>$foto);
                    // echo "update = array(username=>$username,password=>$pass, 'nama'=>$nama,  'email'=>$email, 'jk'=>$jenis_kelamin, 'sekolah'=>$sekolah, 'status'=>$status, 'foto'=>$foto)";
                    $sukses=$this -> table -> update(array("_id"=> $id_profile),$update);
                    if ($sukses) {
                        # code...
                        echo "<script type='text/javascript'> swal({
                                  title: 'Berhasil diperbarui!',
                                  text: 'Kata Sandi anda berhasil diperbarui',
                                  type: 'success',
                                  timer: 2000
                                }).then(
                                  function () {
                                    document.location.href='profile.php';
                                  },
                                  function (dismiss) {
                                    document.location.href='profile.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                            </script>";
                    }else{
                        echo "<script type='text/javascript'> swal({
                                  title: 'Gagal diperbarui!',
                                  text: 'Kata Sandi anda gagal diperbarui',
                                  type: 'error',
                                  timer: 2000
                                }).then(
                                  function () {
                                    document.location.href='profile.php';
                                  },
                                  function (dismiss) {
                                    document.location.href='profile.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                            </script>";
                    }

                 }else{
                    echo "<script type='text/javascript'> swal({
                                  title: 'Gagal diperbarui!',
                                  text: 'Kata sandi baru yang anda masukan tidak sama.',
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
                                  title: 'Gagal diperbarui!',
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
            echo '<script type="text/javascript"> alert("Username Anda Tidak ditemukan")</script>';
        }
    }



    public function UpdateProfileFoto($id_profile, $password,$username,$nama,$email,$jenis_kelamin,$sekolah,$status,$foto,$foto_size,$foto_tmp,$foto_ext,$foto_lama){


            $format = array("jpg", "jpeg", "png", "gif", "bmp");


            if(in_array(strtolower($foto_ext), $format))
            {
                $foto_name    = substr(md5(time()), 0, 9).'_'.date('dmYHIs').".".$foto_ext;
                $folderDest   ='Assets/foto/'.$foto_name;

                // echo "move_uploaded_file($foto_tmp, $folderDest)";
                
                    if(move_uploaded_file($foto_tmp, $folderDest) )
                    {                    // mengganti File Permission
                        $lama = 'Assets/foto/'.$foto_lama;
                        if (file_exists($lama)) {
                            # code...
                            chmod('Assets/foto/', 0777);
                            unlink($lama);
                        }
                        chmod($folderDest, 0744);

                        // Update Data
                        
                        $update = array("username"=>$username,"password"=>$password, "nama"=>$nama,  "email"=>$email, "jk"=>$jenis_kelamin, "sekolah"=>$sekolah, "status"=>$status, "foto"=>$foto_name);
                        $sukses = $this -> table -> update(array("_id"=> new MongoId($id_profile)),array('$set'=>$update));

                        if ($sukses) {
                            # code...
                            echo "<script type='text/javascript'> swal({
                                                                      title: 'Berhasil diperbarui!',
                                                                      text: 'Profil anda berhasil diperbarui',
                                                                      type: 'success',
                                                                      timer: 2000
                                                                    }).then(
                                                                      function () {
                                                                        document.location.href='setting.php';
                                                                      },
                                                                      function (dismiss) {
                                                                        document.location.href='setting.php';
                                                                        if (dismiss === 'timer') {
                                                                          console.log('I was closed by the timer')
                                                                        }
                                                                      })
                                </script>";
                        }
                        else
                        {
                            echo "<script type='text/javascript'> swal({
                                  title: 'Gagal diperbarui!',
                                  text: 'Profil anda gagal diperbarui',
                                  type: 'error',
                                  timer: 2000
                                }).then(
                                  function () {
                                    document.location.href='setting.php';
                                  },
                                  function (dismiss) {
                                    document.location.href='setting.php';
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  })
                </script>";
                        }
                    }
                    else
                    {
                        echo "<script type='text/javascript'> swal({
                                  title: 'Gagal diunggah!',
                                  text: 'Fotp profil anda gagal diunggah cek kembali ukuran file dan koneksi internet anda!',
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
            else
            {
                echo "<script type='text/javascript'> swal({
                                  title: 'Gagal diunggah!',
                                  text: 'Jenis File tidak didukung!',
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
            
            // if($surat_rujukan['name'] == ""){
            //     $ext_2 = "pdf";
            //     $surat_rujukan_size = 100;
            // }else{
            //     $ext_2 = pathinfo($surat_rujukan_name, PATHINFO_EXTENSION);
            // }
            // $ext_3 = pathinfo($akta_kelahiran_name, PATHINFO_EXTENSION);
            // $ext_4 = pathinfo($kartu_keluarga_name, PATHINFO_EXTENSION);

            // Cek ekstensi File berdasarkan Ekstensi-nya


}


?>