<?php
require("includes/header-top.php");
?>
<link rel="stylesheet" href="assets/css/separate/pages/files.min.css">
<link rel="stylesheet" href="assets/css/lib/summernote/summernote.css"/>
<link rel="stylesheet" href="assets/css/separate/pages/editor.min.css">
<style>
.note-editor .note-toolbar{
	border: 0px;
}

.note-editor.note-frame .note-editing-area {
	border: 0px;
}
</style>
<?php
require("includes/header-menu.php");

$mapelClass = new Mapel();
$modulClass = new Modul();

$infoMapel	= $mapelClass->getInfoMapel($_GET['pelajaran']);
$infoModul	= $modulClass->getInfoModul($_GET['id']);
$menuModul	= 3;
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
									<div class="profile-post-header" style="border-bottom: solid 1px rgba(216, 226, 231, 0);">
										<div class="user-card-row">
											<div class="tbl-row">
												<div class="tbl-cell tbl-cell-photo">
													<a href="#">
														<img src="assets/img/folder.png" alt="">
													</a>
												</div>
												<div class="tbl-cell">
													<div class="user-card-row-name"><a href="#">Tugas</a></div>
													<div class="color-blue-grey-lighter">3 days ago - 23 min read</div>
												</div>
											</div>
										</div>
										<a href="#" class="shared">
											<i class="font-icon font-icon-share"></i>
										</a>
									</div>
									<div class="summernote-theme-1">
										<textarea class="summernote" name="name">Hello Summernote</textarea>
									</div>
									<div>
										<div class="files-manager-content-in" style="margin-right:0px; border-right: 0px; border-top: solid 1px #d8e2e7;">
											<div class="fm-file-grid">
												<div class="fm-file">
													<div class="fm-file-icon">
														<img src="assets/img/file-pdf.png" alt="">
													</div>
													<div class="fm-file-name">Inspiration</div>
												</div>
												<div class="fm-file">
													<div class="fm-file-icon">
														<img src="assets/img/file-pdf.png" alt="">
													</div>
													<div class="fm-file-name">Inspiration</div>
												</div>
												<div class="fm-file">
													<div class="fm-file-icon">
														<img src="assets/img/file-pdf.png" alt="">
													</div>
													<div class="fm-file-name">Inspiration</div>
												</div>
												<div class="fm-file">
													<div class="fm-file-icon">
														<img src="assets/img/file-pdf.png" alt="">
													</div>
													<div class="fm-file-name">2014_projects.rar</div>
												</div>
												<div class="fm-file">
													<div class="fm-file-icon">
														<img src="assets/img/file-doc.png" alt="">
													</div>
													<div class="fm-file-name">Inspiration</div>
												</div>
												<div class="fm-file">
													<div class="fm-file-icon">
														<img src="assets/img/file-doc.png" alt="">
													</div>
													<div class="fm-file-name">Inspiration</div>
												</div>
												<div class="fm-file">
													<div class="fm-file-icon">
														<img src="assets/img/file-xls.png" alt="">
													</div>
													<div class="fm-file-name">Inspiration</div>
												</div>
												<div class="fm-file">
													<div class="fm-file-icon">
														<img src="assets/img/file-xls.png" alt="">
													</div>
													<div class="fm-file-name">Inspiration</div>
												</div>
											</div>
										</div><!--.files-manager-content-in-->
									</div>
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
													<button type="submit" class="btn btn-rounded">Terbitkan</button>
												</div>
											</div>
										</div>
									</div>
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
	<script src="assets/js/lib/summernote/summernote.min.js"></script>

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
			$('.summernote').summernote({
				height: 300,                 // set editor height
				minHeight: null,             // set minimum height of editor
				maxHeight: null,             // set maximum height of editor
				disableResizeEditor: true
			});

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

			$("#example-vertical").steps({
				headerTag: "h3",
				bodyTag: "section",
				transitionEffect: "slideLeft",
				stepsOrientation: "vertical"
			});

		});
	</script>

	<script src="assets/js/app.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
