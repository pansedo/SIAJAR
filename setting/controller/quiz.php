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

    public function getInfoQuiz($id){
		$ID     = new MongoId($id);
        $query  = $this->db->quiz->findOne(array("_id" => $ID));
		
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

    public function duplicateQuiz($id_paket){
        $query =  $this->db->paket_soal->find(array("_id"=> new MongoId($id_paket)));
        // for
    }
}