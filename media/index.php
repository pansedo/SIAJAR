<?php
	include "include/header.php";
	include 'include/menu.php';
	$classKategori = new Kategori();
	$classMedia = new Media();
	$classPopular = new Popular(); 


	$getkategoriutama = $classKategori->GetKategoriUtama();
	$getMedia = $classMedia->GetMedia();
	$getMediaPagging = $classMedia->GetMediaPagging();
	$getMediaTerbanyak = $classPopular->MediaTerbanyak();
	$getTagTerbanyak = $classPopular->TagTerbanyak();
	$CountData = $classMedia->GetCountData();
	
	
?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-lg-4">
						<aside class="profile-side">
						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Dokumen Terbanyak
							</header>
							<br>
							<div class="friends-list">
								<article class="friends-list-item">
									<?php 

										foreach ($getMediaTerbanyak as $orang) {
											?>
											<div class="user-card-row">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-photo">
														<a href="#">
															<img  src="Assets/foto/<?php if ($orang['foto_user'] != NULL) {echo $orang['foto_user'];}else{echo "no_picture.png";} ?>" alt="">
														</a>
													</div>
													<div class="tbl-cell">
														<p class="user-card-row-name status-online"><a href="#"><?php echo $orang['nama_user'];?></a></p>
														<p class="user-card-row-location"><?php echo $orang['sekolah_user'];?></p>
													</div>
												</div>
											</div>
											<?php
										}
									?>
									
								</article>
								
							</div>
						</section>
						<section class="box-typical">
							<header class="box-typical-header-sm bordered">Tag Terbanyak</header>
							<div class="box-typical-inner">
								<p>
									</p><ul style="list-style-type: circle;margin-left: 20px;">
									<?php 
										foreach ($getTagTerbanyak as $tags) {
											if (is_array($tags)) { 
												foreach ($tags as $tag) {
													echo "<a href='searchtag.php?tag=".$tag['_id']."' class='btn btn-inline btn-primary btn-sm ladda-button'>".$tag['_id']."</a>";
												}
											}
										}
									?>
									</ul>
								<p></p>
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">Total Dokumen</header>
							<div class="box-typical-inner">
								<center style="padding:15px 0px 0px 0px;">
									<h4 class="font">
										<div id="totdokumen"><?php echo $CountData['dokumen']; ?></div>
									</h4>
								</center>
							</div>
						</section>
						</aside>
						</div>
				<div class="col-xl-9 col-lg-8">
					
					
					<?php
					$no = 1;
					if ($getMedia == 0) {
						# code...
						echo "Belum ada dokumen";
					}else{
						
						foreach ($getMediaPagging as $data) {
						$date = date_create($data['date_created']);
					?>
						<div class="col-lg-4 col-lg-pull-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
						<!-- <div class="card-grid-col"> -->
							<article class="card-typical">
								<div class="card-typical-section" style="height:80px">
									<div class="user-card-row">
										<div class="tbl-row">
											<div class="tbl-cell tbl-cell-photo">
												<a href="#">
													<img  src="Assets/foto/<?php if ($data['foto'] != NULL) {echo $data['foto'];}else{echo "no_picture.png";} ?>" alt="">
												</a>
											</div>
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="product.php?id=<?php echo base64_encode($data['_id']);?>"><?php echo $data['judul']; ?></a></p>
												<p class="color-blue-grey-lighter"><?php echo selisih_waktu(date_format($date,'d-m-Y H:i:s'));?></p>
											</div>
											<div class="tbl-cell tbl-cell-status">
												<a href="#" class="font-icon font-icon-star active"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="card-typical-section card-typical-content">
									<!-- <div class="photo" style="min-width: 200px; height:300px; background-image:url('<?php// echo $data['path_image']; ?>'; position: center center"> -->
									 <div class="photo" > 
										<a href="product.php?id=<?php echo base64_encode($data['_id']);?>"><img style="  min-width: 200px; height:350px; background:<?php echo $data['path_image']; ?>" src="<?php echo $data['path_image']; ?>"  alt=""></a>
									</div>
									<header class="title"><a href="#"></a></header>
									<p><?php //echo substr($data['deskripsi'], 0, 30)."..."; ?></p>
								</div>
								<div class="card-typical-section">
									<div class="card-typical-linked" style="height:33px">oleh <a href="profile.php?id=<?=$data['id_user']?>"><?php echo $data['nama_user']; ?></a></div>
									<!-- <a href="#" class="card-typical-likes">
										<i class="font-icon font-icon-heart"></i>
										123
									</a> -->
								</div>
							</article><!--.card-typical-->
						<!-- </div> -->
						</div>
						<?php
							}
						}
						?>
						<!-- Selesai Buku Content -->
						
						<div class="col-lg-12" align="center">
							<?php
								$classMedia->pagging(isset($_GET['page']) ? $_GET['page'] : 1);
							?>
						</div>
					</div>
					
				</div>
			</div><!--.row-->
		</div>
	</div>

<?php
	include "include/footer.php";
?>