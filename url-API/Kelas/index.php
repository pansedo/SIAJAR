<?php
require("../../setting/connection.php");

$method	= $_REQUEST;
$table  = $db->kelas;
$table2 = $db->anggota_kelas;

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

	if($method['action'] == 'showList'){
        $catch  = $table2->find(array("id_user" => $method['ID']));
		$count  = $catch->count();
		if($count > 0){
			foreach ($catch as $row) {
				// $data[]   = $row;
				$id_kelas	= new MongoId($row['id_kelas']);
				$catch2 	= $table->find(array("_id" => $id_kelas));
				// $catch2 	= $table->find(array('$or' => array(
													// array("_id" => $id_kelas),
													// array("creator"=>$method['ID'])
											// )));
				foreach ($catch2 as $row2) {
					$data[]   = $row2;
				}
				$count  = $catch2->count();
			}
		}else{
			$data	= [];
		}
		// $count  = $catch->count();
        $resp   = array('count'=>$count, 'data'=>$data);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

	if($method['action'] == 'lockKelas'){
        $ID     = $method['ID'];
        $userID = $method['user'];
        $catch  = $table->findOne(array("_id" => new MongoId($ID), "creator"=> $userID));
        if (isset($catch['_id'])) {
            if($catch['status'] == 'LOCKED'){
                $update     = array('$set' => array("status"=>"", "date_modified"=>date('Y-m-d H:i:s')));
                $message    = "Kelas berhasil dibuka.";
            }else {
                $update     = array('$set' => array("status"=>"LOCKED", "date_modified"=>date('Y-m-d H:i:s')));
                $message    = "Kelas berhasil dikunci.";
            }

            try {
                $table->update(array("_id" => new MongoId($ID)), $update);
                $status     = "Success";
            } catch(MongoCursorException $e) {
                $status     = "Failed 1.";
            }
        } else {
            $status     = "Failed 2.";
        }

        $resp   = array('status'=>$status, "message"=>$message);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'removeAnggota'){
        $delete = array("id" => new MongoId($method['ID']));
        $data   = $table->remove($delete);
        $resp   = array('response'=>'Terhapus!', 'message'=>'Data berhasil dihapus!', 'icon'=>'success');
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'cPriv'){
        $ID     = $method['ID'];
        $priv   = $method['hak_akses'];
        $kelas  = $method['kelas'];
        $update     = array('$set' => array("status"=>$priv));

        try {
            $table2->update(array("id_user" => $ID, "id_kelas" => $kelas), $update);
            $status     = "Success";
            $message    = "Hak Akses Berubah.";
            $icon       = "success";
        } catch(MongoCursorException $e) {
            $status     = "Failed 1.";
            $message    = "Gagal Berubah.";
            $icon       = "error";
        }

        $resp   = array("status"=>$status, "message"=>$message, "icon"=>$icon);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}
}

?>
