<?php
class Rating
{

	public function __construct() {
        try {
            global $db;  

            $tableName = 'rating';
            $this->db = $db;
            $this->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function InsertRating($rating,$document,$iduser)
    {
        $update     = array('$set' => array("rating" => intval($rating)));
        $this->table->update(array("id_user" => $iduser, "id_dokumen" => $document), $update, array("upsert" => true));
        echo "Anda Sudah Memeberi $rating Rating ";
    }

    public function GetRatingBy($document)
    {
        $query = $this->table -> aggregate([
            array('$match' => array('id_dokumen'=> "$document") ),
            array('$group'=>array('_id'=>'$document','rating'=>array('$avg'=>'$rating')))
            ]);
        
       
        $rating =  floor($query['result'][0]['rating']);
        return $rating; 

    }




}

?>