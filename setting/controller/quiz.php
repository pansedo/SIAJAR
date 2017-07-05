<?php
class Quiz
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'quiz';
            $tableName2 = 'paket Soal';
            $this->db = $db;
            $this->db->table = $this->db->$tableName;
            $this->db->table2 = $this->db->$tableName2;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoQuiz($idQuiz){
		$ID     = new MongoId($idQuiz);
        $query  = $this->db->quiz->findOne(array("_id" => $ID));
        return $query;
    }

    public function getListbyModul($idModul){
        $query =  $this->db->quiz->find(array("id_modul"=>"$idModul"));
        return $query;
    }

    public function addQuiz($nama, $modul, $user){
        $newID  = "";
        $insert = array("nama" => $nama, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $paketsoal = $this->db->paket_soal->insert($insert);
        if ($paketsoal) {
            $newID  = $insert['_id'];
            $insert2 = array("id_modul" => $modul,"id_quiz" =>"$newID", "nama" => $nama, "durasi"=>"","start_date"=>"","end_date"=>"", "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'), "status"=>"0");
            $insertquiz = $this->db->quiz->insert($insert2);
            if ($insertquiz) {
                $status ="Sukses";
            }
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $mapel);
        return $result;
    }

    public function submitQuiz($idUser, $idQuiz){
        $nilai_quiz         = 0;
        $list_jawaban_user  =  $this->db->jawaban_user->find(array("id_user"=>"$idUser", "id_quiz"=>"$idQuiz"));

        foreach ($list_jawaban_user as $jawaban_user) {
            $nilai_quiz += $jawaban_user['status'];
        }

        return $nilai_quiz;
    }
}
