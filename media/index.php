<?php
	include "include/header.php";
	include 'include/menu.php';
	$classKategori = new Kategori();
	$classMedia = new Media();



	$getkategoriutama = $classKategori->GetKategoriUtama();
	$getMedia = $classMedia->GetMedia();
	$getMediaPagging = $classMedia->GetMediaPagging();


?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-lg-4">
						<aside class="profile-side">
						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Terbaru
							</header>
							<div class="friends-list">
								<article class="friends-list-item">

									<div class="user-card-row">
										<div class="tbl-row">
											<div class="tbl-cell tbl-cell-photo">
												<a href="#">
													<img  src="Assets/img/photo-64-2.jpg" alt="">
												</a>
											</div>
											<div class="tbl-cell">
												<p class="user-card-row-name status-online"><a href="#">Dan Cederholm</a></p>
												<p class="user-card-row-location">New York</p>
											</div>
										</div>
									</div>
									<div class="user-card-row">
										<div class="tbl-row">
											<div class="tbl-cell tbl-cell-photo">
												<a href="#">
													<img  src="Assets/img/photo-64-2.jpg" alt="">
												</a>
											</div>
											<div class="tbl-cell">
												<p class="user-card-row-name status-online"><a href="#">Dan Cederholm</a></p>
												<p class="user-card-row-location">New York</p>
											</div>
										</div>
									</div>
								</article>
								
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">Tentang Saya</header>
							<div class="box-typical-inner">
								<p>
									</p><ul style="list-style-type: circle;margin-left: 20px;">
										<li>Simple</li>
										<li>Pekerja Keras</li>
										<li>Periang</li>
										<li>Rajin Olahraga</li>
									</ul>
								<p></p>
							</div>
						</section>
						</aside>
						</div>
					


					
				<div class="col-xl-9 col-lg-8">
					<div class="cards-grid " data-columns>
					
					<?php
						$no = 1;

						foreach ($getMediaPagging as $data) {
					?>
						
						<div class="card-grid-col">
							<article class="card-typical">
								<div class="card-typical-section">
									<div class="user-card-row">
										<div class="tbl-row">
											<div class="tbl-cell tbl-cell-photo">
												<a href="#">
													<img  src="Assets/foto/<?php if ($data['foto'] != NULL) {echo $data['foto'];}else{echo "no_picture.png";} ?>" alt="">
												</a>
											</div>
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="#"><?php echo $data['judul']; ?></a></p>
												<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
											</div>
											<div class="tbl-cell tbl-cell-status">
												<a href="#" class="font-icon font-icon-star active"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="card-typical-section card-typical-content">
									<!-- <div class="photo" style="min-width: 200px; height:300px; background-image:url('<?php echo $data['path_image']; ?>'; position: center center"> -->
									 <div class="photo" > 
										<img style="  min-width: 200px; height:300px; background:<?php echo $data['path_image']; ?>" src="<?php echo $data['path_image']; ?>"  alt="">
									</div>
									<header class="title"><a href="#"></a></header>
									<p><?php echo substr($data['deskripsi'], 0, 30)."..."; ?></p>
								</div>
								<div class="card-typical-section">
									<div class="card-typical-linked">oleh <a href="#"><?php echo $data['nama_user']; ?></a></div>
									<!-- <a href="#" class="card-typical-likes">
										<i class="font-icon font-icon-heart"></i>
										123
									</a> -->
								</div>
							</article><!--.card-typical-->
						</div>
						<?php
							}
							

						?>
						<!-- Selesai Buku Content -->
						</div>
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