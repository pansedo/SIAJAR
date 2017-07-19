<?php

class Tugas
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'tugas';
            $this->db = $db;
            $this->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoTugas($idModul){
        $query  = $this->table->findOne(array("id_modul" => $idModul));
        return $query;
    }

    public function getListTugas($idModul){
        $query =  $this->table->find(array("id_modul"=>"$idModul"));
        return $query;
    }

    public function getStatusTugas($tugas, $user){
        $query =  $this->db->tugas_kumpul->findOne(array("id_tugas"=>"$tugas", "id_user"=>"$user"));
        return $query;
    }

    public function addTugas($idTugas, $nama, $deskripsi, $deadline, $user){

        $insert = array("id_modul"=>$idTugas, "nama" => $nama, "deskripsi" => $deskripsi, "deadline" => $deadline, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));

        $this->table->insert($insert);

        if ($insert) {
            $status     = "Success";
        }else{
            $status     = "Failed";
        }

        $result = array("status" => $status);
        return $result;
    }

    public function updateTugas($idTugas, $nama, $deskripsi, $deadline){

        $update   = array('$set' => array("nama" => $nama, "deskripsi" => $deskripsi, "deadline" => $deadline, "date_modified"=>date('Y-m-d H:i:s')));

        try {
            $this->table->update(array("_id" => new MongoId($idTugas)), $update);
            $status     = "Success";
        } catch(MongoCursorException $e) {
            $status     = "Failed";
        }

        $result = array("status" => $status);
        return $result;
    }

    public function submitTugas($user, $idTugas, $deskripsi, $file){

        if($file['name'] != ""){
            $ext        = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_name	= "$user".'_'.date('dmYHIs').".".$ext;
            $folderDest	= 'assets/dokumen/'.$file_name;

            move_uploaded_file($file['tmp_name'], $folderDest);
        }else{
            $file_name  = "";
        }

        $insert = array("id_user"=>"$user", "id_tugas" => $idTugas, "deskripsi" => $deskripsi, "file" => $file_name, "nilai" => "0", "catatan" => "", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));

        $this->db->tugas_kumpul->insert($insert);

        if ($insert) {
            $status     = "Success";
        }else{
            $status     = "Failed";
        }

        $result = array("status" => $status);
        return $result;
    }

    public function insertNilai($idUser, $idTugas, $nilai, $catatan){


        $update     = array('$set' => array("nilai" => $nilai, "catatan" => $catatan, "date_modified"=>date('Y-m-d H:i:s')));

        try {

            $this->db->tugas_kumpul->update(array("id_user" => (string)$idUser, "id_tugas" => $idTugas), $update, array("upsert" => true));
            $status     = "Success";
        } catch(MongoCursorException $e) {

            $status     = "Failed";
        }

        $result = array("status" => $status);
        return $result;
    }

}

?>
