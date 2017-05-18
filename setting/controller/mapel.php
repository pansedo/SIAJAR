<?php

class Mapel
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'mata_pelajaran';
            $this->db = $db;
            $this->db->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoMapel($idMapel){
		$ID     = new MongoId($idMapel);
        $query  = $this->db->mata_pelajaran->findOne(array("_id" => $ID));
		if($query['_id']){
			$query1	= $this->db->modul->find(array("id_mapel" => $idMapel))->count();
			$query['modul'] = $query1;
		}
        return $query;
    }

    public function getListbyKelas($idkelas){
        $query =  $this->db->mata_pelajaran->find(array("id_kelas"=>"$idkelas"));
        return $query;
    }

    public function addMapel($nama, $kelas, $user){
        $newID  = "";
        $insert = array("id_kelas"=>$kelas, "nama" => $nama, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->db->mata_pelajaran->insert($insert);
        $newID  = $insert['_id'];
        if ($newID) {
            $status     = "Success";
            $relation   = $this->db->anggota_kelas->insert(array("id_user"=>"$user", "id_kelas"=>"$newID"));
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $newID);
        return $result;
    }

}

?>
