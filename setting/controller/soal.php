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
        $query =  $this->db->soal->find(array("id_quiz"=>"$idQuiz"));
        return $query;
    }

    public function getListbySoal($idSoal){
        $query =  $this->db->soal->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

    public function getListJawaban($idSoal){
        $query =  $this->db->opsi_soal->find(array("id_soal"=>"$idModul"));
    }

    public function addSoal($soal, $idPaket, $user){
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