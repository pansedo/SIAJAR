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

    public function getTotalMateri($idModul){
        $query  = $this->db->materi->find(array("id_modul" => $idModul));
        return $query;
    }

    public function getInfoMateri($idMateri){
		$ID     = new MongoId($idMateri);
        $query  = $this->db->materi->findOne(array("_id" => $ID));
        return $query;
    }

    public function addMateri($idModul, $judul, $materi, $status, $user){
        $newID  = "";
        $insert = array("id_modul"=>$idModul, "judul" => $judul, "isi" => $materi, "file"=>"", "status"=>$status, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));

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

    public function updateMateri($idMateri, $judul, $materi, $status){

        $update   = array('$set' => array("judul"=>$judul, "isi"=>$materi, "status"=>$status, "date_modified"=>date('Y-m-d H:i:s')));

        try {
            $this->db->materi->update(array("_id" => new MongoId($idMateri)), $update);
            $status     = "Success";
        } catch(MongoCursorException $e) {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDMateri" => $idMateri);
        return $result;
    }

}

?>
