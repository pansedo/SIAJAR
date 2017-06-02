<?php
require("includes/header-top.php");
?>
<link rel="stylesheet" href="assets/css/separate/pages/others.min.css">
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
$materiClass 	= new Materi();

$menuModul		= 2;
$infoModul		= $modulClass->getInfoModul($_GET['modul']);
$infoMapel		= $mapelClass->getInfoMapel($infoModul['id_mapel']);
$infoMateri		= $materiClass->getInfoMateri($_GET['modul']);

if(isset($_POST['addMateri']) || isset($_POST['updateMateri'])){


	if(isset($_POST['addMateri'])){
		$rest 	= $materiClass->addMateri($_GET['modul'], $_POST['judul'], $_POST['isi'], $_SESSION['lms_id']);
	}else{
		$rest 	= $materiClass->updateMateri($_GET['modul'], $_POST['judul'], $_POST['isi']);
	}

	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['status']."'); document.location='materi.php?modul=".$_GET['modul']."'</script>";
	}else{
		echo "<script>alert('Gagal Update')</script>";
	}
}
?>

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
												<p class="title">Modul <?=$infoModul['nama']?></p>
												<p>Mata Pelajaran <?=$infoMapel['nama']?></p>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<p class="title"><?=$infoMateri->count();?></p>
													<p>Materi</p>
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
					<section class="card card-inversed">
						<header class="card-header">
							Kumpulan Materi
							<div class="btn-group" style='float: right;'>
								<a href="" class="btn btn-sm btn-rounded">+ Tambah Materi</a>
							</div>
						</header>
						<div class="card-block" id="accordion">
				<?php
					$no	= 1;
					if ($infoMateri->count() > 0) {
						foreach ($infoMateri as $materi) {
							echo '<article class="box-typical profile-post panel">
									<div class="profile-post-header">
										<div class="user-card-row">
											<div class="tbl-row">
												<div class="tbl-cell tbl-cell-photo">
													<a href="#demo'.$no.'" data-toggle="collapse" data-parent="#accordion">
														<img src="assets/img/folder.png" alt="">
													</a>
												</div>
												<div class="tbl-cell">
													<div class="user-card-row-name"><a href="#demo'.$no.'" data-toggle="collapse" data-parent="#accordion">'.$materi['judul'].'</a></div>
													<div class="color-blue-grey-lighter">'.($materi['date_created'] == $materi['date_modified'] ? "Diterbitkan " : "Diperbarui ").selisih_waktu($materi['date_modified']).'</div>
												</div>
												<div class="tbl-cell" align="right">';
												if ($_SESSION['lms_id'] == $materi['creator']) {
													echo '<a href="?act=update&md='.$infoModul['_id'].'&ma='.$materi['_id'].'" class="shared" title="Edit" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Memperbarui isi dari Materi yang sudah dibuat." style="right: 35px">
															<i class="font-icon font-icon-pencil")"></i>
														</a>
														<a onclick="remove(\''.$materi['_id'].'\')"   class="shared" title="Hapus" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Menghapus Materi yang sudah dibuat.">
															<i class="font-icon font-icon-trash")"></i>
														</a>';
												}
							echo '				</div>
											</div>
										</div>
									</div>
									<div id="demo'.$no.'" class="profile-post-content collapse">
										'.$materi['file'].'
									</div>
								</article>
							';
							$no++;
						}
					}else {
						echo '	<article class="box-typical profile-post">
									<div class="profile-post-content" align="center">
										<span>
										 Belum ada Materi saat ini.
										</span>
									</div>
								</article>';
					}
				?>
						</div>
					</section>
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

	<script>

		function clearText(elementID){
			$(elementID).html("");
		}

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

		function createEditorInstance(lang, wiriseditorparameters) {
			var toolbar = ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent',
		                    'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'wirisEditor', 'wirisChemistry', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print'];
			$('#editor').froalaEditor({
		        // Add the custom buttons in the toolbarButtons list, after the separator.
		        iframe: true,
				theme: 'gray',
		        //       toolbarInline: true,
		        charCounterCount: false,
		        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageRemove'],
		        toolbarButtons: toolbar,
		        toolbarButtonsMD: toolbar,
		        toolbarButtonsSM: toolbar,
		        toolbarButtonsXS: toolbar,
				toolbarSticky: false,
		        htmlAllowedTags:   ['.*'],
		        htmlAllowedAttrs: ['.*'],
				linkAutoPrefix: 'https://localhost/siajar/',
		        language: lang,
		        imageResize : false,
		        key: 'lrqpD6E-11cyeI-7A11lE-13B-13==',
		        imageUploadURL: 'url-API/Editor/upload.php',
		        fileUploadURL: 'url-API/Editor/upload.php',
		        videoUploadURL: 'url-API/Editor/upload.php'
		    }).on('froalaEditor.image.removed', function (e, editor, $img) {

				var imageDeleted = String($img.attr("src")).split("/").pop();

		        $.ajax({
		            // Request method.
		            method: "POST",

		            // Request URL.
		            url: "url-API/Editor/delete.php",

		            // Request params.
		            data: {
		                file: imageDeleted
		            }
		        })
		        .done (function (data) {
		            console.log ('image was deleted '+data);
		        })
		        .fail (function () {
		            console.log ('image delete problem');
		        })
		    }).on('froalaEditor.file.unlink', function (e, editor, link) {

				var fileDeleted = String(link).split("/").pop();

		        $.ajax({
		            // Request method.
		            method: "POST",

		            // Request URL.
		            url: "url-API/Editor/delete.php",

		            // Request params.
		            data: {
		                file: fileDeleted
		            }
		        })
		        .done (function (data) {
		            console.log ('file was deleted '+data);
		        })
		    }).on('froalaEditor.video.removed', function (e, editor, $video) {

		        var videoDeletedURL = $video.context.lastChild.src;

		        $.ajax({
		            // Request method.
		            method: "POST",

		            // Request URL.
		            url: "url-API/Editor/delete.php",

		            // Request params.
		            data: {
		                file: videoDeletedURL.split("/").pop()
		            }
		        })
		        .done (function (data) {
		            console.log ('video was deleted '+data);
		        })
		    });
		}

		// Destroy action.
		$('#btn-cancel').on('click', function () {

			if ($('#editor').data('froala.editor')) {
				$('#editor').froalaEditor('destroy');
				$('#materi-preview').show();
				$('#materi-editor').hide();
			}
		});

		// Initialize action.
		$('#btn-tambah, #btn-edit').on('click', function () {

			if (!$('#editor').data('froala.editor')) {
				createEditorInstance('en', {});
				$('#editor').froalaEditor('html.set', $('#preview').html());
				$('#materi-preview').hide();
				$('#materi-editor').show();
			}
		});

		$(document).ready(function() {
			$('.note-statusbar').hide();
		});
	</script>

	<script src="assets/js/app.js"></script>

<?php
	require('includes/footer-bottom.php');
?>
