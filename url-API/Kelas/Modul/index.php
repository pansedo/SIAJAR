<?php
require("../../../setting/connection.php");

$method	= $_REQUEST;
$table  = $db->modul;

if(isset($method['action'])){
    if($method['action'] == 'show'){
        $ID     = new MongoId($method['ID']);
        $data   = $table->findOne(array("_id" => $ID));
        $resp   = array('data'=>$data);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'showAll'){
        $catch  = $table->find(array("id_mapel" => $method['IDKelas']));
        foreach ($catch as $row) {
            $data[]   = $row;
        }
        $count  = $catch->count();
        $resp   = array('count'=>$count, 'data'=>$data);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'remv'){
        $delete = array("_id" => new MongoId($method['ID']));
        $data   = $table->remove($delete);
        $resp   = array('response'=>'Terhapus!', 'message'=>'Data berhasil dihapus!', 'icon'=>'success');
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'updtNMateri'){
        $siswa  = $method['s'];
        $modul  = $method['i'];
        $nilai  = $method['n'];

        $cekNilai   = $db->modul_kumpul->findOne(array('id_modul'=>$modul, 'id_user'=>$siswa));
        if ($cekNilai['nilai']) {
            $update = array("nilai" => $nilai, "date_modified"=>date('Y-m-d H:i:s'));
            $sukses = $db->modul_kumpul->update(array("id_user"=> $siswa, "id_modul"=>$modul), array('$set'=>$update));

            $status = $sukses ? array('response'=>'Berhasil!', 'message'=>'Data berhasil disimpan m1!', 'icon'=>'success') : array('response'=>'Maaf!', 'message'=>'Data tidak tersimpan!', 'icon'=>'error');
            $Json   = json_encode($status);
    		header('Content-Type: application/json');

    		echo $Json;
        }else {
            $insert = array("id_user"=>$siswa, "id_modul"=>$modul, "nilai"=>$nilai, "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                      $db->modul_kumpul->insert($insert);

            $status = $insert ? array('response'=>'Berhasil!', 'message'=>'Data berhasil disimpan m2!', 'icon'=>'success') : array('response'=>'Maaf!', 'message'=>'Data tidak tersimpan!', 'icon'=>'error');
            $Json   = json_encode($status);
    		header('Content-Type: application/json');

    		echo $Json;
        }
    }

    if($method['action'] == 'updtNTugas'){
        $siswa  = $method['s'];
        $tugas  = $method['i'];
        $nilai  = $method['n'];

        $cekNilai   = $db->tugas_kumpul->findOne(array("id_tugas"=>"$tugas", "id_user"=>"$siswa"));
        if ($cekNilai['nilai']) {
            $update = array("nilai" => $nilai, "date_modified"=>date('Y-m-d H:i:s'));
            $sukses = $db->tugas_kumpul->update(array("id_user"=>"$siswa", "id_tugas"=>"$tugas"), array('$set'=>$update));

            $status = $sukses ? array('response'=>'Berhasil!', 'message'=>'Data berhasil disimpan t1!', 'icon'=>'success') : array('response'=>'Maaf!', 'message'=>'Data tidak tersimpan!', 'icon'=>'error');
            $Json   = json_encode($status);
    		header('Content-Type: application/json');

    		echo $Json;
        }else {
            $insert = array("id_user"=>"$siswa", "id_tugas"=>"$tugas", "nilai"=>$nilai, "catatan"=>"", "file"=>"", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                      $db->tugas_kumpul->insert($insert);

            $status = $insert ? array('response'=>'Berhasil!', 'message'=>'Data berhasil disimpan t2!', 'icon'=>'success') : array('response'=>'Maaf!', 'message'=>'Data tidak tersimpan!', 'icon'=>'error');
            $Json   = json_encode($status);
    		header('Content-Type: application/json');

    		echo $Json;
        }
    }

    if($method['action'] == 'updtNUjian'){
        $siswa  = $method['s'];
        $ujian  = $method['i'];
        $nilai  = $method['n'];

        $cekNilai   = $db->kumpul_quiz->findOne(array('id_quiz'=>$ujian, 'id_user'=>$siswa));
        if ($cekNilai['nilai']) {
            $update = array("nilai" => $nilai, "date_modified"=>date('Y-m-d H:i:s'));
            $sukses = $db->kumpul_quiz->update(array("id_user"=> $siswa, "id_quiz"=>$ujian), array('$set'=>$update));

            $status = $sukses ? array('response'=>'Berhasil!', 'message'=>'Data berhasil disimpan u1!', 'icon'=>'success') : array('response'=>'Maaf!', 'message'=>'Data tidak tersimpan!', 'icon'=>'error');
            $Json   = json_encode($status);
    		header('Content-Type: application/json');

    		echo $Json;
        }else {
            $insert = array("id_user"=>$siswa, "id_quiz"=>$ujian, "nilai"=>$nilai, "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                      $db->kumpul_quiz->insert($insert);

            $status = $insert ? array('response'=>'Berhasil!', 'message'=>'Data berhasil disimpan u2!', 'icon'=>'success') : array('response'=>'Maaf!', 'message'=>'Data tidak tersimpan!', 'icon'=>'error');
            $Json   = json_encode($status);
    		header('Content-Type: application/json');

    		echo $Json;
        }
    }

}

?>
