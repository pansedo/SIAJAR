<?php

class Mapel
{
    public function __construct() {
        try {
            global $db;
            $tableName  = 'mata_pelajaran';
            $this->db   = $db;
            $this->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoMapel($idMapel){
		$ID     = new MongoId($idMapel);
        $query  = $this->table->findOne(array("_id" => $ID));
		if($query['_id']){
			$query1	= $this->db->modul->find(array("id_mapel" => $idMapel))->count();
			$query['modul'] = $query1;
		}
        return $query;
    }

    public function getListbyKelas($idkelas){
        $query =  $this->table->find(array("id_kelas"=>"$idkelas"));
        return $query;
    }

    public function addMapel($nama, $kelas, $user){
        $newID  = "";
        $insert = array("id_kelas"=>$kelas, "nama" => $nama, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->table->insert($insert);
        $newID  = $insert['_id'];
        if ($newID) {
            $status     = "Success";
            $message    = "Mata Pelajaran $nama berhasil ditambahkan!";
        }else {
            $status     = "Failed";
            $message    = "Mata Pelajaran $nama gagal ditambahkan!";
        }

        $result = array("status" => $status, "message"=>$message, "IDMapel" => $newID);
        return $result;
    }

    public function updateMapel($nama, $mapel){
        $update     = array('$set' => array("nama"=>$nama, "date_modified"=>date('Y-m-d H:i:s')));

          try {
              $this->table->update(array("_id" => new MongoId($mapel)), $update);
              $status   = "success";
              $judul    = "Berhasil!";
              $message  = "Pengaturan Mata Pelajaran berhasil disimpan.";
          } catch(MongoCursorException $e) {
              $status   = "error";
              $judul    = "Maaf!";
              $message  = "Pengaturan Mata Pelajaran gagal disimpan.";
          }

        $result = array("status" => $status, "judul" => $judul, "message"=>$message, "IDMapel" => $mapel);
        return $result;
    }

}

?>
