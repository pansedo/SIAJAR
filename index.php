<?php
require("includes/header-top.php");
require("includes/header-menu.php");

$kelasClass = new Kelas();

if(isset($_POST['addKelas'])){
	$nama = mysql_escape_string($_POST['namakelas']);
	$rest = $kelasClass->addKelas($nama, $_SESSION['lms_id']);
	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['message']."'); document.location='kelas.php?id=".$rest['IDKelas']."'</script>";
	}
}

if(isset($_POST['joinKelas'])){
	$kode = mysql_escape_string($_POST['kodekelas']);
	$rest = $kelasClass->joinKelas($kode, $_SESSION['lms_id']);
	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['message']."'); document.location='kelas.php?id=".$rest['IDKelas']."'</script>";
	}else{
		echo "<script>alert('".$rest['message']."');</script>";
	}
}
?>
	<div class="modal fade"
		 id="addKelas"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="addKelasLabel"
		 aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="POST">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="addKelasLabel">Tambah Kelas Baru</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="namakelas" class="col-md-3 form-control-label">Nama Kelas</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="namakelas" id="namakelas" placeholder="Nama Kelas baru" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="addKelas" value="send" class="btn btn-rounded btn-primary">Simpan</button>
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Tutup</button>
				</div>
				</form>
			</div>
		</div>
	</div><!--.modal-->

	<div class="modal fade bd-example-modal-sm"
		 id="joinKelas"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="joinKelasLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form method="POST">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="joinKelasLabel">Bergabung Kelas</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-md-12">
							<input type="text" class="form-control" name="kodekelas" id="kodekelas" placeholder="Kode Kelas" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="joinKelas" value="send" class="btn btn-rounded btn-primary">Bergabung</button>
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Tutup</button>
				</div>
				</form>
			</div>
		</div>
	</div><!--.modal-->



	<div class="page-content">
		<div class="profile-header-photo">
			<div class="profile-header-photo-in">
				<div class="tbl-cell">
					<div class="info-block">
						<div class="container-fluid">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<div class="tbl info-tbl">
										<div class="tbl-row">
											<div class="tbl-cell">
												<p class="title"><?=$_SESSION['lms_name']?></p>
												<p><?=ucfirst($_SESSION['lms_status'])?></p>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<p class="title">15</p>
													<p>Tugas</p>
												</div>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<p class="title">8</p>
													<p>Sudah</p>
												</div>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<p class="title">7</p>
													<p>Belum</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<button type="button" class="change-cover">
				<i class="font-icon font-icon-picture-double"></i>
				Ganti sampul
				<input type="file"/>
			</button>
		</div><!--.profile-header-photo-->

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-lg-4">
					<aside id="menu-fixed2" class="profile-side">
						<section class="box-typical profile-side-user">
							<button type="button" class="avatar-preview avatar-preview-128">
								<img src="assets/img/avatar-1-256.png" alt=""/>
							</button>
							<button type="button" id="ohyeah" class="btn btn-rounded">Kirim Pesan</button>

						</section>
						<?php
						if(strtolower($_SESSION['lms_status']) == 'siswa'){
						echo '
							<section class="box-typical profile-side-stat">
								<div class="tbl">
									<div class="tbl-row">
										<div class="tbl-cell">
											<span class="number">3</span>
											kelas yang diikuti
										</div>
									</div>
								</div>
							</section>';
						}elseif (strtolower($_SESSION['lms_status']) == 'guru') {
							echo '<section class="box-typical profile-side-stat">
								<div class="tbl">
									<div class="tbl-row">
										<div class="tbl-cell">
											<span class="number">11</span>
											berkas
										</div>
										<div class="tbl-cell">
											<span class="number">20</span>
											dokumen
										</div>
									</div>
								</div>
							</section>';
						}
						?>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">Tentang Saya</header>
							<div class="box-typical-inner">
								<p>
									<ul style="list-style-type: circle;margin-left: 20px;">
										<li>Simple</li>
										<li>Pekerja Keras</li>
										<li>Periang</li>
										<li>Rajin Olahraga</li>
									</ul>
								</p>
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">Info</header>
							<div class="box-typical-inner">
								<p class="line-with-icon">
									<i class="font-icon font-icon-pin-2"></i>
									Kota Bandung
								</p>
								<p class="line-with-icon">
									<i class="font-icon font-icon-users-two"></i>
									<a href="#">SMAN 22 Bandung</a>
								</p>
								<p class="line-with-icon">
									<i class="font-icon font-icon-user"></i>
									<?=ucfirst($_SESSION['lms_status'])?>
								</p>
								<p class="line-with-icon">
									<i class="font-icon font-icon-facebook"></i>
									<a href="#">Profil Facebook</a>
								</p>
								<p class="line-with-icon">
									<i class="font-icon font-icon-earth"></i>
									<a href="#">Website</a>
								</p>
								<p class="line-with-icon">
									<i class="font-icon font-icon-calend"></i>
									Bergabung 2 hari yang lalu
								</p>
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Daftar Kelas
								<div class="btn-group" style='float: right;'>
									<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Aksi
									</button>
									<div class="dropdown-menu" style="margin-left: -100px">
										<?php
										if (strtolower($_SESSION['lms_status']) == 'guru') {
											echo '
												<a class="dropdown-item" href="#" data-toggle="modal" data-target="#addKelas"><span class="font-icon font-icon-plus"></span>Tambah Kelas</a>
				                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-pencil"></span>Kelola Kelas</a>';
										}
										?>
		                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#joinKelas"><span class="font-icon font-icon-user"></span>Gabung Kelas</a>
									</div>
								</div>
							</header>
							<div class="box-typical-inner" id="listKelas">
								<p style="text-align: center;">
									Menunggu..
								</p>
							</div>
						</section>

					</aside><!--.profile-side-->
				</div>

				<div class="col-xl-9 col-lg-8">
					<section class="tabs-section">

						<div class="tab-content no-styled profile-tabs">

							<article class="box-typical profile-post">
								<div class="profile-post-header">
									<div class="user-card-row">
										<div class="tbl-row">
											<div class="tbl-cell tbl-cell-photo">
												<a href="#">
													<img src="assets/img/photo-64-2.jpg" alt="">
												</a>
											</div>
											<div class="tbl-cell">
												<div class="user-card-row-name"><a href="#">Pansera Guru</a> &nbsp; &gt; &nbsp; <a href="#">Contoh Kelas 1</a></div>
												<div class="color-blue-grey-lighter">3 hari lalu</div>
											</div>
										</div>
									</div>
									<a href="#" class="shared">
										<i class="font-icon font-icon-share"></i>
									</a>
								</div>
								<div class="profile-post-content">
									<p>
										Pengumuman<br />
										<br />
										Besok kelas di liburkan, kepada seluruh Tutor harap memberitahu siswa/i yang berada di masing-masing TKB.<br />
										<br />
										Terima Kasih
									</p>
								</div>
								<div class="box-typical-footer profile-post-meta">
									<a class="meta-item">
										<i class="font-icon font-icon-comment"></i>
										8 Comment
									</a>
								</div>
								<div id="post1" style="display:none;">
									<div class="comment-rows-container hover-action scrollable-block">
										<div class="comment-row-item">
											<div class="avatar-preview avatar-preview-32">
												<a href="#">
													<img src="assets/img/photo-64-2.jpg" alt="">
												</a>
											</div>
											<div class="tbl comment-row-item-header">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-name">Eric Fox</div>
													<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
												</div>
											</div>
											<div class="comment-row-item-content">
												<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
												<button type="button" class="comment-row-item-action edit">
													<i class="font-icon font-icon-pencil"></i>
												</button>
												<button type="button" class="comment-row-item-action del">
													<i class="font-icon font-icon-trash"></i>
												</button>
											</div>
										</div><!--.comment-row-item-->

										<div class="comment-row-item">
											<div class="avatar-preview avatar-preview-32">
												<a href="#">
													<img src="assets/img/avatar-2-64.png" alt="">
												</a>
											</div>
											<div class="tbl comment-row-item-header">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-name">Vasilisa</div>
													<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
												</div>
											</div>
											<div class="comment-row-item-content">
												<p>Yes!</p>
												<button type="button" class="comment-row-item-action edit">
													<i class="font-icon font-icon-pencil"></i>
												</button>
												<button type="button" class="comment-row-item-action del">
													<i class="font-icon font-icon-trash"></i>
												</button>
											</div>
										</div><!--.comment-row-item-->

										<div class="comment-row-item">
											<div class="avatar-preview avatar-preview-32">
												<a href="#">
													<img src="assets/img/photo-64-2.jpg" alt="">
												</a>
											</div>
											<div class="tbl comment-row-item-header">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-name">Henry Olson</div>
													<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
												</div>
											</div>
											<div class="comment-row-item-content">
												<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
												<button type="button" class="comment-row-item-action edit">
													<i class="font-icon font-icon-pencil"></i>
												</button>
												<button type="button" class="comment-row-item-action del">
													<i class="font-icon font-icon-trash"></i>
												</button>
											</div>
										</div><!--.comment-row-item-->

										<div class="comment-row-item">
											<div class="avatar-preview avatar-preview-32">
												<a href="#">
													<img src="assets/img/avatar-2-64.png" alt="">
												</a>
											</div>
											<div class="tbl comment-row-item-header">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-name">Vasilisa</div>
													<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
												</div>
											</div>
											<div class="comment-row-item-content">
												<p>No!</p>
												<button type="button" class="comment-row-item-action edit">
													<i class="font-icon font-icon-pencil"></i>
												</button>
												<button type="button" class="comment-row-item-action del">
													<i class="font-icon font-icon-trash"></i>
												</button>
											</div>
										</div><!--.comment-row-item-->

										<div class="comment-row-item">
											<div class="avatar-preview avatar-preview-32">
												<a href="#">
													<img src="assets/img/avatar-2-64.png" alt="">
												</a>
											</div>
											<div class="tbl comment-row-item-header">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-name">Vasilisa</div>
													<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
												</div>
											</div>
											<div class="comment-row-item-content">
												<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed...</p>
												<button type="button" class="comment-row-item-action edit">
													<i class="font-icon font-icon-pencil"></i>
												</button>
												<button type="button" class="comment-row-item-action del">
													<i class="font-icon font-icon-trash"></i>
												</button>
											</div>
										</div><!--.comment-row-item-->
									</div><!--.comment-rows-container-->
									<input type="text" class="write-something" placeholder="Leave a comment"/>
									<div class="box-typical-footer">
										<div class="tbl">
											<div class="tbl-row">
												<div class="tbl-cell"></div>
												<div class="tbl-cell tbl-cell-action">
													<button type="submit" class="btn btn-rounded">Send</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</article>

						</div><!--.tab-content-->
					</section><!--.tabs-section-->
				</div>
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	require('includes/footer-top.php');
?>

	<script>
		$(document).ready(function() {
			$.ajax({
				type: 'POST',
				url: 'url-API/Kelas/',
				data: {"action": "showList", "ID": "<?=$_SESSION['lms_id']?>"},
				success: function(res) {
					$('#listKelas').html('');
					if(res.data.length > 0){
						for(i=0; i<=res.data.length; i++){
							$('#listKelas').append('<p class="line-with-icon">'+
									'<i class="font-icon font-icon-folder"></i>'+
									'<a href="kelas.php?id='+res.data[i]._id.$id+'">'+res.data[i].nama+'</a>'+
								'</p>');
						}
					}else{
						$('#listKelas').append('<p style="text-align:center;">'+
									'Belum ada Kelas'+
								'</p>');
					}
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					// console.log('ERROR !');
					 alert(textStatus);
				}
			});

			$(".fancybox").fancybox({
				padding: 0,
				openEffect	: 'none',
				closeEffect	: 'none'
			});

			$("#range-slider-1").ionRangeSlider({
				min: 0,
				max: 100,
				from: 30,
				hide_min_max: true,
				hide_from_to: true
			});

			$("#range-slider-2").ionRangeSlider({
				min: 0,
				max: 100,
				from: 30,
				hide_min_max: true,
				hide_from_to: true
			});

			$("#range-slider-3").ionRangeSlider({
				min: 0,
				max: 100,
				from: 30,
				hide_min_max: true,
				hide_from_to: true
			});

			$("#range-slider-4").ionRangeSlider({
				min: 0,
				max: 100,
				from: 30,
				hide_min_max: true,
				hide_from_to: true
			});

		});
	</script>
	<script>
		// $("#ohyeah").click(function(){
			// $.ajax({
  				// type: 'POST',
  				// url: 'url-API/Siswa/index.php',
  				// data: {"action": "update", "text": "tôi"},
  				// success: function(res) {
	  				// alert(res.text1);
	  				// alert(res.text2);
	  				// alert(res.text3);
  				// },
  				// error: function () {

  				// }
  			// });
		// })
	</script>
<script src="assets/js/app.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
