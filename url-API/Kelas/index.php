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

    if($method['action'] == 'rmv'){
        if ($method['h'] == 1) {
            // ----- REMOVE CLASSROOM
            $delete = array("_id" => new MongoId($method['ID']));
            $data   = $table->remove($delete);

            // ----- REMOVE MEMBER CLASSROOM
            $delete2    = array("id_kelas"=>$method['ID']);
            $data2      = $table2->remove($delete2);

            $resp   = array('response'=>'Terhapus!', 'message'=>'Data berhasil dihapus!', 'icon'=>'success');
        } else {
            $resp   = array('response'=>'Gagal!', 'message'=>'Anda tidak memiliki hak untuk melakukan hal ini!', 'icon'=>'error');
        }

		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'removeAnggota'){
        $delete = array("id_user" => $method['ID'], "id_kelas"=>$method['kelas']);
        $data   = $table2->remove($delete);
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

    if($method['action'] == 'cTKB'){
        $ID     = $method['ID'];
        $tkb    = $method['tkb'];
        $kelas  = $method['kelas'];
        $update     = array('$set' => array("tkb"=>$tkb));

        try {
            $table2->update(array("id_user" => $ID, "id_kelas" => $kelas), $update);
            $status     = "Berhasil";
            $message    = "Tempat Kegiatan Belajar anda sudah diubah.";
            $icon       = "success";
        } catch(MongoCursorException $e) {
            $status     = "Maaf";
            $message    = "Tempat Kegiatan Belajar anda gagal diubah.";
            $icon       = "error";
        }

        $resp   = array("status"=>$status, "message"=>$message, "icon"=>$icon);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'daftarPerkembangan'){
        $idmodul    = $method['Modul'];
        $idkelas    = $method['Kelas'];
        $nilaiModul = 0;
        $nilaiTugas = 0;
        $nilaiUjian = 0;
        $users      = array();

        $modul      = $db->modul->findOne(array("_id"=> new MongoId($idmodul)));

        $anggota    = $table2->find(array("id_kelas" => "$idkelas", "status"=> "4"));
        $no = 0;
        foreach ($anggota as $listA) {
            $user       = $db->user->findOne(array("_id" => new MongoId($listA['id_user'])));
            $user['tkb']   = $listA['tkb'];

            $cekNilaiModul  = $db->modul_kumpul->findOne(array("id_modul"=>"$idmodul", "id_user"=>$listA['id_user']));
            // --- Nilai Membaca Materi
            $nilaiModul     += $cekNilaiModul['nilai'];
            $user['nilai']['modul'] = $nilaiModul;

            $tugasModul =  $db->tugas->find(array("id_modul"=>"$idmodul"));
            $jumlahTugas = $tugasModul->count();
            if ($jumlahTugas > 0) {
                $kumpulTugas= 0;
                foreach ($tugasModul as $tugas) {
                    $cekNilaiTugas  = $db->tugas_kumpul->findOne(array("id_tugas"=>"$tugas[_id]", "id_user"=>$listA['id_user']));

                    // --- Nilai Tugas
                    $nilaiTugas     += $nilaiTugas + $cekNilaiTugas['nilai'];
                    $user['nilai']['tugas'][$kumpulTugas]   = $cekNilaiTugas['nilai'];
                    $kumpulTugas++;
                }
                // --- Nilai Rata-Rata Tugas
                $totalTugas = round(($nilaiTugas/$jumlahTugas), 2);

                $evaluasi  = $db->quiz->findOne(array('id_modul' => "$idmodul"));
                if ($evaluasi) {
                    $cekNilaiEvaluasi   = $db->kumpul_quiz->findOne(array("id_quiz"=>"$evaluasi[_id]", "id_user"=>$listA['id_user']));

                    // --- Nilai Ujian
                    $nilaiUjian         += $cekNilaiEvaluasi['nilai'];
                    $user['nilai']['evaluasi']   = $cekNilaiEvaluasi['nilai'];
                }
            } else {
                $totalTugas = 100;
                $evaluasi  = $db->quiz->findOne(array('id_modul' => "$idmodul"));
                if ($evaluasi) {
                    $cekNilaiEvaluasi   = $db->kumpul_quiz->findOne(array("id_quiz"=>"$evaluasi[_id]", "id_user"=>$listA['id_user']));

                    // --- Nilai Ujian
                    $nilaiUjian         += $cekNilaiEvaluasi['nilai'];
                    $user['nilai']['evaluasi']   = $cekNilaiEvaluasi['nilai'];
                }
            }

            $persentaseModul = $modul['nilai']['materi'];
            $persentaseTugas = $modul['nilai']['tugas'];
            $persentaseUjian = $modul['nilai']['ujian'];
            $nilaiMinimal    = $modul['nilai']['minimal'];

            $nilaiAkhirModul    = $persentaseModul == 0 ? 0 : round($nilaiModul * ($persentaseModul/100), 2);
            $nilaiAkhirTugas    = $persentaseTugas == 0 ? 0 : round($totalTugas * ($persentaseTugas/100), 2);
            $nilaiAkhirUjian    = $persentaseUjian == 0 ? 0 : round($nilaiUjian * ($persentaseUjian/100), 2);
            $hasil              = round($nilaiAkhirModul + $nilaiAkhirTugas + $nilaiAkhirUjian, 2);

            // Nilai Akhir
            $user['nilai']['akhir']   = $hasil;

            $no++;
            $users[]    = $user;
        }
		$totalData	= count($users);
		$totalFiltered = $totalData;

		$totalFiltered	= count($users);

		if($totalFiltered > 0){
			foreach($users as $row){
				$nestedData     = array();
				$nestedData[]   = $row["nama"];
				$nestedData[]   = $row["tkb"];
				$nestedData[]   = $row["nilai"]["akhir"];
				// $nestedData[] = $row["id"];
				// $nestedData[] = $row["nama"]." ".$row['batch'];
				// $nestedData[] = date("d M Y", strtotime($row["mulai"]))." s/d <br /> ".date("d M Y", strtotime($row['sampai']));
				// $nestedData[] = date("d M Y H:i:s", strtotime($row["lastupdate"]));
				// $nestedData[] = '<center>
				// 										<button data-toggle="tooltip" data-placement="bottom" title="Edit"  onclick="edit('.$row["id"].')" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i> </button>
				// 										<button data-toggle="tooltip" data-placement="bottom" title="Remove"  onclick="remove('.$row["id"].')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button>
				// 								</center>';
				$data[] = $nestedData;
			}
		}else{
			$data	= [];
		}

		$response = array(
						"draw"            => intval( $method['draw'] ),
						"recordsTotal"    => intval( $totalData ),
						"recordsFiltered" => intval( $totalFiltered ),
						"data"            => $data,
                        "kolom"           => $jumlahTugas + 2
					);

		$jsonResponse     = json_encode($response);
		header('Content-Type: application/json');

		echo $jsonResponse;
    }
}

?>
