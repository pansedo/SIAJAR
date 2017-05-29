<?php
class Popular
{ 
	public function __construct() {
        try {
            global $db; 
            $tableName = 'dokumen';
            $this->db = $db;
            $this->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }
    public function GetMedia()
    {
    	$query =  $this -> table -> find();
    	$count = $query->count();
    	if ($count > 0) {
    		$i = 0;
    		foreach ($query as $row) {
    			$data = $this->db->user->findOne(array("_id"=> new MongoId($row['id_user'])));
    			$kategori = $this->db->kategori->findone(array("_id"=> new MongoId($row['id_kategori'])));
    			$media[$i]=$row;
    			$media[$i]['nama_user'] = $data['nama'];
    			$media[$i]['foto'] = $data['foto'];
    			$media[$i]['kategori'] = $kategori['kategori'];
    			$i++;
    		}
    	}
    	
        if ($count > 0) {
    		return $media;
    	}else{
    		return $count;
    	}
    }

}