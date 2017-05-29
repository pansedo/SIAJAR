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

    public function GetMediaPagging()
    {
    	$page = isset($_GET['page']) ? $_GET['page'] : 1;
    	$limit = 9;
    	$skip = ($page - 1)*$limit;
    	$next = ($page+1);
    	$prev = ($page-1);
    	$short = array('_id' => -1);
    	$query =  $this -> table -> find()->skip($skip)->limit($limit)->sort($short);
    	// echo $query;
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

    public function Pagging($page){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
    	$limit = 9;
    	$skip = ($page - 1)*$limit;
    	$next = ($page+1);
    	$prev = ($page-1);
    	$cursor = $this -> table -> find()->skip($skip)->limit($limit);
    	$total= $cursor->count();
		if($page > 1){
			    echo '<a class="btn btn-sucess" href="?page=' . $prev . '"><b>< Previous</b> </a>';
			    if($page * $limit < $total) {
			        echo ' <a class="btn btn-sucess" href="?page=' . $next . '"><b>Next ></b></a>';
			    }
			} else {
			    if($page * $limit < $total) {
			        echo ' <a class="btn btn-sucess" href="?page=' . $next . '"><b>Next ></b></a>';
			    }
			}
    }

    public function GetMediaBy($id)
    {
    	$query =  $this -> table -> findone(array("_id"=> new MongoId($id)));
    	return $query;
    }

    public function GetMediaByLimit($limit){
    	$query = $this-> table-> find () -> limit($limit);
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

    public function GetCountData()
    {	
    	$query['dokumen'] = $this-> table-> find () -> count();
    	$query['user'] = $this-> db -> user -> find () -> count();
 	 	$query['tag'] = $this-> db -> tag -> count();
 	 	$query['kategori'] = $this-> db -> kategori -> find((array("sub_id"=>"0"))) ->count();
		// $query['tag'] = $this-> db -> tag -> aggregate ([
		// 		{ $group: {
		// 		    "_id": "$nama"
		// 			}
		// 		},
		// 	    {
		// 	      $count: "total"
		// 	    }
		// ]);

    	return $query;
    }

    public function GetMediabyUser($id)
    {
    	$page = isset($_GET['page']) ? $_GET['page'] : 1;
    	$limit = 9;
    	$skip = ($page - 1)*$limit;
    	$next = ($page+1);
    	$prev = ($page-1);
    	$short = array('_id' => -1);
    	$query =  $this -> table -> find(array("id_user"=> "$id"))->skip($skip)->limit($limit)->sort($short);
    	$count = $query->count();
    	if ($count > 0) {
    		$i = 0;
    		
    		foreach ($query as $row) {
    			$data = $this->db->user->findOne(array("_id"=> new MongoId($row['id_user'])));
    			$kategori = $this->db->kategori->findone(array("_id"=> new MongoId($row['id_kategori'])));
    			$media[$i]=$row;
    			$media[$i]['nama_user'] = $data['nama'];
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
    public function PaggingByUser($id,$page){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
    	$limit = 9;
    	$skip = ($page - 1)*$limit;
    	$next = ($page+1);
    	$prev = ($page-1);
    	$query =  $this -> table -> find(array("id_user"=> "$id"))->skip($skip)->limit($limit);
    	$total= $query->count();
		if($page > 1){
			    echo '<a class="btn btn-sucess" href="?page=' . $prev . '"><b>< Previous</b> </a>';
			    if($page * $limit < $total) {
			        echo ' <a class="btn btn-sucess" href="?page=' . $next . '"><b>Next ></b></a>';
			    }
			} else {
			    if($page * $limit < $total) {
			        echo ' <a class="btn btn-sucess" href="?page=' . $next . '"><b>Next ></b></a>';
			    }
			}
    }
   public function CreateMedia($iduser,$judul,$deskripsi,$kategori,$tags,$tautan,$dokumen,$image)
    {	
    	$lokasi_file_image 	= $_FILES['image']['tmp_name'];
		$nama_file_image   	= $_FILES['image']['name'];
		$type_file_image   	= pathinfo($nama_file_image,PATHINFO_EXTENSION);
		$namagambar			= md5($iduser.date('Y-m-d H:i:s:u')).".".$type_file_image; 

		$lokasi_file_dokumen = $_FILES['dokumen']['tmp_name'];
		$nama_file_dokumen   = $_FILES['dokumen']['name'];
		$type_file_dokumen   = pathinfo($nama_file_dokumen,PATHINFO_EXTENSION);
		$namadokumen		 = md5($iduser.date('Y-m-d H:i:s:u')).".".$type_file_dokumen; 

    	$idDirektoriGambar  = "../Media/Gambar/".$iduser;
		$idDirektoriDokumen = "../Media/Dokumen/".$iduser;

		if (!is_dir($idDirektoriGambar)&&!is_dir($idDirektoriDokumen)) {
			mkdir($idDirektoriGambar, 0744);
			mkdir($idDirektoriDokumen, 0744);
		}
		elseif(!is_dir($idDirektoriGambar)){
		    mkdir($idDirektoriGambar, 0744);
		}elseif (!is_dir($idDirektoriDokumen)) {
			mkdir($idDirektoriDokumen, 0744);
		}

    	chmod($idDirektoriGambar, 0777);
    	chmod($idDirektoriDokumen, 0777);

		$direktori_image   	= "Media/Gambar/".$iduser."/".$namagambar;
	    move_uploaded_file($lokasi_file_image,"../".$direktori_image);
	    
	    $direktori_dokumen = "";
	    if ($dokumen != "") {
	    	$format = array("doc", "docx", "pdf","xls");
	    	if(in_array(strtolower($type_file_dokumen), $format)){
    			$direktori_dokumen   = "Media/Dokumen/".$iduser."/".$namadokumen;
				move_uploaded_file($lokasi_file_dokumen,"../".$direktori_dokumen);
    		}else{
				echo "<script>alert('File Bukan Tipe Dokumen !'); document.location.href='Media.php'</script>";
				die();
		    }
	    }

	    chmod($idDirektoriGambar, 0744);
    	chmod($idDirektoriDokumen, 0744);

    	$insert = array("id_user" => $iduser,
    	 "judul" => $judul ,
    	 "deskripsi" => $deskripsi ,
    	 "id_kategori" => $kategori ,
    	 "path_image" => $direktori_image,
    	 "tautan" => $tautan ,
    	 "path_document" => $direktori_dokumen,
    	 "active" => "active",
    	 "date_created" => date("Y-m-d H:i:s"),
    	 "date_modified" => date("Y-m-d H:i:s")
    	 );

        $insertdokumen = $this -> table -> insert($insert);
        $IDDokumen = $insert['_id'];
        
        $explodetags = explode(",",$tags);
        foreach ($explodetags as $tag) {
        	$inserts = array("id_dokumen" => "$IDDokumen", "nama" => $tag );
        	$inserttag = $this -> db -> tag -> insert($inserts);
        }
        echo "<script type='text/javascript'>swal({
				  title: 'Berhasil !',
				  text: 'Media ajar berhasil disimpan!',
				  type: 'success',
				  timer: 2000
				}).then(
				  function () {
				  	document.location.href='media.php';
				  },
				  function (dismiss) {
				  	document.location.href='media.php';
				    if (dismiss === 'timer') {
				      console.log('I was closed by the timer')
				    }
				  })</script>";
	
    }

    public function CreateMediaUser($iduser,$judul,$deskripsi,$kategori,$tags,$tautan,$dokumen,$image)
    {	 
    	if (isset($_FILES['image']['name'])) {
    	
    		$lokasi_file_image 	= $_FILES['image']['tmp_name'];
			$nama_file_image   	= $_FILES['image']['name'];
			$type_file_image   	= pathinfo($nama_file_image,PATHINFO_EXTENSION);
			$namagambar			= md5($iduser.date('Y-m-d H:i:s:u')).".".$type_file_image; 
	    	
	    	$format_img = array("jpg","png","jpeg");
	    	$format = array("jpg", "jpeg", "png", "gif", "bmp", "pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx", "mp4", "3gp", "flv", "avi", "mp3", "ogg");
	    	$idDirektoriGambar = "Media/Gambar/".$iduser;

	    	if(in_array(strtolower($type_file_image), $format_img)){
				if (!is_dir($idDirektoriGambar)) {
					mkdir($idDirektoriGambar, 0744);
				}
		    	chmod($idDirektoriGambar, 0777);

				$direktori_image   	= "Media/Gambar/".$iduser."/".$namagambar;
			    $upload_gambar = move_uploaded_file($lokasi_file_image,$direktori_image);

			    if ($upload_gambar) {
			    	# code...
				    if (isset($_FILES['dokumen']['name'])) {
			    		# code...
			    		$lokasi_file_dokumen = $_FILES['dokumen']['tmp_name'];
						$nama_file_dokumen   = $_FILES['dokumen']['name'];
						$type_file_dokumen   = pathinfo($nama_file_dokumen,PATHINFO_EXTENSION);
						$namadokumen		 = md5($iduser.date('Y-m-d H:i:s:u')).".".$type_file_dokumen;
						$idDirektoriDokumen = "Media/Dokumen/".$iduser;

						if(in_array(strtolower($type_file_dokumen), $format)){
							if (!is_dir($idDirektoriDokumen)) {
								mkdir($idDirektoriDokumen, 0744);
							}
							
					    	chmod($idDirektoriDokumen, 0777);
					    	$direktori_dokumen   = "Media/Dokumen/".$iduser."/".$namadokumen;
				    		$upload_dokumen = move_uploaded_file($lokasi_file_dokumen,$direktori_dokumen);

				    		if ($upload_dokumen) {
				    			# code...
				    			$insert = array("id_user" => "$iduser",
						    	 "judul" => $judul ,
						    	 "deskripsi" => $deskripsi ,
						    	 "id_kategori" => $kategori ,
						    	 "path_image" => $direktori_image,
						    	 "tautan" => $tautan ,
						    	 "path_document" => $direktori_dokumen,
						    	 "active" => "active",
						    	 "date_created" => date("Y-m-d H:i:s"),
						    	 "date_modified" => date("Y-m-d H:i:s")
						    	  );

						        $insertdokumen = $this -> table -> insert($insert);
						        $IDDokumen = $insert['_id'];
						        
						        $explodetags = explode(",",$tags);
						        foreach ($explodetags as $tag) {
						        	$inserts = array("id_dokumen" => $IDDokumen, "nama" => $tag );
						        	$inserttag = $this -> db -> tag -> insert($inserts);
						        }

						        if ($insertdokumen) {
						        	# code...
						        	chmod($idDirektoriDokumen, 0744);
						        	echo "<script type='text/javascript'>swal({
															  title: 'Berhasil !',
															  text: 'Media ajar berhasil disimpan!',
															  type: 'success',
															  timer: 2000
															}).then(
															  function () {
															  	//document.location.href='media.php';
															  },
															  function (dismiss) {
															  	//document.location.href='media.php';
															    if (dismiss === 'timer') {
															      console.log('I was closed by the timer')
															    }
															  })</script>";
						        }else{
						        	echo "<script type='text/javascript'>swal({
															  title: 'Gagal !',
															  text: 'Media ajar gagal disimpan!',
															  type: 'error',
															  timer: 2000
															}).then(
															  function () {
															  	//document.location.href='media.php';
															  },
															  function (dismiss) {
															  	//document.location.href='media.php';
															    if (dismiss === 'timer') {
															      console.log('I was closed by the timer')
															    }
															  })</script>";
						        }
				    		}
						}else{
							echo "<script type='text/javascript'>swal({
															  title: 'Format file media tidak didukung !',
															  text: 'Format yang didukung untuk dokumen hanya jpg, jpeg, png, gif, bmp, pdf, doc, docx, ppt, pptx, xls, xlsx, mp4, 3gp, flv, avi, mp3, ogg.',
															  type: 'error',
															  timer: 3000
															}).then(
															  function () {
															  	//document.location.href='media.php';
															  },
															  function (dismiss) {
															  	//document.location.href='media.php';
															    if (dismiss === 'timer') {
															      console.log('I was closed by the timer')
															    }
															  })</script>"; 
						}
			    	}else{
						$insert = array("id_user" => "$iduser",
								    	"judul" => $judul ,
								    	"deskripsi" => $deskripsi ,
								    	"id_kategori" => $kategori ,
								    	"path_image" => $direktori_image,
								    	"tautan" => $tautan ,
								    	"path_document" => "",
								    	"active" => "active",
								    	"date_created" => date("Y-m-d H:i:s"),
								    	"date_modified" => date("Y-m-d H:i:s" ));

					        $insertdokumen = $this -> table -> insert($insert);
					        $IDDokumen = $insert['_id'];
					        
					        $explodetags = explode(",",$tags);
					        foreach ($explodetags as $tag) {
					        	$inserts = array("id_dokumen" => $IDDokumen, "nama" => $tag );
					        	$inserttag = $this -> db -> tag -> insert($inserts);
					        }

					        if ($insertdokumen) {
					        	# code...
					        	echo "<script type='text/javascript'>swal({
															  title: 'Berhasil !',
															  text: 'Media ajar berhasil disimpan!',
															  type: 'success',
															  timer: 2000
															}).then(
															  function () {
															  	//document.location.href='media.php';
															  },
															  function (dismiss) {
															  	//document.location.href='media.php';
															    if (dismiss === 'timer') {
															      console.log('I was closed by the timer')
															    }
															  })</script>";
					        }else{
					        	echo "<script type='text/javascript'> swal({
															  title: 'Gagal !',
															  text: 'Media ajar gagal disimpan!',
															  type: 'error',
															  timer: 2000
															}).then(
															  function () {
															  	//document.location.href='media.php';
															  },
															  function (dismiss) {
															  	//document.location.href='media.php';
															    if (dismiss === 'timer') {
															      console.log('I was closed by the timer')
															    }
															  })</script>";
					        }
			    	}
			    }
		    chmod($idDirektoriGambar, 0744);
	    	

	    	}else{
	    		echo "<script type='text/javascript'>swal({
															  title: 'Gagal !',
															  text: 'Jenis File tidak didukung!',
															  type: 'error',
															  timer: 2000
															}).then(
															  function () {
															  	//document.location.href='media.php';
															  },
															  function (dismiss) {
															  	//document.location.href='media.php';
															    if (dismiss === 'timer') {
															      console.log('I was closed by the timer')
															    }
															  })</script>";
	    	}
    	}else{
    		echo "<script type='text/javascript'> swal({
															  title: 'Gagal !',
															  text: 'Silakan Pilih sampul terlebih dahulu',
															  type: 'error',
															  timer: 2000
															}).then(
															  function () {
															  	//document.location.href='media.php';
															  },
															  function (dismiss) {
															  	//document.location.href='media.php';
															    if (dismiss === 'timer') {
															      console.log('I was closed by the timer')
															    }
															  })</script>";
    	}
    }

    public function EditMedia($id,$iduser,$judul,$deskripsi,$kategori,$tags,$tautan,$dokumen,$image,$gambar_lama,$file_lama)
    {
    	
    	if ($dokumen != "") {
			$lokasi_file_dokumen = $_FILES['dokumen']['tmp_name'];
			$nama_file_dokumen   = $_FILES['dokumen']['name'];
			$type_file_dokumen   = pathinfo($nama_file_dokumen,PATHINFO_EXTENSION);
			$namadokumen		 = md5($iduser.date('Y-m-d H:i:s:u')).".".$type_file_dokumen;
    	}

    	if ($image != "") {
    		$lokasi_file_image 	= $_FILES['image']['tmp_name'];
			$nama_file_image   	= $_FILES['image']['name'];
			$type_file_image   	= pathinfo($nama_file_image,PATHINFO_EXTENSION);
			$namagambar			= md5($iduser.date('Y-m-d H:i:s:u')).".".$type_file_image; 
    	}

    	$idDirektoriGambar = "Media/Gambar/".$iduser;
		$idDirektoriDokumen = "Media/Dokumen/".$iduser;

		if (!is_dir($idDirektoriGambar)&&!is_dir($idDirektoriDokumen)) {
			mkdir("../".$idDirektoriGambar, 0744);
			mkdir("../".$idDirektoriDokumen, 0744);
		}
		elseif(!is_dir($idDirektoriGambar)){
		    mkdir("../".$idDirektoriGambar, 0744);
		}elseif (!is_dir($idDirektoriDokumen)) {
			mkdir("../".$idDirektoriDokumen, 0744);
		}

		chmod("../".$idDirektoriGambar, 0777);
    	chmod("../".$idDirektoriDokumen, 0777);

	    $direktori_dokumen = "";
	    if ($dokumen != "") {
    		$format = array("doc", "docx", "pdf","xls","ppt","pptx");
    		if(in_array(strtolower($type_file_dokumen), $format)){
    			unlink("../".$file_lama);
    			$direktori_dokumen   = "Media/Dokumen/".$iduser."/".$namadokumen;
				move_uploaded_file($lokasi_file_dokumen,"../".$direktori_dokumen);
				if($image == ""){
		    		$edit = array(
			    		"id_user" => "$iduser",
						"judul" => $judul,
						"deskripsi" => $deskripsi,
						"id_kategori" => $kategori,
						"tautan" => $tautan,
						"path_document" => $direktori_dokumen,
		    	 		"date_modified" => date("Y-m-d H:i:s")
					);
		    	}else{
		    		$direktori_image   	= "Media/Gambar/".$iduser."/".$namagambar;
		    		$upload_image = move_uploaded_file($lokasi_file_image,"../".$direktori_image);
		    		if ($upload_image) {
		    			unlink("../".$gambar_lama);
		    			$edit = array(
				    		"id_user" => "$iduser",
							"judul" => $judul,
							"deskripsi" => $deskripsi,
							"id_kategori" => $kategori,
							"path_image" => $direktori_image,
							"tautan" => $tautan,
							"path_document" => $direktori_dokumen,
			    	 		"date_modified" => date("Y-m-d H:i:s")
						);
		    		}else{
		    			$edit = array(
				    		"id_user" => "$iduser",
							"judul" => $judul,
							"deskripsi" => $deskripsi,
							"id_kategori" => $kategori,
							"tautan" => $tautan,
			    	 		"date_modified" => date("Y-m-d H:i:s")
						);
		    		}
		    		
		    	}
    	
    		}else{
				echo "<script>alert('File Bukan Tipe Dokumen !'); document.location.href='media.php'</script>";
				die();
		    }
	    }else{
	    	if($image == ""){
	    		$edit = array(
		    		"id_user" => "$iduser",
					"judul" => $judul,
					"deskripsi" => $deskripsi,
					"id_kategori" => $kategori,
					"tautan" => $tautan,
	    	 		"date_modified" => date("Y-m-d H:i:s")
				);
	    	}else{
	    		$direktori_image   	= "Media/Gambar/".$iduser."/".$namagambar;
	    		$upload_image = move_uploaded_file($lokasi_file_image,"../".$direktori_image);
	    		if ($upload_image) {
	    			unlink("../".$gambar_lama);
	    			$edit = array(
			    		"id_user" => "$iduser",
						"judul" => $judul,
						"deskripsi" => $deskripsi,
						"id_kategori" => $kategori,
						"path_image" => $direktori_image,
						"tautan" => $tautan,
		    	 		"date_modified" => date("Y-m-d H:i:s")
					);
		    		}else{
		    			$edit = array(
				    		"id_user" => "$iduser",
							"judul" => $judul,
							"deskripsi" => $deskripsi,
							"id_kategori" => $kategori,
							"tautan" => $tautan,
			    	 		"date_modified" => date("Y-m-d H:i:s")
						);
	    			}
	    		}
    	}

	    chmod($idDirektoriGambar, 0744);
    	chmod($idDirektoriDokumen, 0744);
    	
        $updatedokumen = $this ->table -> update(array("_id"=> new MongoId($id)),array('$set'=>$edit)); 
		
		
		if ($updatedokumen) {
			# code...
			$deleteTags = array(
				"id_dokumen" => "$id"
				);  

			$deleteTag = $this -> db -> tag ->remove($deleteTags);  

			$explodetags = explode(",",$tags);
			foreach ($explodetags as $tag) {
				$inserts = array("id_dokumen" => "$id", "nama" => $tag );
				$inserttag = $this -> db -> tag -> insert($inserts);
			}
			echo "<script type='text/javascript'>swal({
				  title: 'Berhasil !',
				  text: 'Media ajar berhasil di rubah!',
				  type: 'success',
				  timer: 2000
				}).then(
				  function () {
				  	document.location.href='media.php';
				  },
				  function (dismiss) {
				  	document.location.href='media.php';
				    if (dismiss === 'timer') {
				      console.log('I was closed by the timer')
				    }
				  })</script>";
		}else{
			echo "<script type='text/javascript'>swal({
				  title: 'Berhasil !',
				  text: 'Media ajar berhasil di rubah!',
				  type: 'warning',
				  timer: 2000
				}).then(
				  function () {
				  	document.location.href='media.php';
				  },
				  function (dismiss) {
				  	document.location.href='media.php';
				    if (dismiss === 'timer') {
				      console.log('I was closed by the timer')
				    }
				  })</script>";
		}
    }

    public function EditMediaUser($id,$iduser,$judul,$deskripsi,$kategori,$tags,$tautan,$dokumen,$image,$gambar_lama,$file_lama)
    {
    	
    	if ($dokumen != "") {
			$lokasi_file_dokumen = $_FILES['dokumen']['tmp_name'];
			$nama_file_dokumen   = $_FILES['dokumen']['name'];
			$type_file_dokumen   = pathinfo($nama_file_dokumen,PATHINFO_EXTENSION);
			$namadokumen		 = md5($iduser.date('Y-m-d H:i:s:u')).".".$type_file_dokumen;
    	}

    	if ($image != "") {
    		$lokasi_file_image 	= $_FILES['image']['tmp_name'];
			$nama_file_image   	= $_FILES['image']['name'];
			$type_file_image   	= pathinfo($nama_file_image,PATHINFO_EXTENSION);
			$namagambar			= md5($iduser.date('Y-m-d H:i:s:u')).".".$type_file_image; 
    	}

    	$idDirektoriGambar = "Media/Gambar/".$iduser;
		$idDirektoriDokumen = "Media/Dokumen/".$iduser;

		if (!is_dir($idDirektoriGambar)&&!is_dir($idDirektoriDokumen)) {
			mkdir($idDirektoriGambar, 0744);
			mkdir($idDirektoriDokumen, 0744);
		}
		elseif(!is_dir($idDirektoriGambar)){
		    mkdir($idDirektoriGambar, 0744);
		}elseif (!is_dir($idDirektoriDokumen)) {
			mkdir($idDirektoriDokumen, 0744);
		}

		chmod($idDirektoriGambar, 0777);
    	chmod($idDirektoriDokumen, 0777);

	    $direktori_dokumen = "";
	    if ($dokumen != "") {
    		$format = array("jpg", "jpeg", "png", "gif", "bmp", "pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx", "mp4", "3gp", "flv", "avi", "mp3", "ogg");
    		if(in_array(strtolower($type_file_dokumen), $format)){
    			unlink($file_lama);
    			$direktori_dokumen   = "Media/Dokumen/".$iduser."/".$namadokumen;
				move_uploaded_file($lokasi_file_dokumen,$direktori_dokumen);
				if($image == ""){
		    		$edit = array(
			    		"id_user" => "$iduser",
						"judul" => $judul,
						"deskripsi" => $deskripsi,
						"id_kategori" => $kategori,
						"tautan" => $tautan,
						"path_document" => $direktori_dokumen,
		    	 		"date_modified" => date("Y-m-d H:i:s")
					);
		    	}else{
		    		$direktori_image   	= "Media/Gambar/".$iduser."/".$namagambar;
		    		$upload_image = move_uploaded_file($lokasi_file_image,$direktori_image);
		    		if ($upload_image) {
		    			unlink($gambar_lama);
		    			$edit = array(
				    		"id_user" => "$iduser",
							"judul" => $judul,
							"deskripsi" => $deskripsi,
							"id_kategori" => $kategori,
							"path_image" => $direktori_image,
							"tautan" => $tautan,
							"path_document" => $direktori_dokumen,
			    	 		"date_modified" => date("Y-m-d H:i:s")
						);
		    		}else{
		    			$edit = array(
				    		"id_user" => "$iduser",
							"judul" => $judul,
							"deskripsi" => $deskripsi,
							"id_kategori" => $kategori,
							"tautan" => $tautan,
			    	 		"date_modified" => date("Y-m-d H:i:s")
						);
		    		}
		    		
		    	}
    	
    		}else{
				echo "<script>swal({
								  title: 'Gagal !',
								  text: 'Jenis File tidak didukung!',
								  type: 'error',
								  timer: 2000
								}).then(
								  function () {
								  	//document.location.href='media.php';
								  },
								  function (dismiss) {
								  	//document.location.href='media.php';
								    if (dismiss === 'timer') {
								      console.log('I was closed by the timer')
								    }
								  })</script>";
				die();
		    }
	    }else{
	    	if($image == ""){
		    		$edit = array(
			    		"id_user" => "$iduser",
						"judul" => $judul,
						"deskripsi" => $deskripsi,
						"id_kategori" => $kategori,
						"tautan" => $tautan,
		    	 		"date_modified" => date("Y-m-d H:i:s")
					);
		    	}else{
		    		$direktori_image   	= "Media/Gambar/".$iduser."/".$namagambar;
		    		$upload_image = move_uploaded_file($lokasi_file_image,$direktori_image);
		    		if ($upload_image) {
		    			unlink($gambar_lama);
		    			$edit = array(
				    		"id_user" => "$iduser",
							"judul" => $judul,
							"deskripsi" => $deskripsi,
							"id_kategori" => $kategori,
							"path_image" => $direktori_image,
							"tautan" => $tautan,
							"path_document" => $direktori_dokumen,
			    	 		"date_modified" => date("Y-m-d H:i:s")
						);
		    		}else{
		    			$edit = array(
				    		"id_user" => "$iduser",
							"judul" => $judul,
							"deskripsi" => $deskripsi,
							"id_kategori" => $kategori,
							"tautan" => $tautan,
			    	 		"date_modified" => date("Y-m-d H:i:s")
						);
		    		}
		    	}
	    }

	    chmod($idDirektoriGambar, 0744);
    	chmod($idDirektoriDokumen, 0744);
    	

        $updatedokumen = $this ->table -> update(array("_id"=> new MongoId($id)),array('$set'=>$edit)); 
		
		
		if ($updatedokumen) {
			# code...
			$deleteTags = array(
				"id_dokumen" => "$id"
				);  

			$deleteTag = $this -> db -> tag ->remove($deleteTags);  

			$explodetags = explode(",",$tags);
			foreach ($explodetags as $tag) {
				$inserts = array("id_dokumen" => "$id", "nama" => $tag );
				$inserttag = $this -> db -> tag -> insert($inserts);
			}
			
			// echo "<script>swal('Berhasil diperbarui!', 'Informasi media ajar berhasil diperbarui', 'success'); document.location.href='profile.php'</script>";
			echo "<script>swal({
								  title: 'Berhasil diperbarui!',
								  text: 'Informasi media ajar berhasil diperbarui',
								  type: 'success',
								  timer: 2000
								}).then(
								  function () {
								  	document.location.href='profile.php';
								  },
								  function (dismiss) {
								  	document.location.href='profile.php';
								    if (dismiss === 'timer') {
								      console.log('I was closed by the timer')
								    }
								  })
				</script>";
		}else{
			echo "<script>alert('Data gagal di rubah !'); </script>";
		}
    }

    public function Delete($id)
    {
    	$dokumen = array("_id" => new MongoId($id));
    	$query =  $this -> table -> findone($dokumen);

    	$idDirektoriGambar  = "../Media/Gambar/".$query["id_user"];
		$idDirektoriDokumen = "../Media/Dokumen/".$query["id_user"];
    	
		chmod($idDirektoriGambar, 0777);
    	chmod($idDirektoriDokumen, 0777);

		$deletegambar = unlink("../".$query["path_image"]);    	
		$deletedokumen = unlink("../".$query["path_document"]);    
    	 
    	chmod($idDirektoriGambar, 0744);
    	chmod($idDirektoriDokumen, 0744);

		$this -> table -> remove($dokumen);

		$deleteTags = array(
			"id_dokumen" => "$id"
			);  

		$deleteTag = $this -> db -> tag ->remove($deleteTags);  

		echo "<script>alert('Data berhasil di delete !'); document.location.href='Media.php'</script>";
    }
    
    public function DeleteMediaUser($id)
    {
    	$dokumen = array("_id" => new MongoId($id));
    	$query =  $this -> table -> findone($dokumen);

    	$idDirektoriGambar  = "Media/Gambar/".$query["id_user"];
		$idDirektoriDokumen = "Media/Dokumen/".$query["id_user"];
    	
		chmod($idDirektoriGambar, 0777);
    	chmod($idDirektoriDokumen, 0777);

		$deletegambar = unlink($query["path_image"]);    	
		$deletedokumen = unlink($query["path_document"]);    
    	 
    	chmod($idDirektoriGambar, 0744);
    	chmod($idDirektoriDokumen, 0744);

		$delete= $this -> table -> remove($dokumen);

		$deleteTags = array(
			"id_dokumen" => "$id"
			);  

		$deleteTag = $this -> db -> tag ->remove($deleteTags);  

		if ($delete) {
			# code...
			echo "<script>swal({
								  title: 'Berhasil dihapus!',
								  text: 'Data media ajar berhasil dihapus',
								  type: 'success',
								  timer: 2000
								}).then(
								  function () {
								  	document.location.href='profile.php';
								  },
								  function (dismiss) {
								  	document.location.href='profile.php';
								    if (dismiss === 'timer') {
								      console.log('I was closed by the timer')
								    }
								  })
				</script>";
		}else{
			echo "<script>swal({
								  title: 'Gagal dihapus!',
								  text: 'Data media ajar gagal dihapus',
								  type: 'error',
								  timer: 2000
								}).then(
								  function () {
								  	document.location.href='profile.php';
								  },
								  function (dismiss) {
								  	document.location.href='profile.php';
								    if (dismiss === 'timer') {
								      console.log('I was closed by the timer')
								    }
								  })
				</script>";
		}
    }

    // const ACCENT_STRINGS = 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËẼÌÍÎÏĨÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëẽìíîïĩðñòóôõöøùúûüýÿ';
    // const NO_ACCENT_STRINGS = 'SOZsozYYuAAAAAAACEEEEEIIIIIDNOOOOOOUUUUYsaaaaaaaceeeeeiiiiionoooooouuuuyy';

  //    public function accentToRegex($text)
  //   {
 
  //       $from = str_split(utf8_decode(self::ACCENT_STRINGS));
  //       $to   = str_split(strtolower(self::NO_ACCENT_STRINGS));
  //       $text = utf8_decode($text);
  //       $regex = array();
  //       foreach ($to as $key => $value) {
  //           if (isset($regex[$value])) {
  //               $regex[$value] .= $from[$key];
  //           } else {
  //               $regex[$value] = $value;
  //           }
  //       }
  //       foreach ($regex as $rg_key => $rg) {
  //           $text = preg_replace("/[$rg]/", "_{$rg_key}_", $text);
  //       }
  //       foreach ($regex as $rg_key => $rg) {
  //           $text = preg_replace("/_{$rg_key}_/", "[$rg]", $text);
  //       }
 	// 	 $search = utf8_encode($text);
 	// 	$query =  array('judul' =>new MongoRegex("/.*{$search}.*/i"));
 	// 	// db.dokumen.find({$text:{$search:"$query"}})
		// $cursosr = $this -> table ->find(array($text=>array($search=>"$text")));
		// // $cursosr = $this -> table ->find($query);
		// var_dump($query);
		// foreach ($cursosr as $key ) {
		// 	print_r($key['judul']);
		// 	var_dump($key['judul']);
		// }
		
		// // return $cursor;
       
  //   }
    public function SearchData($texts)
    {	
    	$page = isset($_GET['page']) ? $_GET['page'] : 1;
    	$limit = 15;
    	$skip = ($page - 1)*$limit;
    	$next = ($page+1);
    	$prev = ($page-1);
    	$short = array('_id' => -1);
    	$query =  $this -> table -> find(array('$text' => array('$search' => $texts)))-> skip($skip)->limit($limit);
    	
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

    	}else{
			echo "<script type='text/javascript'>swal({
					  title: 'Data Tidak Ditemukan',
					  text: 'Data Tidak Ditemukan!',
					  type: 'error',
					  timer: 2000
					}).then(
					  function () {
					  	document.location.href='index.php';
					  },
					  function (dismiss) {
					  	document.location.href='index.php';
					    if (dismiss === 'timer') {
					      console.log('I was closed by the timer')
					    }
				  })</script>";
    		die();
    	}
    	
        if ($count > 0) {
    		return $media;
    	}else{
    		return $count;
    	}
    }

     public function PaggingSearch($page,$texts){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
    	$limit = 9;
    	$skip = ($page - 1)*$limit;
    	$next = ($page+1);
    	$prev = ($page-1);
    	$cursor = $this -> table -> find(array('$text' => array('$search' => $texts)))-> skip($skip)->limit($limit);
    	$total= $cursor->count();
		if($page > 1){
			    echo '<a class="btn btn-sucess" href="?page=' . $prev . '"><b>< Previous</b> </a>';
			    if($page * $limit < $total) {
			        echo ' <a class="btn btn-sucess" href="?page=' . $next . '"><b>Next ></b></a>';
			    }
			} else {
			    if($page * $limit < $total) {
			        echo ' <a class="btn btn-sucess" href="?page=' . $next . '"><b>Next ></b></a>';
			    }
			}
    }

}

?>