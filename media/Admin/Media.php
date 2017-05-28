<?php
	include 'header.php';
	include 'menu.php';

	$classKategori = new Kategori();
	$classMedia = new Media();
	$classTag = new Tag();

	$getkategoriutama = $classKategori->GetKategoriUtama();
	$getMedia = $classMedia->GetMedia();

 
	if (isset($_POST['tambah_media'])) {
        $judul = mysql_escape_string($_POST['judul']);
        $deskripsi = mysql_escape_string($_POST['deskripsi']);
        $kategori = mysql_escape_string($_POST['kategori']);
        $tags = mysql_escape_string($_POST['tags']);
        $tautan = mysql_escape_string($_POST['tautan']);
        $dokumen = mysql_escape_string($_FILES['dokumen']['name']);
        $image = mysql_escape_string($_FILES['image']['name']);
        $iduser = "58ec5cf21192a6e8180018bf";
        $classMedia->CreateMedia($iduser,$judul,$deskripsi,$kategori,$tags,$tautan,$dokumen,$image); 
	}  

	if (isset($_POST['edit_media'])) {
		$id           = base64_decode($_GET['id']);
		$judul = mysql_escape_string($_POST['judul']);
        $deskripsi = mysql_escape_string($_POST['deskripsi']);
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
        $iduser = "58ec5cf21192a6e8180018bf";
        $gambar_lama = mysql_escape_string($_POST['gambar_lama']);
        $file_lama = mysql_escape_string($_POST['file_lama']);
        $classMedia->EditMedia($id,$iduser,$judul,$deskripsi,$kategori,$tags,$tautan,$dokumen,$image,$gambar_lama,$file_lama); 
	}

?>
	<?php
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'tambah') { ?>
			<div class="page-content">
				<div class="container-fluid">
					<header class="section-header">
						<div class="row">
							<div class="col-md-10">
								<div class="tbl-cell">
									<h2>Tambah Media Ajar</h2>
									<div class="subtitle">Gudang Media </div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="tbl-cell" >
								
							</div>
						</div>
					</header>
					<section class="card">
						<div class="card-block">
							<h5 class="with-border">Media Ajar</h5>
							<form  action="#" method="POST" role="form" enctype="multipart/form-data">
								<div class="row">
									<div class="col-lg-4">
										<div id="image-preview">
										  <label for="image-upload" id="image-label">Choose File</label>
										  <input type="file" name="image" id="image-upload" required />
										</div>
									</div>
									<div class="col-lg-8">
								
										<fieldset class="form-group">
											<label class="form-label">Judul</label>
											<input type="text" name="judul" class="form-control maxlength-simple" id="exampleInput" required placeholder="Judul" maxlength="15">
										</fieldset>
										<fieldset class="form-group">
											<label class="form-label">Deskripsi</label>
											<textarea rows="4" class="form-control maxlength-simple"  name="deskripsi" required  ></textarea>
										</fieldset> 
										<fieldset class="form-group">
											<div class="row">
												<div class="col-lg-3">
													<label class="form-label">Categori</label>
													<select id="kategori"  name="kategori" required  class="select2">
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
												<div class="col-lg-3">
													<label class="form-label">Resource Document</label>
													<select id="option"  class="bootstrap-select">
													   <option value="0">-- Choose One --</option>       
													   <option value="opt1">Link Website</option>
													   <option value="opt2">Dokumen</option> 
													</select>
												</div>
												<div class="col-lg-6">
													<div id="data"></div>
												</div>
											</div>
										</fieldset>
										<fieldset class="form-group">
											<label class="form-label">Tags</label>
											<textarea id="tags-editor-textarea" name="tags"></textarea>
										</fieldset>
									</div>
								</div>
								<div style="text-align: right">
									<button type="submit" class="btn btn-rounded btn-primary" name="tambah_media" >Tambah Media</button>
								</div>
									
							</form>
						</div>
					</section>
				</div>
			</div>
	<?php }
	}else{
		?>
		<div class="page-content">
			<div class="container-fluid">
				<header class="section-header">
					<div class="row">
						<div class="col-md-10">
							<div class="tbl-cell">
								<h2>Media Ajar</h2>
								<div class="subtitle">Gudang Media </div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="tbl-cell" >
							<br>
								<a class="btn btn-primary" href="?action=tambah" style="text-align: right ">Media Baru</a>
							</div>
						</div>
					</div> 
				</header>
				<section class="card">
					<div class="card-block">
					<?php
						if ($getMedia == "null") {
							echo "Data Tidak Ada";
						}else{
					?>
						<table id="datatable" class="stripe row-border order-column display table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
							<tr>
								<th>No</th>
								<th>User</th>
								<th>Judul</th>
								<th>Deskripsi</th>
								<th>Kategori</th>
								<th>Aktif</th>
								<th>Status</th>
							</tr>
							</thead>
							<tbody>
							
								<?php 
									$no = 1;

									foreach ($getMedia as $data) {
										?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $data['nama_user']; ?></td>
											<td><?php echo $data['judul']; ?></td>
											<td><?php echo $data['deskripsi']; ?></td>
											<td><?php echo $data['kategori']; ?></td>
											<td><?php echo $data['active']; ?></td>
											<td>
											<a class="btn btn-inline btn-info" href="?action=edit&id=<?=base64_encode($data['_id']);?>" >Edit</a>
                                				- <a class="btn btn-inline btn-danger" href="?action=deleteMedia&id=<?=base64_encode($data['_id']);?>" >Hapus</a>
											 </td> 
										</tr>
										<?php
										$no++;
									} 
								?>	
							
							</tbody>
						</table>
					<?php
						}
					?>
					</div>
				</section>
			</div>
		</div>
		<?php
	}
	if (isset($_GET['action']) && isset($_GET['id'])) {
		$id = base64_decode($_GET['id']);
		$getMediaById = $classMedia->GetMediaBy($id);
		$getTagByMedia = $classTag->TagByMedia($id);
		if ($_GET['action'] == 'edit') {
		?>
		<div class="page-content">
				<div class="container-fluid">
					<header class="section-header">
						<div class="row">
							<div class="col-md-10">
								<div class="tbl-cell">
									<h2>Ubah Media Ajar</h2>
									<div class="subtitle">Gudang Media </div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="tbl-cell" >
								
							</div> 
						</div> 
					</header>
					<section class="card">
						<div class="card-block">
							<h5 class="with-border">Media Ajar</h5>
							<form  action="#" method="POST" role="form" enctype="multipart/form-data">
								<div class="row">
									<div class="col-lg-4">

										<div id="image-preview" style="background-image: url('../<?php echo $getMediaById['path_image'];?>')">
										  <label  for="image-upload" id="image-label">Choose File</label>
										  <input type="file" name="image" id="image-upload"   />
										</div>
									</div>
									<div class="col-lg-8">
										<fieldset class="form-group">
											<label class="form-label">Judul</label>
											<input type="text" class="form-control maxlength-simple"  name="judul" required value="<?php echo $getMediaById['judul'];?>" maxlength="15">
										</fieldset>
										<fieldset class="form-group">
											<label class="form-label">Deskripsi</label>
											<textarea rows="4" class="form-control maxlength-simple"  name="deskripsi" required  ><?php echo $getMediaById['deskripsi'];?></textarea>
										</fieldset>
										<fieldset class="form-group">
											<div class="row">
												<div class="col-lg-3">
													<label class="form-label">Categori</label>
													<select id="kategori"  name="kategori" required  class="select2">
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
												<?php
													if ($getMediaById['path_document'] != "") {
														?>
														<div class="col-lg-3">
															<label class="form-label">Resource Document</label>
															<select id="option"  class="bootstrap-select" disabled="disabled">
															   <option value="opt2">Dokumen</option> 
															</select>
														</div>
														<div class="col-lg-6">
															<div class="box" style="padding-top: 5%;"> 
																<input hidden="true" type="file"  name="dokumen" value="<?php echo $getMediaById['path_document'] ?>" id="file-7" class="inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple /> <label for="file-7"><span>Klik Bila File Dirubah</span> <strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> Choose a file&hellip;</strong></label>
															</div>
														</div>
														<?php
													}elseif ($getMediaById['tautan'] != "") {
														?>
														<div class="col-lg-3">
															<label class="form-label">Resource Document</label>
															<select id="option"  class="bootstrap-select" disabled="disabled">
															   <option value="opt1">Tautan</option> 
															</select>
														</div>
														<div class="col-lg-6">
															<div class="box" style=""> 
																<fieldset class="form-group"><label class="form-label">Tautan</label> <input type="text" value="<?php echo $getMediaById['tautan'] ?>" class="form-control maxlength-simple" id="tautan" name="tautan" placeholder="Tautan" > </fieldset>
															</div>
														</div>
														<?php
													}else{
													?>
													
													<div class="col-lg-3">
													<label class="form-label">Resource Document</label>
														<select id="option"  class="bootstrap-select">
														   <option value="0">-- Choose One --</option>       
														   <option value="opt1">Link Website</option>
														   <option value="opt2">Dokumen</option> 
														</select>
													</div>
													<div class="col-lg-6">
														<div id="data"></div>
													</div>
													<?php
													}
												?>
												
											</div>
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
									<button type="submit" class="btn btn-rounded btn-primary" name="edit_media" >Ubah Media</button>
								</div>
									
							</form>
						</div>
					</section>
				</div>
			</div>
		<?php
		}elseif ($_GET['action'] == 'deleteMedia') {
			$deleteMedia = $classMedia->Delete($id);
		}else{
			echo"<script>document.location.href='opsipenulis.php';</script>";
		}
	}else{
	
	}
	?>
<?php
	include 'footer.php';
?>