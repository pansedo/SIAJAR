<?php
require("includes/header-top.php");
?>
<link rel="stylesheet" href="assets/editor/css/plugins/code_view.css">
<link rel="stylesheet" href="assets/editor/css/plugins/draggable.css">
<link rel="stylesheet" href="assets/editor/css/plugins/colors.css">
<link rel="stylesheet" href="assets/editor/css/plugins/emoticons.css">
<link rel="stylesheet" href="assets/editor/css/plugins/image_manager.css">
<link rel="stylesheet" href="assets/editor/css/plugins/image.css">
<link rel="stylesheet" href="assets/editor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="assets/editor/css/plugins/table.css">
<link rel="stylesheet" href="assets/editor/css/plugins/char_counter.css">
<link rel="stylesheet" href="assets/editor/css/plugins/video.css">
<link rel="stylesheet" href="assets/editor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="assets/editor/css/plugins/file.css">
<link rel="stylesheet" href="assets/editor/css/plugins/quick_insert.css">
<link rel="stylesheet" href="assets/editor/css/plugins/help.css">
<link rel="stylesheet" href="assets/editor/css/plugins/special_characters.css">
<link type="text/css" rel="stylesheet" href="assets/editor/css/froala_style.css"/>
<link type="text/css" rel="stylesheet" href="assets/editor/css/froala_editor.pkgd.min.css"/>
<link type="text/css" rel="stylesheet" href="assets/editor/css/themes/gray.css"/>

<?php
require("includes/header-menu.php");

$mapelClass 	= new Mapel();
$modulClass 	= new Modul();
$materiClass	= new Materi();

$menuModul	= 2;
$infoModul	= $modulClass->getInfoModul($_GET['id']);
$infoMapel	= $mapelClass->getInfoMapel($_GET['pelajaran']);

if(isset($_POST['terbitkanMateri'])){
	$rest = $modulClass->submitMateri($_GET['id'], $_POST['isi']);
	echo "<script>alert('Gagal Update $rest')</script>";
	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['status']."'); document.location='materi.php?id=".$_GET['id']."&pelajaran=".$_GET['pelajaran']."'</script>";
	}else{
		echo "<script>alert('Gagal Update')</script>";
	}
}

if(isset($_GET['materi'])){
	$infoMateri	= $materiClass->getInfoMateri($_GET['materi']);
	$isiMateri	= $infoMateri['file'];
}else{
	$isiMateri	= "";
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
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="addKelasLabel">Tambah Kelas Baru</h4>
				</div>
				<div class="modal-body">
					<form method="POST" onSubmit="return false">
						<div class="form-group row">
							<label for="namakelas" class="col-md-3 form-control-label">Nama Kelas</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="namakelas" placeholder="Nama Kelas baru" />
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-primary">Simpan</button>
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Tutup</button>
				</div>
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
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="joinKelasLabel">Bergabung Kelas</h4>
				</div>
				<div class="modal-body">
					<form method="POST" onSubmit="return false">
						<div class="form-group row">
							<div class="col-md-12">
								<input type="text" class="form-control" name="kodekelas" id="kodekelas" placeholder="Kode Kelas" />
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-primary">Bergabung</button>
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div><!--.modal-->

	<div class="modal fade"
		 id="addModulPrasyarat"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="addModulLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<form method="POST">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="addModulLabel">Silakan Pilih Modul</h4>
				</div>
				<div class="modal-body">
					<div class="files-manager-content-in" style="margin-right:0px; border-right: 0px;">
						<div class="fm-file-grid">
							<div class="fm-file" style="height: 150px;">
								<div class="checkbox-bird">
									<input type="checkbox" id="mess-1" />
									<label for="mess-1">
										<div class="fm-file-icon">
											<img src="assets/img/folder.png" alt="">
										</div>
										<div class="fm-file-name">Inspiration</div>
									</label>
								</div>
							</div>
							<div class="fm-file" style="height: 150px;">
								<div class="checkbox-bird">
									<input type="checkbox" id="mess-2" />
									<label for="mess-2">
										<div class="fm-file-icon">
											<img src="assets/img/folder.png" alt="">
										</div>
										<div class="fm-file-name">Inspiration</div>
									</label>
								</div>
							</div>
						</div>
					</div><!--.files-manager-content-in-->
				</div>
				<div class="modal-footer">
					<button type="submit" name="addModul" value="send" class="btn btn-rounded btn-primary">Simpan</button>
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
												<p class="title"><?=$infoMapel['nama']?></p>
												<p>Mata Pelajaran</p>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<p class="title"><?=$infoMapel['modul']?></p>
													<p>Modul</p>
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
					<?php
						require("includes/modul-menu.php");
					?>
				</div>

				<div class="col-xl-9 col-lg-8">
					<section class="tabs-section">
						<div class="tab-content no-styled profile-tabs">
							<div role="tabpanel" class="tab-pane active" id="tabs-2-tab-1">

								<article class="box-typical profile-post">
									<form id="form_modul" method="POST" action="">
										<div class="profile-post-header" style="border-bottom: solid 1px rgba(216, 226, 231, 0);">
											<div class="user-card-row">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-photo">
														<a href="#">
															<img src="assets/img/folder.png" alt="">
														</a>
													</div>
													<div class="tbl-cell">
														<div class="user-card-row-name"><a href="#">Materi</a></div>
														<div class="color-blue-grey-lighter">3 days ago - 23 min read</div>
													</div>
												</div>
											</div>
											<a href="#" class="shared">
												<i class="font-icon font-icon-pencil"></i>
											</a>
										</div>

										<textarea id="editor" name="isi">
											<?=$isiMateri?>
										</textarea>

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
														<button type="submit" name="terbitkanMateri" class="btn btn-rounded">Terbitkan</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</article>

							</div><!--.tab-pane-->
						</div><!--.tab-content-->
					</section><!--.tabs-section-->
				</div>
			</div><!--.row-->

		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	require('includes/footer-top.php');
?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

	<script type="text/javascript" src="assets/editor/js/froala_editor.pkgd.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/froala_wiris/integration/WIRISplugins.js?viewer=image"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/froala_wiris/wiris.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/align.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/char_counter.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/code_beautifier.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/code_view.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/colors.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/draggable.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/emoticons.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/entities.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/file.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/font_size.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/font_family.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/fullscreen.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/image.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/image_manager.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/line_breaker.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/inline_style.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/link.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/lists.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/paragraph_format.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/paragraph_style.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/quick_insert.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/quote.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/table.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/save.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/url.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/video.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/help.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/print.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/special_characters.min.js"></script>
	<script type="text/javascript" src="assets/editor/js/plugins/word_paste.min.js"></script>
	<script src="assets/editor/init.js"></script>

	<script>

		function clearText(elementID){
			$(elementID).html("");
		}

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

		$(document).ready(function() {


			$('.note-statusbar').hide();

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

	<script src="assets/js/app.js"></script>

<?php
	require('includes/footer-bottom.php');
?>
