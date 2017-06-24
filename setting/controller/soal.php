<?php
class Soal
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'soal';
            $this->db = $db;
            $this->db->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoSoal($idSoal){
		$ID     = new MongoId($idSoal);
        $query  = $this->db->soal->findOne(array("_id" => $ID));
		if($query['_id']){
			$query1	= $this->db->soal->find(array("id_soal" => $idSoal))->count();
			$query['modul'] = $query1;
		}
        return $query;
    }

    public function getListbyQuiz($idQuiz){
        $query =  $this->db->soal->find(array("id_paket"=>"$idQuiz"));
        return $query;
    }

    public function getListbySoal($idSoal){
        $query =  $this->db->soal->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

    public function getListJawaban($idSoal){
        // print_r("$idSoal");
        $query =  $this->db->opsi_soal->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

    public function addSoal($soal, $jawaban, $benar, $id_paket, $user){
        $newID  = "";
        $insert = array("id_paket"=>"$id_paket","jenis" => "pg","soal" => $soal, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $paketsoal = $this->db->soal->insert($insert);
        $idSoal = $insert['_id'];
        if ($paketsoal) {
            $status ="Sukses";
                $i = 0;
            foreach ($jawaban as $jawab) {
                // $i = $i++;
                if ($benar = $i++) {
                    $status = "benar";
                }else{
                    $status = "salah";
                }
                $inserts = array("id_soal" => "$idSoal", "text" => $jawab, "status"=>"$status" );
                $inserttag = $this->db->opsi_soal->insert($inserts);
            }
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status);
        return $result;
    }

    public function addOpsi($nama, $modul, $user){
        $newID  = "";
        $insert = array("nama" => $nama, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $paketsoal = $this->db->paket_soal->insert($insert);
        if ($paketsoal) {
            $status ="Sukses";
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $mapel);
        return $result;
    }

}