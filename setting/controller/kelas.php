<?php

class Kelas
{
    public function __construct() {
        try {
            global $db;
            $tableName = 'kelas';
            $this->db = $db;
            $this->db->table = $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }

    public function acakKodeKelas($jumlahKarakter)
    {
        $karakter   = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $hasil      = '';
        for ($i=0; $i < $jumlahKarakter; $i++) {
            $acak   = rand(0, strlen($karakter)-1);
            $hasil  .= $karakter{$acak};
            # code...
        }
        $cek    = $this->db->table->find(array("kode" => $hasil))->count();
        if ($cek > 0) {
            $this->acakKodeKelas(6);
        }
        # code...
        return $hasil;
    }

	public function getInfoKelas($idkelas){
		$ID     = new MongoId($idkelas);
        $query  = $this->db->kelas->findOne(array("_id" => $ID));
		if($query['_id']){
			$query1	= $this->db->anggota_kelas->find(array("id_kelas" => $idkelas))->count();
			$query['member'] = $query1;
		}
        return $query;
    }

    public function addKelas($nama, $user){
        $newID  = "";
        $kode   = $this->acakKodeKelas(6);
        $insert = array("nama" => $nama, 'kode'=> $kode, "tentang"=>"", "status"=>"", "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->db->table->insert($insert);
        $newID  = $insert['_id'];
        if ($newID) {
            $status     = "Success";
            $relation   = $this->db->anggota_kelas->insert(array("id_user"=>"$user", "id_kelas"=>"$newID"));
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDKelas" => $newID);
        return $newID;
    }

    public function joinKelas($kode, $user){
        $newID  = "";
        $query  = $this->db->table->findOne(array("kode" => $kode));
        if (isset($query['_id'])) {
            if ($query['status'] == 'LOCKED') {
                $status     = "Locked";
                $message    = "Maaf, tidak dapat bergabung saat ini!";
            }else {
                $query2     = $this->db->anggota_kelas->findOne(array("id_user" => "$user", "id_kelas"=>"$query[_id]"));
                if (!empty($query2["_id"])) {
                    $status     = "Failed";
                    $message    = "Kamu sudah bergabung kedalam Kelas ini!";
                }else{
                    $relation   = $this->db->anggota_kelas->insert(array("id_user"=>"$user", "id_kelas"=>"$query[_id]"));
                    $status     = "Success";
                    $message    = "Kamu berhasil bergabung kedalam Kelas!";
                    $newID      = "$query[_id]";
                }
            }
        }else {
            $status     = "Failed";
            $message    = "Maaf, tidak ada kelas dengan kode tersebut!";
        }
        $result = array("status" => $status, "message"=>$message, "IDKelas" => $newID);
        return $result;
    }
}

?>
