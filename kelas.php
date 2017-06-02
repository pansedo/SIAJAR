<?php
// error_reporting(E_ALL);
require("includes/header-top.php");
require("includes/header-menu.php");


$kelasClass = new Kelas();
$mapelClass = new Mapel();

$infoKelas	= $kelasClass->getInfoKelas($_GET['id']);

// var_dump($infoKelas);
$listMapel	= $mapelClass->getListbyKelas($_GET['id']);


if(isset($_POST['addKelas'])){
	$nama = mysql_escape_string($_POST['namakelas']);
	$rest = $kelasClass->addKelas($nama, $_SESSION['lms_id']);
	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['message']."'); document.location='kelas.php?id=".$rest['IDKelas']."'</script>";
	}
}

if(isset($_POST['addMapel'])){
	$nama	= mysql_escape_string($_POST['namamapel']);
	$kelas	= mysql_escape_string($_GET['id']);
	$rest 	= $mapelClass->addMapel($nama, $kelas, $_SESSION['lms_id']);
	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['message']."'); document.location='mapel.php?id=".$rest['IDMapel']."'</script>";
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

if(isset($_POST['postingText'])){
	$post = trim(htmlentities($_POST['textPost']));
	$rest = $kelasClass->addPost($post, $infoKelas['_id'], $_SESSION['lms_id']);
	// echo "<script>alert('WOE!');</script>";
	if ($rest['status'] == "Success") {
		// echo "<script>alert('".$rest['status']."');</script>";
		// echo "<script>document.location='kelas.php?id=".$infoKelas['_id']."'</script>";
	}else{
		echo "<script>alert('".$rest['status']."');</script>";
	}
}
?>

	<div class="modal fade"
		 id="addMapel"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="addMapelLabel"
		 aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="POST">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="addMapelLabel">Tambah Mata Pelajaran Baru</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="namakelas" class="col-md-3 form-control-label">Nama Mata Pelajaran</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="namamapel" id="namamapel" placeholder="Nama Mata Pelajaran" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="addMapel" value="send" class="btn btn-rounded btn-primary">Simpan</button>
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
								<div class="col-md-12">
									<div class="tbl info-tbl">
										<div class="tbl-row">
											<div class="tbl-cell">
												<p class="title"><?=$infoKelas['nama']?></p>
												<p>Kelas</p>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<p class="title"><?=$infoKelas['member']?></p>
													<p>Anggota</p>
												</div>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<p class="title"><?=$listMapel->count();?></p>
													<p>Mata Pelajaran</p>
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
				<i class="font-icon font-icon-pencil"></i>
				Pengaturan Kelas
			</button>
		</div><!--.profile-header-photo-->

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-lg-4">
					<aside id="menu-fixed2" class="profile-side" style="margin: 0 0 20px">
						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Kode Kelas
								<div class="btn-group" style='float: right;'>
									<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Aksi
									</button>
									<div class="dropdown-menu" style="margin-left: -100px">
		                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-lock"></span>Kunci Kelas</a>
									</div>
								</div>
							</header>
							<div class="box-typical-inner">
								<p style="font-size: 2em; text-decoration: underline; font-weight:bold; text-align: center;"><?=$infoKelas['kode']?></p>
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">Tentang Kelas</header>
							<div class="box-typical-inner">
								<p><?=$infoKelas['tentang']?></p>
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Daftar Mata Pelajaran
								<div class="btn-group" style='float: right;'>
									<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Aksi
									</button>
									<div class="dropdown-menu" style="margin-left: -100px">
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#addMapel"><span class="font-icon font-icon-plus"></span>Tambah Mata Pelajaran</a>
		                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-pencil"></span>Kelola Mata Pelajaran</a>
									</div>
								</div>
							</header>
							<div class="box-typical-inner" id="listMapel">
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
							<form class="box-typical" method="post" action="">
								<textarea class="write-something" name="textPost" placeholder="Apa yang ingin anda beritahukan?"></textarea>
								<div class="box-typical-footer">
									<div class="tbl">
										<div class="tbl-row">
											<div class="tbl-cell">
												<button type="button" class="btn-icon" title="lampiran tautan">
													<i class="font-icon font-icon-earth"></i>
												</button>
												<button type="button" class="btn-icon" title="lampiran gambar">
													<i class="font-icon font-icon-picture"></i>
												</button>
												<button type="button" class="btn-icon">
													<i class="font-icon font-icon-calend"></i>
												</button>
												<button type="button" class="btn-icon">
													<i class="font-icon font-icon-video-fill"></i>
												</button>
											</div>
											<div class="tbl-cell tbl-cell-action">
												<button type="submit" name="postingText" class="btn btn-rounded">Send</button>
											</div>
										</div>
									</div>
								</div>
							</form><!--.box-typical-->

							<?php
								$listPosting	= $kelasClass->postingKelas($_GET['id']);

								if ($listPosting['count'] > 0) {
									// echo "<pre>";
									// print_r($listPosting['data']);
									// echo "</pre>";
									foreach ($listPosting['data'] as $posting) {
										echo '	<article class="box-typical profile-post">
													<div class="profile-post-header">
														<div class="user-card-row">
															<div class="tbl-row">
																<div class="tbl-cell tbl-cell-photo">
																	<a href="#">
																		<img src="assets/img/photo-64-2.jpg" alt="">
																	</a>
																</div>
																<div class="tbl-cell">
																	<div class="user-card-row-name"><a href="#">'.$posting['user'].'</a></div>
																	<div class="color-blue-grey-lighter">'.selisih_waktu($posting['date_created']).'</div>
																</div>
															</div>
														</div>
													';
										if ($_SESSION['lms_id'] == $posting['creator']) {
										echo '		<a class="shared" onclick="remove(\''.$posting['_id'].'\')" title="Hapus" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Menghapus Kiriman yang sudah dibuat.">
														<i class="font-icon font-icon-trash"></i>
													</a>';
										}
										echo '		</div>
													<div class="profile-post-content">
														<p>
															'.nl2br($posting['isi_postingan']).'
														</p>
													</div>
												</article>';
									}
								}else {
									echo '	<article class="box-typical profile-post">
												<div class="profile-post-content">
													<p align="center">
													 Belum ada Postingan saat ini.
													</p>
												</div>
											</article>';
								}

							?>
							<!-- <article class="box-typical profile-post">
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
							</article> -->

						</div><!--.tab-content-->
					</section><!--.tabs-section-->
				</div>
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	require('includes/footer-top.php');
?>
<script src="assets/js/lib/autoresize/autoresize-textarea.js"></script>

	<script>
		function clearText(elementID){
			$(elementID).html("");
		}

		$(function(){
	      $('textarea').autoResize();
	    });

		function remove(ID){
      		swal({
      		  title: "Apakah anda yakin?",
      		  text: "Data yang sudah dihapus tidak dapat dikembalikan!",
      		  type: "warning",
      		  showCancelButton: true,
			  	confirmButtonText: "Setuju!",
      			confirmButtonClass: "btn-danger",
      		  closeOnConfirm: false,
      		  showLoaderOnConfirm: true
      		}, function () {
      			$.ajax({
      				type: 'POST',
      				url: 'url-API/Kelas/Posting/',
      				data: {"act": "remv", "ID": ID},
      				success: function(res) {
      					swal(res.response, res.message, res.icon);
      				},
      				error: function () {
      					swal("Gagal!", "Data tidak terhapus!", "error");
      				}
      			});
      		});
      	}

		$(document).ready(function() {

			$.ajax({
				type: 'POST',
				url: 'url-API/Kelas/Mapel/',
				data: {"action": "showList", "ID": "<?=$_GET['id']?>"},
				success: function(res) {
					$('#listMapel').html('');
					if(res.data.length > 0){
						for(i=0; i<=res.data.length; i++){
							$('#listMapel').append('<p class="line-with-icon">'+
									'<i class="font-icon font-icon-folder"></i>'+
									'<a href="mapel.php?id='+res.data[i]._id.$id+'">'+res.data[i].nama+'</a>'+
								'</p>');
						}
					}else{
						$('#listMapel').append('<p style="text-align:center;">'+
									'Belum ada Mata Pelajaran'+
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

		});
	</script>
<script src="assets/js/app.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
