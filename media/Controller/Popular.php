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

    public function MediaTerbanyak()
    {
        $query = $this -> table -> aggregate(array('$group' => array('_id' => '$id_user','count' => array('$sum' => 1))),array('$sort' => array('count'=> -1)),array('$limit'=>5));
        // $query = $this -> table -> aggregate(array('$group' => array('_id' => '$id_user','count' => array('$sum' => 1))));
        print_r($query);
        foreach ($query as $key) {
            if (is_array($key)) {
                $i = 0;
                foreach($key as $data){
                    try {
                        $something_id = new MongoId($data['_id']);
                    } catch (MongoException $ex) {
                        $something_id = new MongoId();
                    }
                    $user = $this->db->user->findOne(array("_id"=> $something_id));
                    // echo "<br>".$user['nama'];
                    // echo $data['count'];

                    $media[$i]=$data;
                    $media[$i]['nama_user'] = $user['nama'];
                    $media[$i]['sekolah_user'] = $user['sekolah'];
                    $media[$i]['foto_user'] = $user['foto'];
                    $i++;
                }

            }   
        }
        return $media;
    }

    public function TagTerbanyak()
    {   
        $query = $this -> db -> tag -> aggregate(array('$group' => array('_id' => '$nama','count' => array('$sum' => 1))),array('$sort' => array('count'=> -1)),array('$limit'=>5));
        
        return $query;
    }
}