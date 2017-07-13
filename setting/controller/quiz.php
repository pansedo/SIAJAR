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

        // print_r($query);
        return $query;
    }

    public function getNilaiQuiz($idQuiz, $idUser){
        $query  = $this->db->kumpul_quiz->findOne(array("id_quiz" => "$idQuiz", "id_user" => "$idUser"));

        return $query;
    }

    public function getInfoPaket($idQuiz){
        $ID     = new MongoId($idQuiz);
        $query  = $this->db->paket_soal->findOne(array("_id" => $ID));

        // print_r($query);
        return $query;
    }

    public function getListbyModul($idModul){
        $query =  $this->db->quiz->find(array("id_modul"=>"$idModul"));
        // if($query['_id']){
        //     $query1 = $this->db->quiz->find(array("id_modul" => $idModul))->count();
        //     $query['modul'] = $query1;
        // }
        return $query;
    }

    public function getListbyUser($creator){
        $query =  $this->db->paket_soal->find(array("creator"=>"$creator"));
        // if($query['_id']){
        //     $query1 = $this->db->quiz->find(array("id_modul" => $idModul))->count();
        //     $query['modul'] = $query1;
        // }
        return $query;
    }
    public function addQuiz($nama, $modul, $durasi, $mulai, $selesai, $user){
        $newID  = "";
        $insert = array("nama" => $nama, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $save = $this->db->paket_soal->insert($insert);
        if ($save) {
            $newID  = $insert['_id'];
            $insert2 = array("id_modul" => $modul,"id_paket" =>"$newID", "nama" => "$nama", "durasi"=>"$durasi","start_date"=>"$mulai","end_date"=>"$selesai", "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'), "status"=>"0");
            $insertquiz = $this->db->quiz->insert($insert2);
            if ($insertquiz) {
                $status ="Sukses";
            }
        }else {
            $status     = "Failed";
            $newID = "";
        }

        $result = array("status" => $status, "idQuiz" => $newID);
        return $result;
    }

    public function updateQuiz($id, $nama, $durasi, $mulai, $selesai){
        $newID  = "";
        $edit = array("nama" => $nama, "durasi" => "$durasi", "start_date"=>"$mulai", "end_date" => "$selesai", "date_modified"=>date('Y-m-d H:i:s'));

        // print_r($edit);
        $update = $this->db->quiz->update(array("_id"=> new MongoId($id)),array('$set'=>$edit));
        if ($update) {

                $status ="Sukses";

        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status);
        return $result;
    }

    public function hitungNilaiQuiz($idUser, $idQuiz, $jumlah_soal){
        $nilai_quiz         = 0;
        $list_jawaban_user  =  $this->db->jawaban_user->find(array("id_user"=>"$idUser", "id_quiz"=>"$idQuiz"));

        foreach ($list_jawaban_user as $jawaban_user) {
            if($jawaban_user['status'] == 'benar'){
                $nilai_quiz++;
            }
        }

        $nilai_akhir = ($nilai_quiz/$jumlah_soal)*100;

        return $nilai_akhir;
    }

    public function submitQuiz($idUser, $idQuiz, $nilaiQuiz){
        $update     = array('$set' => array("nilai" => $nilaiQuiz, "date_modified"=>date('Y-m-d H:i:s')));

        try {

            $this->db->kumpul_quiz->update(array("id_user" => $idUser, "id_quiz" => $idQuiz), $update, array("upsert" => true));
            $status     = "Success";
        } catch(MongoCursorException $e) {

            $status     = "Failed";
        }

        return $status;
    }

    public function isSumbmitted($idUser, $idQuiz){
        $query  = $this->db->kumpul_quiz->find(array("id_user" => $idUser, "id_quiz" => $idQuiz))->count();

        if($query > 0){
            return "1";
        }else{
            return "0";
        }
    }

    public function duplicateQuiz($id_paket){
        $query =  $this->db->paket_soal->find(array("_id"=> new MongoId($id_paket)));
        // for
    }
}
