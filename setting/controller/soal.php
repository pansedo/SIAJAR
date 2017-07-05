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

    public function getListbyQuiz($idQuiz){
        $query =  $this->db->soal->find(array("id_quiz"=>"$idQuiz"));
        return iterator_to_array($query);
    }

    public function getSoalbyId($idSoal){
        $query =  $this->db->soal->findOne(array("_id" => new MongoId($idSoal)));
        return $query;
    }

    public function getOpsiJawabanUser($idUser, $idQuiz, $idSoal){
        $query =  $this->db->jawaban_user->findOne(array("id_user" => "$idUser", "id_quiz" => "$idQuiz", "id_soal" => "$idSoal"));
        return $query;
    }

    public function getNumberbyQuiz($idQuiz){
        $query =  $this->db->soal->find(array("id_quiz"=>"$idQuiz"))->count();
        return $query;
    }

    public function getListOpsiSoal($idSoal){
        $query =  $this->db->opsi_soal->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

}

?>
