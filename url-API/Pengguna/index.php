<?php
require("../../setting/connection.php");

$method	= $_REQUEST;
$table  = $db->user;

if(isset($method['action'])){
    if($method['action'] == 'show'){
        $ID     = new MongoId($method['ID']);
        $data   = $table->findOne(array("_id" => $ID));
        $resp   = array('data'=>$data);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'forgot'){
        $userID = new MongoRegex("/^$method[name]/i");
        $data   = $table->findOne( array(
                                        '$or' => array(
                                                    array("email" => $userID),
                                                    array("username" => $userID)
                                                )
                                        )
                                    );
        if (!empty($data)) {
            require '../../assets/js/lib/PHPMailer/PHPMailerAutoload.php';

            $karakter   = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $hasil      = '';
            for ($i=0; $i < 8; $i++) {
                $acak   = rand(0, strlen($karakter)-1);
                $hasil  .= $karakter{$acak};
            }
            $options = [
                'cost' => 12,
            ];
            $pass   = password_hash ( $hasil , PASSWORD_BCRYPT, $options );

            $update     = array('$set' => array("password"=>$pass, "date_modified"=>date('Y-m-d H:i:s')));

            try {
                $table->update(array("_id" => new MongoId($data['_id'])), $update);
                $status   = "success";
            } catch(MongoCursorException $e) {
                $status   = "error";
            }

            if ($status == 'success') {
                $mail = new PHPMailer;

    			$mail->setFrom('etraining@mailseamolec.org', 'SIAJAR LMS');
    			$mail->addReplyTo('etraining@mailseamolec.org', 'SIAJAR LMS');

    			//Replace the plain text body with one created manually
    			$mail->AltBody = 'This is a plain-text message body';

    			$mail->Subject = "Atur ulang kata sandi SIAJAR LMS";
    			$msg  = "<html><body style='font-size: 100%; border: 2px solid #000; border-radius: 5px; padding: 25px;'>";
    			$msg .= "Kata Sandi SIAJAR LMS anda sudah diganti,<br />
    					<hr style='width: 100%'><br />
    					<p>Saat ini kata sandi untuk masuk ke dalam SIAJAR LMS anda telah diganti menjadi <b><u>$hasil</u></b>. Silahkan gunakan kata sandi tersebut, kemudian silahkan langsung ubah kata sandi pada menu Profil untuk memudahkan anda masuk kembali ke SIAJAR LMS.</p>
    					<br />
    					Bila kata sandi diatas tidak dapat digunakan, silahkan hubungi kontak yang tertera pada halaman awal SIAJAR LMS<br />
    					Terima Kasih.<br />
    					<br />
    					<hr style='width: 100%'>
    					<a href='$_SERVER[SERVER_NAME]'>SIAJAR LMS</a><br />
    					<hr style='width: 100%'>";
    			$msg .= "</body></html>";

    			$mail->addAddress($data['email'], $data['nama']);
    			$mail->msgHTML($msg);

    			// if (!$mail->send()) {
    			// 	// $response = array('response'=>'Failed', 'message'=>'Email tidak dikirim dikarenakan '. $mail->ErrorInfo);
    			// 	$response = array('response'=>'Gagal', 'message'=>'Penggantian kata sandi tidak berhasil! '.$mail->ErrorInfo, 'icon'=>'error');
    			// } else {
    			// 	$response = array('response'=>'Sukses', 'message'=>'Selamat, Proses penggantian kata sandi berhasil! Silahkan periksa Inbox ataupun Spam pada email untuk melihat kata sandi baru!', 'icon'=>'success');
    			// }
	               $response = array('response'=>'Sukses '.$hasil, 'message'=>'Selamat, Proses penggantian kata sandi berhasil! Silahkan periksa Inbox ataupun Spam pada email untuk melihat kata sandi baru!', 'icon'=>'success');
    			$mail->clearAddresses();
            }else {
                $response = array('response'=>'Gagal', 'message'=>'Penggantian kata sandi tidak berhasil!', 'icon'=>'error');
            }

        }else {
            $response = array('response'=>'Maaf', 'message'=>'Email / NIK yang anda masukkan tidak terdaftar!', 'icon'=>'error');
        }

        // $resp   = array('data'=>$data);
        $Json   = json_encode($response);
        header('Content-Type: application/json');

        echo $Json;

	}

    if($method['action'] == 'showAll'){
        $catch  = $table->find(array());
        foreach ($catch as $row) {
            $data[]   = $row;
        }
        $count  = $catch->count();
        $resp   = array('count'=>$count, 'data'=>$data);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}
}

?>
