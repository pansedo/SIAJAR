<?php

class Modul
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'modul';
            $this->db = $db;
            $this->db->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoModul($idModul){
		$ID     = new MongoId($idModul);
        $query  = $this->db->modul->findOne(array("_id" => $ID));
        return $query;
    }

    public function getListbyMapel($idmapel){
        $query =  $this->db->modul->find(array("id_mapel"=>"$idmapel"));
        return $query;
    }

    public function addModul($nama, $mapel, $user){
        $newID  = "";
        $insert = array("id_mapel"=>$mapel, "nama" => $nama, "materi" => "", "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->db->modul->insert($insert);
        if ($insert) {
            $newID  = $insert['_id'];
            $status     = "Success";
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $mapel);
        return $result;
    }

    public function submitMateri($id_modul, $materi){

        $document   = array('$set' => array("materi"=>$materi, "date_modified"=>date('Y-m-d H:i:s')));

        $options    = array('$set' => array("upsert" => false, "multiple" => true));

        try {
            $this->db->modul->update(array("_id" => new MongoId($id)), $document);
            $status     = "Success";
        } catch(MongoCursorException $e) {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDModul" => $id_modul);
        return $result;
    }

}

?>
