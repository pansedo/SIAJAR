<?php

class Soal
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'soal';
            $this->db = $db;
            $this->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function getInfoSoal($idSoal){
		$ID     = new MongoId($idSoal);
        $query  = $this->table->findOne(array("_id" => $ID));

        return $query;
    }

    public function getListbyQuiz($idQuiz){
        $query =  $this->table->find(array("id_paket"=>"$idQuiz"));
        // if($query["soal"]){
        //     $query1 = $this->table->find(array("id_paket" => $idQuiz))->count();
        //     $query['jmlSoal'] = $query1;
        // }
        return $query;
    }

    public function getListbySoal($idSoal){
        $query =  $this->table->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

    public function getListJawaban($idSoal){
        // print_r("$idSoal");
        $query =  $this->db->opsi_soal->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

    public function getListSoalbyQuiz($idPaket){
        $query =  $this->table->find(array("id_paket"=>"$idPaket"));
        return iterator_to_array($query);
    }

    public function getListOpsiSoal($idSoal){
        $query =  $this->db->opsi_soal->find(array("id_soal"=>"$idSoal"));
        return $query;
    }

    public function getSoalbyId($idSoal){
        $query =  $this->table->findOne(array("_id" => new MongoId($idSoal)));
        return $query;
    }

    public function getOpsiJawabanUser($idUser, $idQuiz, $idSoal){
        $query =  $this->db->jawaban_user->findOne(array("id_user" => "$idUser", "id_quiz" => "$idQuiz", "id_soal" => "$idSoal"));
        return $query;
    }

    public function getNumberbyQuiz($idQuiz){
        $query =  $this->table->find(array("id_paket"=>"$idQuiz"))->count();
        return $query;
    }

    public function addSoal($soal, $jawaban, $benar, $id_paket, $user){
        $newID  = "";
        $insert = array("id_paket"=>"$id_paket","jenis" => "pg","soal" => $soal, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $paketsoal = $this->table->insert($insert);
        $idSoal = $insert['_id'];
        if ($paketsoal) {
            $hasil ="Sukses";
                $i = 0;
                // echo "benar = ".$benar."<br />";
                $b = $benar;
            foreach ($jawaban as $jawab) {
                // echo $i .' = '.$benar.'<br />';
                // echo "if ".$benar ."=". $i.")";

                if ($benar == $i) {
                    $status = "benar";
                }else{
                    $status = "salah";
                }
                $i = $i+1;
                $inserts = array("id_soal" => "$idSoal", "text" => $jawab, "status"=>"$status" );
                $inserttag = $this->db->opsi_soal->insert($inserts);

            }
            if (isset($_GET['md'])) {
                # code...
                echo "<script>alert('Sukses'); document.location='quiz-action.php?md=".$_GET['md']."&qz=".$_GET['qz']."</script>";
            }else if (isset($_GET['id'])) {
                # code...
                echo "<script>alert('Sukses'); document.location='paket-detail.php?id=".$_GET['id']."</script>";
            }
            
        }else {
            $hasil     = "Failed";
        }

        $result = array("hasil" => $hasil);
        return $result;
    }

    public function updateSoal($id, $soal, $jawaban, $benar, $id_paket, $user){
        $newID  = "";
        $edit = array("id_paket"=>"$id_paket","jenis" => "pg","soal" => $soal, "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
        $paketsoal = $this->table->update(array("_id"=> new MongoId($id)),array('$set'=>$edit));

        if ($paketsoal) {
            $status1 ="Sukses";
            $deleteopsi = array("id_soal" => "$id");
            $hapusopsi = $this->db->opsi_soal->remove($deleteopsi);
                $i = 0;
                $b = $benar;
            foreach ($jawaban as $jawab) {
                // echo $i .' = '.$benar.'<br />';
                // echo "if ".$benar ."=". $i.")";

                if ($benar == $i) {
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
