<?php

class Kelas
{
    public function __construct() {
        try {
            global $db;
            $tableName  = 'kelas';
            $this->db   = $db;
            $this->table= $this->db->$tableName;
        } catch(Exception $e) {
            echo "Database Not Connection";
            exit();
        }
    }
    public function CountKelas()
    {
        $query =  $this -> table -> find();
        $count = $query->count();
        return $count;
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
        $cek    = $this->table->find(array("kode" => $hasil))->count();
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
			$query1	= $this->db->anggota_kelas->find(array("id_kelas" => $idkelas));
            $query['member'] = $query1->count();
			if ($query['member'] > 0) {
			    foreach ($query1 as $member) {
			        $query['list_member'][]  = $member['id_user'];
			    }
			}
            $data   = $query;
		}
        return $data;
    }

    public function getKeanggotaan($idkelas, $iduser){
        $data	= $this->db->anggota_kelas->findOne(array('id_kelas'=>$idkelas, 'id_user'=>"$iduser"));

        return $data;
    }

    public function addKelas($nama, $user){
        $newID  = "";
        $kode   = $this->acakKodeKelas(6);
        $insert = array("nama" => $nama, 'kode'=> $kode, "tentang"=>"", "tkb"=>"", "status"=>"", "creator" => "$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->table->insert($insert);
        $newID  = $insert['_id'];
        if ($newID) {
            $status     = "Success";
            $message    = "Kelas $nama Berhasil ditambahkan!";
            $relation   = $this->db->anggota_kelas->insert(array( "id_user"=>"$user", "id_kelas"=>"$newID", "status"=>"1", "date_modified"=>date('Y-m-d H:i:s') ));
        }else {
            $status     = "Failed";
            $message    = "Kelas $nama Gagal ditambahkan!";
        }

        $result = array("status" => $status, "message"=>$message, "IDKelas" => $newID);
        return $result;
    }

    public function updateKelas($nama, $tentang, $tkb, $kelas){
        $update     = array('$set' => array("nama"=>$nama, "tentang"=>$tentang, "tkb"=>$tkb, "date_modified"=>date('Y-m-d H:i:s')));

          try {
              $this->table->update(array("_id" => new MongoId($kelas)), $update);
              $status   = "success";
              $judul    = "Berhasil!";
              $message  = "Pengaturan Kelas berhasil disimpan.";
          } catch(MongoCursorException $e) {
              $status   = "error";
              $judul    = "Maaf!";
              $message  = "Pengaturan Kelas gagal disimpan.";
          }

        $result = array("status" => $status, "judul" => $judul, "message"=>$message, "IDKelas" => $kelas);
        return $result;
    }

    public function joinKelas($kode, $user, $privilege){
        $newID  = "";
        $query  = $this->table->findOne(array("kode" => $kode));
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
                    $hak        = $privilege == "guru" ? 3 : 4;
                    $relation   = $this->db->anggota_kelas->insert( array( "id_user"=>"$user", "id_kelas"=>"$query[_id]", "status"=>$hak, "tkb"=>"", "date_modified"=>date('Y-m-d H:i:s') ) );
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

    public function addPost($post, $kelas, $user){
        $newID  = "";
        $insert = array("isi_postingan" => $post, 'id_kelas'=> "$kelas", "creator"=>"$user", "date_created"=>date('Y-m-d H:i:s'), "date_modified"=>date('Y-m-d H:i:s'));
                  $this->db->posting->insert($insert);
        $newID  = $insert['_id'];
        if ($newID) {
            $status     = "Success";
        }else {
            $status     = "Failed";
        }

        $result = array("status" => $status, "IDPosting" => $newID);
        return $result;
    }

    public function postingKelas($kelas){
        $query  = $this->db->posting->find(array("id_kelas" => $kelas))->sort(array('date_created' => -1));
		$count  = $query->count();
        $data   = array();

        if ($count > 0) {
            foreach ($query as $index => $isi) {
                $data[$index] = $isi;
                $userID	= new MongoId($isi['creator']);
                $query2 = $this->db->user->findOne(array('_id' => $userID));
                $data[$index]['user']       = $query2['nama'];
                $data[$index]['user_foto']  = $query2['foto'];
            }
        }

        $result = array("count" => $count, "data"=>$data);
        return $result;
    }

    public function postingSeluruh($user){
        $query  = $this->db->anggota_kelas->find(array("id_user"=>"$user"));
        $count  = $query->count();
        $count2 = 0;
        $data   = array();

        if($count > 0){
            foreach ($query as $isi) {
                $simpan[]['id_kelas'] = $isi['id_kelas'];
            }
            $query2 = $this->db->posting->find(array(
                                                '$or' => $simpan
                                            ))->sort(array('date_created' => -1));
    		$count2  = $query2->count();
            if ($count2 > 0) {
                foreach ($query2 as $index => $isi) {
                    $data[$index] = $isi;
                    $userID	    = new MongoId($isi['creator']);
                    $idkelas    = new MongoId($isi['id_kelas']);
                    $query3     = $this->db->user->findOne(array('_id' => $userID));
                    $query4     = $this->table->findOne(array('_id' => $idkelas));
                    $data[$index]['user']   = $query3['nama'];
                    $data[$index]['kelas']  = $query4['nama'];
                }
            }
        }

        $result = array("count" => $count2, "data"=>$data);
        return $result;
    }
}

?>
