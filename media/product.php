<?php
	include "include/header.php";
	include 'include/menu.php';

	$classMedia = new Media();
	$classTag = new Tag();
	$classProfile = new Profile();
	$classKategori = new Kategori();
	if (isset($_GET['id'])) {
		# code...
		$id 			= base64_decode($_GET['id']);
		$getMediaById 	= $classMedia->GetMediaBy($id);
		$getTagByMedia 	= $classTag->TagByMedia($id);
		$getUserById 	= $classProfile->GetData($getMediaById['id_user']);
		$getKategori 	= $classKategori->getkategoriutamabyId($getMediaById['id_kategori']);

	
?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3">
					<section class="box-typical">
						<div class="profile-card">
							<div class="profile-card-photo">
								<img src="Assets/foto/<?php if ($getUserById['foto'] != NULL) {echo $getUserById['foto'];}else{echo "no_picture.png";} ?>" alt=""/>
							</div>
							<div class="profile-card-name"><?php echo $getUserById['nama'];?></div>
							<div class="profile-card-location"><?php echo $getUserById['sekolah'];?></div>
							<button style="margin-top:10px;" type="button" class="btn btn-rounded">Follow</button>
							<button style="margin-top:10px;" type="button" class="btn btn-danger btn-rounded">Wishlist</button>
						</div>
						<section class="proj-page-section proj-page-labels">
							<header class="proj-page-subtitle padding-sm">
								<h3>Tag</h3>
							</header>
							<?php
								foreach ($getTagByMedia as $datatag) {
									echo "<a href='' class='label label-light-grey'>".$datatag['nama']."</a>";
								}
							?>
							<!-- <a href="#" class="label label-light-grey">Buku</a>
							<a href="#" class="label label-light-grey">Indonesia</a>
							<a href="#" class="label label-light-grey">Hehehe</a> -->
						</section><!--.proj-page-section-->
						<section class="proj-page-section">
							<row>
								<div class="col-lg-6">
									<button type="button" class="btn btn-warning btn-rounded">Report</button>
								</div>
							</row>
							<br>
						</section><!--.proj-page-section-->
					</section>

				</div>
				<div class="col-lg-9">
					<section class="box-typical proj-page">
						<div align="center">
						<img src="<?php echo $getMediaById['path_image'];?>" style="width:300px; height:400px;">
						</div>
						<section class="proj-page-section proj-page-header">
							<div class="tbl proj-page-team">
								<div class="tbl-row">
									<div class="tbl-cell">
										<div class="title">
											<h2><?php echo $getMediaById['judul'];?></h2>
										</div>
									</div>
									<div class="tbl-cell tbl-cell-date">
									<!-- Rating :  -->
									</div>
								</div>
							</div>
						</section><!--.proj-page-section-->

						<section class="proj-page-section">
							<div class="tbl proj-page-team">
								<div class="tbl-row">
									<div class="tbl-cell">
										<div class="project">Kategori:
										<?php
											foreach ($getKategori as $dataKategori) {
											echo "<a href='#'>".$dataKategori['kategori']."</a>";
										}?>
										</div>
									</div>
									<!-- <div class="tbl-cell tbl-cell-date">3 days ago - 23 min read</div> -->
								</div>
							</div>
						</section><!--.proj-page-section-->

						<section class="proj-page-section">
							<div class="proj-page-txt">
								<p><?php echo $getMediaById['deskripsi'];?></p>
							</div>
						</section>

						<section class="proj-page-section">
						<?php
							$date = date_create($getMediaById['date_created']);
							if ($getMediaById['path_document'] != "") {
								# code...
							
						?>
							<header class="proj-page-subtitle">
								<h3>Attachments</h3>
							</header>
							<div class="proj-page-attach">
							<?php
								$dataExt = explode(".", $getMediaById['path_document']);
								$ext = (count($dataExt) - 1);
								// echo $dataExt[$ext];
								$ekstensi = strtolower($dataExt[$ext]);
								$format = array("jpg", "jpeg", "png", "gif", "bmp", "pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx", "mp4", "3gp", "flv", "avi", "mp3", "ogg");
								$video = array("mp4", "3gp", "flv", "avi");
								$musik = array("mp3", "ogg");
								$gambar = array("jpg", "jpeg", "png", "gif", "bmp");
								if ($ekstensi == "pdf") {
									echo "<i class='font-icon fa fa-file-pdf-o'></i>";
								}else if ($ekstensi == "doc" || $ekstensi == "docx") {
									# code...
									echo "<i class='font-icon fa fa-file-word-o'></i>";
								}else if (in_array($ekstensi, $gambar)) {
									# code...
									echo "<i class='font-icon fa fa-file-picture-o'></i>";
								}else if (in_array($ekstensi, $musik)) {
									# code...
									echo "<i class='font-icon fa fa-file-audio-o'></i>";
								}else if ($ekstensi == "xls" || $ekstensi == "xlsx") {
									# code...
									echo "<i class='font-icon fa fa-file-excel-o'></i>";
								}else if ($ekstensi == "ppt" || $ekstensi == "pptx") {
									# code...
									echo "<i class='font-icon fa fa-file-powerpoint-o'></i>";
								}else if (in_array($ekstensi, $video)) {
									# code...
									echo "<i class='font-icon fa fa-file-movie-o'></i>";
								}else{
									echo "<i class='font-icon fa fa-file'></i>";
									
								}

								
							?>
								
								
								<p class="name"><?php echo $getMediaById['judul'];?>.<?php echo $ekstensi;?></p>
								<p class="date"><?php echo date_format($date,'d-m-Y H:i:s');?></p>
								<p>
									<!-- <a href="#">View</a> -->
									<a href="<?php echo $getMediaById['path_document'];?>">Download</a>
								</p>
							</div>
					<?php
						}
						if($getMediaById['tautan'] != ""){
					?>
						<header class="proj-page-subtitle">
								<h3>Link</h3>
							</header>
							<div class="proj-page-attach">
							
								<i class='font-icon fa fa-link'></i>								
								<p class="name"><?php echo $getMediaById['judul'];?></p>
								<p class="date"><?php echo date_format($date,'d-m-Y H:i:s');?></p>
								<p>
									<a href="http://<?php echo $getMediaById['tautan'];?>" target="_blank">View</a>
								</p>
							</div>
					<?php
						}	
					?>

						</section><!--.proj-page-attach-section-->

					</section>
				</div>
			</div>
		</div>
	</div>

<?php
}
	include "include/footer.php";
?>