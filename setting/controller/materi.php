<?php

class Materi
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'materi';
            $this->db = $db;
            $this->db->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoMateri($idModul){
        $query  = $this->db->materi->find(array("id_modul" => $idModul));
        return $query;
    }

    public function addMateri($idModul, $judul, $materi, $user){
        $newID  = "";
        $insert = array("id_modul"=>$idModul, "judul" => $judul, "file" => $materi, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));

        $this->db->materi->insert($insert);

        if ($insert) {
            $newID  = $insert['_id'];
            $status     = "Success";
        }else{
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDModul" => $idModul);
        return $result;
    }

    public function updateMateri($idModul, $judul, $materi){

        $update   = array('$set' => array("file"=>$materi, "judul"=>$judul, "date_modified"=>date('Y-m-d H:i:s')));

        try {
            $this->db->materi->update(array("id_modul" => $idModul), $update);
            $status     = "Success";
        } catch(MongoCursorException $e) {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDModul" => $idModul);
        return $result;
    }

}

?>
