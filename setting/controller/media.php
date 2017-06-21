<?php
class Media
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
    
    public function CountMedia()
    {
        $query =  $this -> table -> find();
        $count = $query->count();
        return $count;
    }

}

?>
