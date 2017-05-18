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
				<form method="POST" >
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
					<button type="button" name="joinKelas" value="send" class="btn btn-rounded btn-primary">Bergabung</button>
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Tutup</button>
				</div>
				</form>
			</div>
		</div>
	</div><!--.modal-->

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
				<i class="font-icon font-icon-picture-double"></i>
				Ganti sampul
				<input type="file" />
			</button>
		</div><!--.profile-header-photo-->

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-lg-4">
					<aside id="menu-fixed" class="profile-side" style="margin: 0 0 20px">
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
							<div class="box-typical-inner">
							<?php
							foreach($listMapel as $data){
								echo	'<p class="line-with-icon">
											<i class="font-icon font-icon-folder"></i>
											<a href="mapel.php?id='.$data["_id"].'">'.$data["nama"].'</a>
										</p>';
							}
							?>
							</div>
						</section>

					</aside><!--.profile-side-->
				</div>

				<div class="col-xl-9 col-lg-8">
					<section class="tabs-section">

						<div class="tab-content no-styled profile-tabs">
							<form class="box-typical">
								<textarea type="text" class="write-something" placeholder="Apa yang ingin anda beritahukan?"></textarea>
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
												<button type="submit" class="btn btn-rounded">Send</button>
											</div>
										</div>
									</div>
								</div>
							</form><!--.box-typical-->

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
												<div class="user-card-row-name"><a href="#">Tim Collins</a></div>
												<div class="color-blue-grey-lighter">3 days ago - 23 min read</div>
											</div>
										</div>
									</div>
									<a href="#" class="shared">
										<i class="font-icon font-icon-share"></i>
									</a>
								</div>
								<div class="profile-post-content">
									<p class="profile-post-content-note">Subminted a new post</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="box-typical-footer profile-post-meta">
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-heart"></i>
										45 Like
									</a>
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-comment"></i>
										18 Comment
									</a>
								</div>
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
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy...</p>
											<button type="button" class="comment-row-item-action edit">
												<i class="font-icon font-icon-pencil"></i>
											</button>
											<button type="button" class="comment-row-item-action del">
												<i class="font-icon font-icon-trash"></i>
											</button>
											<div class="comment-row-item quote">
												<div class="avatar-preview avatar-preview-32">
													<a href="#">
														<img src="assets/img/photo-64-2.jpg" alt="">
													</a>
												</div>
												<div class="tbl comment-row-item-header">
													<div class="tbl-row">
														<div class="tbl-cell tbl-cell-name">Adam Oliver</div>
														<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
													</div>
												</div>
												<div class="comment-row-item-content">
													<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet...</p>
												</div>
											</div><!--.comment-row-item-->
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

									<div class="comment-row-item">
										<div class="avatar-preview avatar-preview-32">
											<a href="#">
												<img src="assets/img/photo-64-2.jpg" alt="">
											</a>
										</div>
										<div class="tbl comment-row-item-header">
											<div class="tbl-row">
												<div class="tbl-cell tbl-cell-name">Roger Dunn</div>
												<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
											</div>
										</div>
										<div class="comment-row-item-content">
											<p>Lorem ipsum dolor sit amet</p>
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
												<div class="tbl-cell tbl-cell-name">Lorem ipsum dolor sit amet</div>
												<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
											</div>
										</div>
										<div class="comment-row-item-content">
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
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
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</p>
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
												<div class="tbl-cell tbl-cell-name">Eric Fox</div>
												<div class="tbl-cell tbl-cell-date">04.07.15, 20:02 PM</div>
											</div>
										</div>
										<div class="comment-row-item-content">
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</p>
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
											<div class="tbl-cell">
												<button type="button" class="btn-icon">
													<i class="font-icon font-icon-earth"></i>
												</button>
												<button type="button" class="btn-icon">
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
												<button type="submit" class="btn btn-rounded">Send</button>
											</div>
										</div>
									</div>
								</div>
							</article>

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
												<div class="user-card-row-name"><a href="#">Tim Collins</a></div>
												<div class="color-blue-grey-lighter">3 days ago - 23 min read</div>
											</div>
										</div>
									</div>
									<a href="#" class="shared">
										<i class="font-icon font-icon-share"></i>
									</a>
								</div>
								<div class="profile-post-content">
									<p class="profile-post-content-note">Added 4 new pictures</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<div class="profile-post-gall-fluid profile-post-gall-grid" data-columns>
										<div class="col">
											<a class="fancybox" rel="gall-1" href="assets/img/gall-img-1.jpg">
												<img src="assets/img/gall-img-1.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-1" href="assets/img/gall-img-2.jpg">
												<img src="assets/img/gall-img-2.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-1" href="assets/img/gall-img-3.jpg">
												<img src="assets/img/gall-img-3.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-1" href="assets/img/gall-img-4.jpg">
												<img src="assets/img/gall-img-4.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-1" href="assets/img/gall-img-5.jpg">
												<img src="assets/img/gall-img-5.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-1" href="assets/img/gall-img-6.jpg">
												<img src="assets/img/gall-img-6.jpg" alt="">
											</a>
										</div>
									</div>
								</div>
								<div class="box-typical-footer profile-post-meta">
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-heart"></i>
										45 Like
									</a>
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-comment"></i>
										18 Comment
									</a>
								</div>
							</article>

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
												<div class="user-card-row-name"><a href="#">Tim Collins</a></div>
												<div class="color-blue-grey-lighter">3 days ago - 23 min read</div>
											</div>
										</div>
									</div>
									<a href="#" class="shared">
										<i class="font-icon font-icon-share"></i>
									</a>
								</div>
								<div class="profile-post-content">
									<p class="profile-post-content-note">Added a new video</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<div class="cstm-video-player" style="background-image: url('assets/img/player-photo-b.jpg');">
										<div class="cstm-video-player-hover">
											<i class="font-icon font-icon-play"></i>
										</div>
										<div class="cstm-video-player-controls">
											<div class="cstm-video-player-progress">
												<div class="downloaded" style="width:75%"></div>
												<div class="played" style="width:35%"></div>
											</div>
											<div class="cstm-video-player-controls-left">
												<button type="button" class="cstm-video-player-btn">
													<i class="font-icon font-icon-play"></i>
												</button>
												<button type="button" class="cstm-video-player-btn">
													<i class="font-icon font-icon-player-next"></i>
												</button>
												<button type="button" class="cstm-video-player-btn">
													<i class="font-icon font-icon-player-sound"></i>
												</button>
											</div>
											<div class="cstm-video-player-controls-right">
												<button type="button" class="cstm-video-player-btn">
													<i class="font-icon font-icon-player-subtitres"></i>
												</button>
												<button type="button" class="cstm-video-player-btn">
													<i class="font-icon font-icon-player-settings"></i>
												</button>
												<button type="button" class="cstm-video-player-btn">
													<i class="font-icon font-icon-player-wide-screen"></i>
												</button>
												<button type="button" class="cstm-video-player-btn">
													<i class="font-icon font-icon-player-full-screen"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="box-typical-footer profile-post-meta">
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-heart"></i>
										45 Like
									</a>
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-comment"></i>
										18 Comment
									</a>
								</div>
							</article>

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
												<div class="user-card-row-name"><a href="#">Tim Collins</a></div>
												<div class="color-blue-grey-lighter">3 days ago - 23 min read</div>
											</div>
										</div>
									</div>
									<a href="#" class="shared">
										<i class="font-icon font-icon-share"></i>
									</a>
								</div>
								<div class="profile-post-content">
									<p class="profile-post-content-note">Is listening to the Evernote</p>
									<div class="minimalistic-player">
										<div class="tbl minimalistic-player-header">
											<div class="tbl-row">
												<div class="tbl-cell tbl-cell-action">
													<button type="button">
														<i class="font-icon font-icon-play-square"></i>
													</button>
												</div>
												<div class="tbl-cell tbl-cell-action">
													<button type="button">
														<i class="font-icon font-icon-play-prev-square"></i>
													</button>
												</div>
												<div class="tbl-cell tbl-cell-action">
													<button type="button">
														<i class="font-icon font-icon-play-next-square"></i>
													</button>
												</div>
												<div class="tbl-cell tbl-cell-caption">Kylie Minogue  – Slow 2015</div>
												<div class="tbl-cell tbl-cell-time">-04:01</div>
											</div>
										</div>
										<div class="progress">
											<div style="width: 25%"></div>
										</div>
										<div class="progress sound">
											<div style="width: 50%"><div class="handle"></div></div>
										</div>
									</div>
								</div>
								<div class="box-typical-footer profile-post-meta">
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-heart"></i>
										45 Like
									</a>
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-comment"></i>
										18 Comment
									</a>
								</div>
							</article>

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
												<div class="user-card-row-name"><a href="#">Tim Collins</a></div>
												<div class="color-blue-grey-lighter">3 days ago - 23 min read</div>
											</div>
										</div>
									</div>
									<a href="#" class="shared">
										<i class="font-icon font-icon-share"></i>
									</a>
								</div>
								<div class="profile-post-content">
									<p class="profile-post-content-note">Created an album collection</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<div class="profile-post-gall-fluid profile-post-gall-grid" data-columns>
										<div class="col">
											<a class="fancybox" rel="gall-2" href="assets/img/gall-img-1.jpg">
												<img src="assets/img/gall-img-1.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-2" href="assets/img/gall-img-2.jpg">
												<img src="assets/img/gall-img-2.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-2" href="assets/img/gall-img-3.jpg">
												<img src="assets/img/gall-img-3.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-2" href="assets/img/gall-img-4.jpg">
												<img src="assets/img/gall-img-4.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-2" href="assets/img/gall-img-5.jpg">
												<img src="assets/img/gall-img-5.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-2" href="assets/img/gall-img-6.jpg">
												<img src="assets/img/gall-img-6.jpg" alt="">
											</a>
										</div>
										<div class="col">
											<a class="fancybox" rel="gall-2" href="assets/img/gall-img-7.jpg">
												<img src="assets/img/gall-img-7.jpg" alt="">
											</a>
										</div>
									</div>
								</div>
								<div class="box-typical-footer profile-post-meta">
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-heart"></i>
										45 Like
									</a>
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-comment"></i>
										18 Comment
									</a>
								</div>
							</article>

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
												<div class="user-card-row-name"><a href="#">Tim Collins</a></div>
												<div class="color-blue-grey-lighter">3 days ago - 23 min read</div>
											</div>
										</div>
									</div>
									<a href="#" class="shared">
										<i class="font-icon font-icon-share"></i>
									</a>
								</div>
								<div class="profile-post-content">
									<p class="profile-post-content-note">Scheduled a meeting whith <a href="#">Elen Adarna</a></p>
									<div class="tbl profile-post-card">
										<div class="tbl-row">
											<div class="tbl-cell tbl-cell-photo">
												<a href="#">
													<img src="assets/img/100x100.jpg" alt="">
												</a>
											</div>
											<div class="tbl-cell">
												<p class="title"><a href="#">Telling Your Kife Story: Memoir Workshop Series</a></p>
												<p>Monday, July 06, 2015 – Thuesday, July 07, 2015</p>
												<p>SF Bay Theater</p>
												<p>San Francisco, California, USA</p>
											</div>
										</div>
									</div>
								</div>
								<div class="box-typical-footer profile-post-meta">
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-heart"></i>
										45 Like
									</a>
									<a href="#" class="meta-item">
										<i class="font-icon font-icon-comment"></i>
										18 Comment
									</a>
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
		function clearText(elementID){
			$(elementID).html("");
		}

		$(document).ready(function() {
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
		$("#ohyeah").click(function(){
			$.ajax({
  				type: 'POST',
  				url: 'url-API/Siswa/index.php',
  				data: {"action": "update", "text": "tôi"},
  				success: function(res) {
	  				alert(res.text1);
	  				alert(res.text2);
	  				alert(res.text3);
  				},
  				error: function () {

  				}
  			});
		})
	</script>
<script src="assets/js/app.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
