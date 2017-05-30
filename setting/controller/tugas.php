<?php

class Tugas
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'tugas';
            $this->db = $db;
            $this->db->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoTugas($idModul){
        $query  = $this->db->tugas->findOne(array("id_modul" => $idModul));
        return $query;
    }

    public function addTugas($idModul, $nama, $deskripsi, $deadline, $user){

        $insert = array("id_modul"=>$idModul, "nama" => $nama, "deskripsi" => $deskripsi, "deadline" => $deadline, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));

        $this->db->tugas->insert($insert);

        if ($insert) {
            $status     = "Success";
        }else{
            $status     = "Failed";
        }

        $result = array("status" => $status);
        return $result;
    }

    public function updateTugas($idModul, $nama, $deskripsi, $deadline){

        $update   = array('$set' => array("nama" => $nama, "deskripsi" => $deskripsi, "deadline" => $deadline, "date_modified"=>date('Y-m-d H:i:s')));

        try {
            $this->db->tugas->update(array("id_modul" => $idModul), $update);
            $status     = "Success";
        } catch(MongoCursorException $e) {
            $status     = "Failed";
        }

        $result = array("status" => $status);
        return $result;
    }

}

?>
