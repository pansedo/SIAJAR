<?php

class Modul
{
    public function __construct() {
        try {
            global $db;
            $tableName      = 'modul';
            $this->db       = $db;
            $this->table    = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoModul($idModul){
		$ID     = new MongoId($idModul);
        $query  = $this->table->findOne(array("_id" => $ID));
        return $query;
    }

    public function getListbyMapel($idmapel){
        $query =  $this->table->find(array("id_mapel"=>"$idmapel"));
        return $query;
    }

    public function addModul($kiriman, $mapel, $user){
        $nama   = $kiriman['namamodul'];
        $syarat = $kiriman['prasyaratmodul'];
        $nilai1 = $kiriman['nilaimateri'];
        $nilai2 = $kiriman['nilaitugas'];
        $nilai3 = $kiriman['nilaiujian'];
        $nilai4 = $kiriman['nilaiminimal'];

        $newID  = "";
        $insert = array("id_mapel"=>$mapel, "nama"=>$nama, "prasyarat"=>$syarat, "nilai"=>array("materi"=>$nilai1, "tugas"=>$nilai2, "ujian"=>$nilai3, "minimal"=>$nilai4), "creator"=>"$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->table->insert($insert);
        if ($insert) {
            $newID  = $insert['_id'];
            $status = "Success";
        }else {
            $status = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $mapel);
        return $result;
    }

    public function setModul($kiriman, $mapel){
        $id     = $kiriman['idmodul'];
        $nama   = $kiriman['namamodul'];
        $syarat = $kiriman['prasyaratmodul'];
        $nilai1 = $kiriman['nilaimateri'];
        $nilai2 = $kiriman['nilaitugas'];
        $nilai3 = $kiriman['nilaiujian'];
        $nilai4 = $kiriman['nilaiminimal'];

        $newID  = "";
        $update = array("nama" => $nama, "prasyarat"=>$syarat, "nilai"=>array("materi"=>$nilai1, "tugas"=>$nilai2, "ujian"=>$nilai3, "minimal"=>$nilai4), "date_modified"=>date('Y-m-d H:i:s'));
        $sukses = $this->table->update(array("_id"=> new MongoId($id)),array('$set'=>$update));
        if ($sukses) {
            $status = "Success";
        }else {
            $status = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $mapel);
        // $result = array("status" => $kiriman, "balikan" => $kiriman['idmodul']);
        return $result;
    }

}

?>
