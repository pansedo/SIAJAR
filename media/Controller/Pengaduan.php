<?php
	class Pengaduan
	{ 	
		public function __construct() {
			try{
				 global $db;  
	            $tableName = 'pengaduan';
	            $this->db = $db;
	            $this->table = $this->db->$tableName;
			}catch(Exception $e) {
	            echo "Database Not Connection";
	            exit();
       		}
		}

		public function GetPengaduan(){
			$query =  $this -> table -> find();
			$count = $query->count();
			if ($count > 0) {
    			$i = 0;
				foreach ($query as $row) {
	    			$user = $this->db->user->findOne(array("_id"=> new MongoId($row['id_user'])));
	    			$dokumen = $this->db->dokumen->findOne(array("_id"=> new MongoId($row['id_dokumen'])));
	    			$media[$i]=$row;
	    			$media[$i]['nama_user'] = $user['nama'];
	    			$media[$i]['media'] = $dokumen['judul'];
	    			$media[$i]['statuspengaduan'] = $row['status'];
	    			$media[$i]['dokumenactive'] = $dokumen['active'];
	    			$media[$i]['keterangan'] = $row['keterangan'];
	    			$media[$i]['idpengaduan'] = $row['_id'];
	    			$i++;
	    		}
	    	}
    		if ($count > 0) {
    			return $media;
	    	}else{
	    		return $count;
	    	}
		}

		public function CreatePengaduan($iddokumen,$keterangan,$id_users)
		{
			$insert = array(
				"id_user" => $id_users,
			    "id_dokumen" => $iddokumen,
			    "status" => "noncheck",
			    "keterangan" => $keterangan,
			    "date_created" => date("Y-m-d H:i:s"),
    	 		"date_modified" => date("Y-m-d H:i:s")
				);

			$insertpengaduan = $this -> table -> insert($insert);

			echo "<script type='text/javascript'>swal({
					  title: 'Berhasil !',
					  text: 'Dokumen NonAktif - Pengaduan Di Terima!',
					  type: 'success',
					  timer: 2000
					}).then(
					  function () {
					   history.go(-1);
					  },
					  function (dismiss) {
					  	history.go(-1);
					    if (dismiss === 'timer') {
					      console.log('I was closed by the timer')
					    }
					  })</script>";
		}
 
		public function CheckPengaduan($idpengaduan,$keterangan,$statuspengaduan)
		{
			if ($statuspengaduan == "nonactive") {
				$query = $this->table->findOne(array("_id"=> new MongoId($idpengaduan)));
				$editpengaduan = array(
					"status" => "check",
					"date_modified" => date("Y-m-d H:i:s")
					);
				$updatedokumen = $this ->table -> update(array("_id"=> new MongoId($idpengaduan)),array('$set'=>$editpengaduan));

				$editdokumen = array(
		    		"active" => "nonactive",
					"pengaduan" => $keterangan,
	    	 		"date_modified" => date("Y-m-d H:i:s")
				);
				$updatedokumen = $this ->db->dokumen -> update(array("_id"=> new MongoId($query['id_dokumen'])),array('$set'=>$editdokumen));
				echo "<script type='text/javascript'>swal({
					  title: 'Berhasil !',
					  text: 'Dokumen NonAktif - Pengaduan Di Terima!',
					  type: 'success',
					  timer: 2000
					}).then(
					  function () {
					  	document.location.href='pengaduan.php';
					  },
					  function (dismiss) {
					  	document.location.href='pengaduan.php';
					    if (dismiss === 'timer') {
					      console.log('I was closed by the timer')
					    }
					  })</script>";
			}elseif ($statuspengaduan == "active") {
				$query = $this->table->findOne(array("_id"=> new MongoId($idpengaduan)));
				$editpengaduan = array(
					"status" => "check",
					"date_modified" => date("Y-m-d H:i:s")
					);
				$updatedokumen = $this ->table -> update(array("_id"=> new MongoId($idpengaduan)),array('$set'=>$editpengaduan));
				echo "<script type='text/javascript'>swal({
					  title: 'Checked !',
					  text: 'Dokumen Tetap Aktif - Pengaduan Tidak di Terima!',
					  type: 'error',
					  timer: 2000
					}).then(
					  function () {
					  	document.location.href='pengaduan.php';
					  },
					  function (dismiss) {
					  	document.location.href='pengaduan.php';
					    if (dismiss === 'timer') {
					      console.log('I was closed by the timer')
					    }
					  })</script>";
			}else{
				echo "<script type='text/javascript'>swal({
					  title: 'Checked !',
					  text: 'Gagal',
					  type: 'error',
					  timer: 2000
					}).then(
					  function () {
					  	document.location.href='pengaduan.php';
					  },
					  function (dismiss) {
					  	document.location.href='pengaduan.php';
					    if (dismiss === 'timer') {
					      console.log('I was closed by the timer')
					    }
					  })</script>";
			}
			

		}
	}
?>