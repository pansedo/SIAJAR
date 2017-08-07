<?php

class Tag
{
	public function __construct() {
        try {
            global $db;
            $tableName = 'tag';
            $this->db = $db;
            $this->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function TagByMedia($id)
    {
    	$query =  $this -> table -> find(array("id_dokumen"=>new MongoId($id)));
    	return $query; 
    }

}
?>