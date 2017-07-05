<?php

class Kategori
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'kategori';
            $this->table = $db -> $tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }
    
    public function GetKategoriUtama(){
        $query =  $this -> table -> find(array("sub_id"=>"0"));
        return $query;
    }   

    public function getkategoriutamabyId($id){
        $criteria = array('_id' => new MongoId($id));
        $query =  $this -> table -> find($criteria);
        return $query;
    }

    public function getkategoribyId($id){
        // $criteria = array('_id' => new MongoId($id));
        $query =  $this -> table -> find(array("_id"=>"$id"));
        // echo $query;
        return $query;
    }

    public function CreateKategoriUtama($namekategoriutama,$deskripsi){
        $insert = array("kategori" => $namekategoriutama, "deskripsi" => $deskripsi,"sub_id"=>"0");
        $this -> table -> insert($insert);
        echo '<script type="text/javascript"> alert("Registrasi Berhasil")</script>';
    }

    public function EditKategoriUtama($id,$namekategori,$deskripsi)
    {
        $criteria = array('_id' => new MongoId($id));
        $edit = array('$set'=> array("kategori" => $namekategori, "deskripsi" => $deskripsi));
        $editdata = $this-> table-> update($criteria, $edit);
        echo '<script type="text/javascript"> alert("Edit")</script>';

    }

    public function EditSubKategori($idsubkategori,$namesubkategori,$subdeskripsi)
    {
        $criteria = array('_id' => new MongoId($idsubkategori));
        $edit = array('$set'=> array("kategori" => $namesubkategori, "deskripsi" => $subdeskripsi));
        $editdata = $this-> table-> update($criteria, $edit);
        echo '<script type="text/javascript"> alert("Edit")</script>';

    }

    public function GetSubKategori($id){
        $query =  $this -> table -> find(array("sub_id"=>"$id"));
        return $query;
    }
    
    public function CreateSubKategori($idkategoriutama,$namesubkategori,$deskripsi){
        $insert = array("kategori" => $namesubkategori, "deskripsi" => $deskripsi,"sub_id"=>$idkategoriutama);
        $this -> table -> insert($insert);
        echo '<script type="text/javascript"> alert("Registrasi Berhasil")</script>';
    }

    public function DeleteKategori($id)
    {
        $delete = array("_id" => new MongoId($id));
        $this -> table -> remove($delete);

        $delete = array("sub_id" => $id);
        $this -> table -> remove($delete);
        echo '<script type="text/javascript"> alert("Delete Berhasil ")</script>';

    }

  
}

?>