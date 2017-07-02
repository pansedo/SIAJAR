<?php
class Soal
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'soal';
            $this->db = $db;
            $this->db->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoSoal($idSoal){
		$ID     = new MongoId($idSoal);
        $query  = $this->db->soal->findOne(array("_id" => $ID));
		if($query['_id']){
			$query1	= $this->db->soal->find(array("id_soal" => $idSoal))->count();
			$query['modul'] = $query1;
		}
        return $query;
    }

    public function getListbyQuiz($idQuiz){
        $query =  $this->db->soal->find(array("id_paket"=>"$idQuiz"));
        return $query;
    }

    public function getListbySoal($idSoal){
        $query =  $this->db->soal->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

    public function getListJawaban($idSoal){
        // print_r("$idSoal");
        $query =  $this->db->opsi_soal->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

    public function addSoal($soal, $jawaban, $benar, $id_paket, $user){
        $newID  = "";
        $insert = array("id_paket"=>"$id_paket","jenis" => "pg","soal" => $soal, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $paketsoal = $this->db->soal->insert($insert);
        $idSoal = $insert['_id'];
        if ($paketsoal) {
            $hasil ="Sukses";
                $i = 0;
                // echo "benar = ".$benar."<br />";
                $b = $benar;
            foreach ($jawaban as $jawab) {
                // echo $i .' = '.$benar.'<br />';
                // echo "if ".$benar ."=". $i.")"; 
                
                if ($benar = $i) {
                    $status = "benar";
                }else{
                    $status = "salah";
                }
                $i = $i+1;
                $inserts = array("id_soal" => "$idSoal", "text" => $jawab, "status"=>"$status" );
                $inserttag = $this->db->opsi_soal->insert($inserts);

            }
            echo "<script>alert('".$rest['status']."'); document.location='quiz-action.php?md=".$_GET['md']."&qz=".$_GET['qz']."</script>";
        }else {
            $hasil     = "Failed";
        }

        $result = array("hasil" => $hasil);
        return $result;
    }

    public function updateSoal($id, $soal, $jawaban, $benar, $id_paket, $user){
        $newID  = "";
        $edit = array("id_paket"=>"$id_paket","jenis" => "pg","soal" => $soal, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $paketsoal = $this->db->soal->update(array("_id"=> new MongoId($id)),array('$set'=>$edit));
        
        if ($paketsoal) {
            $status1 ="Sukses";
            $deleteopsi = array("id_soal" => "$id");
            $hapusopsi = $this->db->opsi_soal->remove($deleteopsi);
                $i = 0;
                $b = $benar;
            foreach ($jawaban as $jawab) {
                // echo $i .' = '.$benar.'<br />';
                // echo "if ".$benar ."=". $i.")"; 
                
                if ($benar = $i) {
                    $status = "benar";
                }else{
                    $status = "salah";
                }
                $i = $i+1;
                $inserts = array("id_soal" => "$id", "text" => $jawab, "status"=>"$status" );
                $inserttag = $this->db->opsi_soal->insert($inserts);
            }
            
        }else {
            $status1     = "Failed";
        }

        $result = array("status" => $status1);
        return $result;
    }

    public function addOpsi($nama, $modul, $user){
        $newID  = "";
        $insert = array("nama" => $nama, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $paketsoal = $this->db->paket_soal->insert($insert);
        if ($paketsoal) {
            $status ="Sukses";
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDMapel" => $mapel);
        return $result;
    }

}