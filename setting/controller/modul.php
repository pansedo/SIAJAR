<?php

class Modul
{
    public function __construct() {
        try {
            global $db;
            $tableName      = 'modul';
            $this->db       = $db;
            $this->table    = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoModul($idModul){
		$ID     = new MongoId($idModul);
        $query  = $this->table->findOne(array("_id" => $ID));
        return $query;
    }

    public function getListbyMapel($idMapel){
        $query  = $this->table->find(array("id_mapel" => $idMapel));
        return $query;
    }

    public function getLearningPath($idmodul){
        if ($idmodul != 0) {
            $nilaiModul     = 0;
            $nilaiTugas     = 0;
            $nilaiUjian     = 0;

            $modul          = $this->table->findOne(array("_id"=> new MongoId($idmodul)));
            if ($modul) {
                $cekNilaiModul  = $this->table->findOne(array("id_modul"=>"$idmodul"));
                $nilaiModul     += $cekNilaiModul['nilai'];
            }

            $tugasModul =  $this->db->tugas->find(array("id_modul"=>"$idmodul"));
            $jumlahTugas = $tugasModul->count();
            if ($jumlahTugas > 0) {
                $kumpulTugas = 0;
                foreach ($tugasModul as $tugas) {
                    $cekNilaiTugas  = $this->db->tugas_kumpul->findOne(array("id_tugas"=>"$tugas[_id]"));
                    $nilaiTugas     += $cekNilaiTugas['nilai'];
                    $kumpulTugas++;
                }
                $totalTugas = round(($nilaiTugas/$jumlahTugas), 2);

                $evaluasi  = $this->db->quiz->findOne(array('id_modul' => "$idmodul"));
                if ($evaluasi) {
                    $cekNilaiEvaluasi   = $this->db->kumpul_quiz->findOne(array("id_quiz"=>"$evaluasi[_id]"));
                    $nilaiUjian      += $cekNilaiEvaluasi['nilai'];
                }
            }else {
                $totalTugas = 100;
                $evaluasi  = $this->db->quiz->findOne(array('id_modul' => "$idmodul"));
                if ($evaluasi) {
                    $cekNilaiEvaluasi   = $this->db->kumpul_quiz->findOne(array("id_quiz"=>"$evaluasi[_id]"));
                    $nilaiUjian      += $cekNilaiEvaluasi['nilai'];
                }
            }

            $persentaseModul = $modul['nilai']['materi'];
            $persentaseTugas = $modul['nilai']['tugas'];
            $persentaseUjian = $modul['nilai']['ujian'];
            $nilaiMinimal    = $modul['nilai']['minimal'];

            $nilaiAkhirModul    = round($nilaiModul * $persentaseModul, 2);
            $nilaiAkhirTugas    = round($totalTugas * $persentaseTugas, 2);
            $nilaiAkhirUjian    = round($nilaiUjian * $persentaseUjian, 2);

            $hasil  = round($nilaiAkhirModul + $nilaiAkhirTugas + $nilaiAkhirUjian, 2);
            $status = $hasil > $nilaiMinimal ? 'LULUS' : 'TIDAK';
        }else {
            $status = 'LULUS';
        }

        return $status;
    }

    // public function getNilaiTugas(){
    //
    // }

    public function addModul($kiriman, $mapel, $user){
        $nama   = $kiriman['namamodul'];
        $syarat = $kiriman['prasyaratmodul'];
        $nilai1 = $kiriman['nilaimateri'];
        $nilai2 = $kiriman['nilaitugas'];
        $nilai3 = $kiriman['nilaiujian'];
        $nilai4 = $kiriman['nilaiminimal'];

        $newID  = "";
        $insert = array("id_mapel"=>$mapel, "nama"=>$nama, "prasyarat"=>$syarat, "nilai"=>array("materi"=>$nilai1, "tugas"=>$nilai2, "ujian"=>$nilai3, "minimal"=>$nilai4), "creator"=>"$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->table->insert($insert);
        if ($insert) {
            $newID  = $insert['_id'];
            $status = "Success";
        }else {
            $status = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $mapel);
        return $result;
    }

    public function setModul($kiriman, $mapel){
        $id     = $kiriman['idmodul'];
        $nama   = $kiriman['namamodul'];
        $syarat = $kiriman['prasyaratmodul'];
        $nilai1 = $kiriman['nilaimateri'];
        $nilai2 = $kiriman['nilaitugas'];
        $nilai3 = $kiriman['nilaiujian'];
        $nilai4 = $kiriman['nilaiminimal'];

        $newID  = "";
        $update = array("nama" => $nama, "prasyarat"=>$syarat, "nilai"=>array("materi"=>$nilai1, "tugas"=>$nilai2, "ujian"=>$nilai3, "minimal"=>$nilai4), "date_modified"=>date('Y-m-d H:i:s'));
        $sukses = $this->table->update(array("_id"=> new MongoId($id)),array('$set'=>$update));
        if ($sukses) {
            $status = "Success";
        }else {
            $status = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $mapel);
        // $result = array("status" => $kiriman, "balikan" => $kiriman['idmodul']);
        return $result;
    }

}

?>
