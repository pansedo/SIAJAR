<?php
	include "include/header.php";
	include 'include/menu.php';

	if (!isset($_SESSION['lms_id']) && !isset($_SESSION['lms_username']) && !isset($_SESSION['lms_status'])) {
        header("Location:Auth/logout.php");
        exit();
    }else{ 
        set_time_limit(10000); 
        $id_users   = $_SESSION['lms_id'];
        $email    = $_SESSION['lms_username'];
        $status     = $_SESSION['lms_status'];
    }

    $classProfile = new Profile(); 
	$classKategori = new Kategori();
	$classMedia = new Media();
	$classTag = new Tag();

	$FuncProfile = $classProfile->GetData($id_users);
	$getMediaCount = $classMedia->GetMediabyUserCount($id_users);

	$getkategoriutama = $classKategori->GetKategoriUtama();
	$getMedia = $classMedia->GetMedia();

	if (isset($_POST['tambah_media'])) {
        $judul = mysql_escape_string($_POST['judul']);
        $deskripsi = $_POST['deskripsi'];
        $kategori = mysql_escape_string($_POST['kategori']);
        $tags = mysql_escape_string($_POST['tags']);
        if (isset($_POST['tautan'])) {
        	$tautan = mysql_escape_string($_POST['tautan']);
        }else{
        	$tautan = "";
        }
       
        if (isset($_FILES['dokumen']['name'])) {
        	# code...
        	$dokumen = mysql_escape_string($_FILES['dokumen']['name']);
        }else{
        	$dokumen = "";
        }
        // echo "<script>alert('test');</script>";
        $image = mysql_escape_string($_FILES['image']['name']);
        $iduser = $id_users;
        $classMedia->CreateMediaUser($iduser,$judul,$deskripsi,$kategori,$tags,$tautan,$dokumen,$image); 
        
	}
	if (isset($_POST['update_media'])) {
		# code...
		$id           = base64_decode($_GET['id']);
		$judul = mysql_escape_string($_POST['judul']);
        $deskripsi = $_POST['deskripsi'];
        $kategori = mysql_escape_string($_POST['kategori']);
        $tags = mysql_escape_string($_POST['tags']);
        if (isset($_POST['tautan'])) {
        	$tautan = mysql_escape_string($_POST['tautan']);
        }else{
        	$tautan = "";
        }
        if (isset($_FILES['dokumen'])) {
         	$dokumen = mysql_escape_string($_FILES['dokumen']['name']);
         }else{
         	$dokumen ="";
         } 
        $image = mysql_escape_string($_FILES['image']['name']);
        $iduser = $id_users;
        $gambar_lama = mysql_escape_string($_POST['gambar_lama']);
        $file_lama = mysql_escape_string($_POST['file_lama']);
        $classMedia->EditMediaUser($id,$iduser,$judul,$deskripsi,$kategori,$tags,$tautan,$dokumen,$image,$gambar_lama,$file_lama);
	}
?> 
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
					<section class="box-typical">
						<div class="profile-card ">
							<div class="profile-card-photo">
								<img src="Assets/foto/<?php if ($FuncProfile['foto'] != NULL) {echo $FuncProfile['foto'];}else{echo "no_picture.png";} ?>" alt=""/>
							</div>
							<div class="profile-card-name"><?php echo $FuncProfile['nama'];?></div>
							<div class="profile-card-status"><?php echo $FuncProfile['sekolah'];?></div>
							<!-- <div class="profile-card-location">Asal Sekolah</div> -->
						</div>
						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
									<b><?php echo $getMediaCount; ?></b>
									Media Bahan Ajar
								</div>
							</div>
						</div>

						<ul class="profile-links-list">
							<li class="nowrap">
								<i class="font-icon font-icon-earth-bordered"></i> 
								<a href="#"><?php echo $FuncProfile['sosmed']['website'];?></a>
							</li>
							<li class="nowrap">
								<i class="font-icon font-icon-fb-fill"></i> 
								<a href="#"><?php echo $FuncProfile['sosmed']['facebook'];?></a>
							</li>
							<li class="nowrap">
								<i class="font-icon font-icon-calend"></i> 
								<a href="#"><?php echo selisih_waktu($FuncProfile['date_created']);?></a>
							</li> 
							 
						</ul>
					</section>
				</div>
				<div class="col-lg-9 col-lg-pull-6 col-md-6 col-sm-6">
				<!-- Mulai Buku Content -->
				<?php if (isset($_GET['action'])){
						if ($_GET['action'] == "unggah") {
							# code...
						?>
					

						<section class="card">
						<div class="card-block">
							<h5 class="with-border">Media Ajar</h5>
							<form  action="#" method="POST" role="form" enctype="multipart/form-data">
								<div class="row">
									<div class="col-lg-4">
										<div id="image-preview">
										  <label for="image-upload" id="image-label">Choose File</label>
										  <input type="file" name="image" id="image-upload" required/>
										</div>
									</div>
									<div class="col-lg-8">
								
										<fieldset class="form-group">
											<label class="form-label">Judul</label>
											<input type="text" name="judul" required class="form-control maxlength-simple" id="exampleInput" placeholder="Judul" maxlength="45">
										</fieldset>
										<fieldset class="form-group">
											<label class="form-label">Deskripsi</label>
											<textarea rows="4" class="form-control maxlength-simple" name="deskripsi" required></textarea>
										</fieldset>
										<fieldset class="form-group">
											<div class="row">
												<div class="col-lg-6">
													<label class="form-label">Kategori</label>
													<select  name="kategori" required class="bootstrap-select bootstrap-select-arrow" >
													   <?php 
															$no = 1;
															foreach ($getkategoriutama as $data) {
														    	?>
																	<option value="<?php echo $data['_id'];?>"><?php echo $data['kategori']; ?></option>
														    	<?php
														    	$no++;
															}
															?>
													</select>
												</div>
												<div class="col-lg-6">
													<label class="form-label">Resource Document</label>
													<select id="option" class="bootstrap-select bootstrap-select-arrow">
													   <option>-- Pilih Salah --</option>       
													   <option value="opt1">Link Website</option>
													   <option value="opt2">Dokumen</option>
													</select>
												</div>
												
											</div>
										</fieldset>
										<fieldset class="form-group" id="data">
											<div class="col-lg-12" >
												
											</div>
										</fieldset>
										<fieldset class="form-group">
											<label class="form-label">Tags</label>
											<textarea id="tags-editor-textarea" name="tags"></textarea>
										</fieldset>
									</div>
								</div>
								<div style="text-align: right">
								   <button type="submit" class="btn btn-primary" name="tambah_media" href="#" style="text-align: right;">Tambah Media</button>
								</div>
									
							</form>
						</div>
					</section>

					<?php
					}else if ($_GET['action'] == "hapus") {
						# code...
						if (isset($_GET['id'])) {
							# code...
							$id = base64_decode($_GET['id']);
							$classMedia->DeleteMediaUser($id);
						}
					}

					else if ($_GET['action'] == "edit") {
						# code...
					
						if (isset($_GET['id'])) {
							# code...
							$id = base64_decode($_GET['id']);
							$getMediaById = $classMedia->GetMediaBy($id);
							$getTagByMedia = $classTag->TagByMedia($id);
					?>

					<section class="card">
						<div class="card-block">
							<h5 class="with-border">Media Ajar</h5>
							<form  action="#" method="POST" role="form" enctype="multipart/form-data">
								<div class="row">
									<div class="col-lg-4">
										<div id="image-preview" style="background-image: url('<?php echo $getMediaById['path_image'];?>'" >
										  <label for="image-upload" id="image-label">Choose File</label>
										  <input type="file" name="image" id="image-upload" />
										</div>
									</div>
									<div class="col-lg-8">
								
										<fieldset class="form-group">
											<label class="form-label">Judul</label>
											<input type="text" name="judul" required class="form-control maxlength-simple" id="exampleInput" value="<?php echo $getMediaById['judul'];?>" placeholder="Judul" maxlength="45">
										</fieldset>
										<fieldset class="form-group">
											<label class="form-label">Deskripsi</label>
											<textarea rows="4" class="form-control maxlength-simple" name="deskripsi" required><?php echo $getMediaById['deskripsi'];?></textarea>
										</fieldset>
										<fieldset class="form-group">
											<div class="row">
												<div class="col-lg-6">
													<label class="form-label">Kategori</label>
													<select  name="kategori" required class="bootstrap-select bootstrap-select-arrow" >
													   <?php 
															$no = 1;
															foreach ($getkategoriutama as $data) {
																if ($data['_id'] == $getMediaById['id_kategori'] ) {
																	?>
																		<option value="<?php echo $data['_id'];?>" selected><?php echo $data['kategori']; ?></option>
																	<?php
																}else{
														    	?>
																	<option value="<?php echo $data['_id'];?>"><?php echo $data['kategori']; ?></option>
														    	<?php
														    	}
														    	$no++;
															}
															?>
													</select>
												</div>
												<!-- <div class="col-lg-6">
													<label class="form-label">Resource Document</label>
													<select id="option" class="bootstrap-select bootstrap-select-arrow">
													   <option>-- Pilih Salah --</option>       
													   <option value="opt1">Link Website</option>
													   <option value="opt2">Dokumen</option>
													</select>
												</div> -->
												
											</div>
										</fieldset>
										<fieldset class="form-group" id="data">
											<?php
												if ($getMediaById['tautan'] != "") {
											?>
												<label class="form-label">Tautan</label> 
												<input type="text" name="tautan" class="form-control maxlength-simple" id="exampleInput" value="<?php echo $getMediaById['tautan'];?>" placeholder="http://" >
												
											<?php
													# code...
												}elseif ($getMediaById['path_document'] != "") {
											?>
												<label class="form-label">Unggah File</label>  <input  type="file" name="dokumen" id="file-7" class="form-control" />
												<a href="#">View</a>
											<?php

													# code...
												}
											?>
												
												
											
										</fieldset>
										<fieldset class="form-group">
											<label class="form-label">Tags</label>
											<textarea id="tags-editor-textarea" name="tags">
												<?php
													foreach ($getTagByMedia as $datatag) {
														echo $datatag['nama'].",";
													}
												?>
											</textarea>
										</fieldset>
									</div>
								</div>
								<div style="text-align: right">
									<input type="hidden" name="gambar_lama" value="<?php echo $getMediaById['path_image'];?>">
									<input type="hidden" name="file_lama" value="<?php echo $getMediaById['path_document'];?>">
								   <button type="submit" class="btn btn-primary" name="update_media" href="#" style="text-align: right;">Perbarui</button>
								</div>
									
							</form>
						</div>
					</section>
				<?php
					}
				}
			}
			?>
					
				<!-- Selesai Buku Content -->
				
				
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->
	<script type="text/javascript">

		$('#option').change(function() {
		    opt = $(this).val();
		    if (opt=="0") {
		        $('#data').html('<h2>Pilihan</h2>');
		    }else if (opt == "opt1") {
		        $('#data').html(' <label class="form-label">Tautan</label> <input type="text" name="tautan" class="form-control maxlength-simple" id="exampleInput" placeholder="http://" > ');
		    }else if (opt == "opt2") {
		        // $('#data').html('<label class="form-label">Unggah File</label>  <input hidden="true" type="file" name="file-7" id="file-7" class="inputfile" data-multiple-caption="{count} files selected" multiple /> <label for="file-7"><span></span> <strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> Choose a file&hellip;</strong></label>');
		        $('#data').html('<label class="form-label">Unggah File</label>  <input  type="file" name="dokumen" id="file-7" class="form-control" />');
		    }
		});
	</script>	

<?php
	include "include/footer.php";
?>