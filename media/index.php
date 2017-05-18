<?php
	include "include/header.php";
	include 'include/menu.php';
	$classKategori = new Kategori();
	$classMedia = new Media();



	$getkategoriutama = $classKategori->GetKategoriUtama();
	$getMedia = $classMedia->GetMedia();


?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="cards-grid " data-columns>
			<?php
				$no = 1;

				foreach ($getMedia as $data) {
			?>
				
				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="Assets/foto/<?php if ($data['foto'] != NULL) {echo $data['foto'];}else{echo "no_picture.png";} ?>" alt="">
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
							<div class="photo">
								<img src="<?php echo $data['path_image']; ?>" alt="">
							</div>
							<header class="title"><a href="#"></a></header>
							<p><?php echo substr($data['deskripsi'], 0, 100).". . ."; ?></p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">oleh <a href="#"><?php echo $data['nama_user']; ?></a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div>
				<?php
					}
				?>
				<!-- Selesai Buku Content -->
				</div>
				
				
			</div><!--.row-->
		</div>
	</div>

<?php
	include "include/footer.php";
?>