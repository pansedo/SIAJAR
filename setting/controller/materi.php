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

    public function getInfoMateri($idMateri){
		$ID     = new MongoId($idMateri);
        $query  = $this->db->materi->findOne(array("_id" => $ID));
        return $query;
    }

    public function addMateri($idModul, $judul, $file, $user){
        $newID  = "";
        $insert = array("id_modul"=>$idModul, "judul" => $judul, "file" => $file, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->db->materi->insert($insert);
        if ($insert) {
            $newID  = $insert['_id'];
            $status     = "Success";
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status, "idMateri" => $newID);
        return $result;
    }

}

?>
