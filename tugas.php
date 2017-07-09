<?php
require("includes/header-top.php");
?>
<!-- Style for html code -->
<link rel="stylesheet" href="./assets/tinymce4/css/prism.css" type="text/css" />
<link rel="stylesheet" href="./assets/css/separate/pages/others.min.css">
<link rel="stylesheet" href="./assets/css/lib/daterangepicker/daterangepicker.css">

<script type="text/javascript" src="./assets/tinymce4/js/tinymce/tinymce.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

<?php
require("includes/header-menu.php");

$mapelClass 	= new Mapel();
$modulClass 	= new Modul();
$tugasClass 	= new Tugas();

$menuModul		= 3;
$infoModul		= $modulClass->getInfoModul($_GET['modul']);
$infoMapel		= $mapelClass->getInfoMapel($infoModul['id_mapel']);
$infoTugas		= $tugasClass->getInfoTugas($_GET['modul']);
$listTugas		= $tugasClass->getListTugas($_GET['modul']);

if(isset($_POST['addTugas']) || isset($_POST['updateTugas'])){


	if(isset($_POST['addTugas'])){
		$rest 	= $tugasClass->addTugas($_GET['modul'], $_POST['nama'], $_POST['deskripsi'], $_POST['deadline'], $_SESSION['lms_id']);
	}else{
		$rest 	= $tugasClass->updateTugas($_POST['ID'], $_POST['nama'], $_POST['deskripsi'], $_POST['deadline']);
	}

	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['status']."'); document.location='tugas.php?modul=".$_GET['modul']."'</script>";
	}else{
		echo "<script>alert('Gagal Update')</script>";
	}
}
?>

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
												<p class="title">Tugas <?=$infoModul['nama']?></p>
												<p>Mata Pelajaran <?=$infoMapel['nama']?></p>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<p class="title"><?=$listTugas->count();?></p>
													<p>Tugas</p>
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
					<section class="card card-default" id="tugas-editor" style="display: none;">
						<div class="card-block">
                            <h5 class="with-border" id="judul-editor">Pembuatan Tugas</h5>

                            <form id="form_tambah" method="POST">
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label">Judul</label>
                                    <div class="col-md-8">
										<input type="text" class="form-control" id="nama" name="nama" placeholder="Judul Tugas" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label">Tenggat Waktu Pengumpulan</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="deadline" name="deadline" placeholder="Tengat Waktu Tugas" required/>
                                        <input type="hidden" class="form-control" id="IDTugas" name="ID" placeholder="ID Tugas" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label">Isi Tugas</label>
                                    <div class="col-md-9">
                                        <div id="editorContainer">
                                            <div id="toolbarLocation"></div>
                                            <textarea id="editormce" class="form-control wrs_div_box" contenteditable="true" tabindex="0" spellcheck="false" aria-label="Rich Text Editor, example"></textarea>
                                            <input id="editor" type="text" name="deskripsi" style="display: none;" />
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group pull-right">
                                    <button type="submit" id="btn-submit" name="addTugas" class="btn">Simpan</button>
                                    <button type="button" class="btn btn-default" id="btn-cancel">Batal</button>
                                </div>
                            </form>
                        </div>
					</section>

					<section id="tugas-preview" class="card card-inversed">
						<header class="card-header">
							Daftar Tugas

							<?php
								if($infoModul['creator'] == $_SESSION['lms_id']){
									echo '<div class="btn-group" style="float: right;">
										<button id="btn-tambah" title="Tambah" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menambahkan tugas baru." class="btn btn-sm btn-rounded">+ Tambah Tugas</button>
									</div>';
								}
							?>
						</header>

						<div class="card-block" id="accordion">
							<?php
								$no	= 1;
								if ($listTugas->count() > 0) {
									foreach ($listTugas as $tugas) {
										if ($_SESSION['lms_id'] == $tugas['creator']) {
										echo '<article class="box-typical profile-post panel">
												<div class="profile-post-header">
													<div class="user-card-row">
														<div class="tbl-row">
															<div class="tbl-cell tbl-cell-photo">
																<a href="#demo'.$no.'" data-toggle="collapse" data-parent="#accordion">
																	<img src="assets/img/assignment.png" alt="">
																</a>
															</div>
															<div class="tbl-cell">
																<div class="user-card-row-name"><a href="#demo'.$no.'" data-toggle="collapse" data-parent="#accordion">'.$tugas['nama'].'</a></div>
																<div class="color-blue-grey-lighter">'.($tugas['date_created'] == $tugas['date_modified'] ? "" : "Diperbarui ").selisih_waktu($tugas['date_modified']).'</div>
															</div>
															<div class="tbl-cell" align="right">
																<a onclick="edit(\''.$tugas['_id'].'\')" class="shared" id="btn-edit" title="Edit" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk memperbarui Tugas yang sudah dibuat." style="right: 35px">
																	<i class="font-icon font-icon-pencil")"></i>
																</a>
																<a onclick="remove(\''.$tugas['_id'].'\')"   class="shared" title="Hapus" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menghapus Tugas yang sudah dibuat.">
																	<i class="font-icon font-icon-trash")"></i>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div id="demo'.$no.'" class="collapse">
													<div class="profile-post-content">
														<span><b><i class="fa fa-clock-o"></i> Tenggat Waktu</b> &nbsp; : <u>'.date("d F Y", strtotime($tugas["deadline"])).'</u></span>
														<hr style="margin: 10px 0;">
														'.$tugas["deskripsi"].'
													</div>
													<div class="box-typical-footer">
														<div class="tbl">
															<div class="tbl-row">
																<div class="tbl-cell tbl-cell-action">
																	<a href="tugas-action.php?act=kerjakan&modul='.$_GET['modul'].'&tugas='.$tugas['_id'].'" class="btn btn-rounded btn-primary pull-right">Kerjakan</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</article>';
										} else {
											echo '<article class="box-typical profile-post panel">
													<div class="profile-post-header">
														<div class="user-card-row">
															<div class="tbl-row">
																<div class="tbl-cell tbl-cell-photo">
																	<a href="#demo'.$no.'" data-toggle="collapse" data-parent="#accordion">
																		<img src="assets/img/assignment.png" alt="">
																	</a>
																</div>
																<div class="tbl-cell">
																	<div class="user-card-row-name"><a href="#demo'.$no.'" data-toggle="collapse" data-parent="#accordion">'.$tugas['nama'].'</a></div>
																	<div class="color-blue-grey-lighter">'.($tugas['date_created'] == $tugas['date_modified'] ? "Diterbitkan " : "Diperbarui ").selisih_waktu($tugas['date_modified']).'</div>
																</div>
															</div>
														</div>
													</div>
													<div id="demo'.$no.'" class="collapse">
														<div class="profile-post-content">
															<span><b><i class="fa fa-clock-o"></i> Tenggat Waktu</b> &nbsp; : <u>'.date("d F Y", strtotime($tugas["deadline"])).'</u></span>
															<hr style="margin: 10px 0;">
															'.$tugas["deskripsi"].'
														</div>
														<div class="box-typical-footer">
															<div class="tbl">
																<div class="tbl-row">
																	<div class="tbl-cell tbl-cell-action">
																		<a href="tugas-action.php?act=kerjakan&modul='.$_GET['modul'].'&tugas='.$tugas['_id'].'" class="btn btn-rounded btn-primary pull-right">Kerjakan</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</article>';
										}
										$no++;
									}
								}else {
									echo '	<article class="box-typical profile-post">
												<div class="add-customers-screen tbl">
													<div class="add-customers-screen-in">
														<div class="add-customers-screen-user">
															<i class="fa fa-file-text-o"></i>
														</div>
														<h2>Tugas Kosong</h2>
														<p class="lead color-blue-grey-lighter">Belum ada tugas yang tersedia</p>
													</div>
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

	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/lib/daterangepicker/daterangepicker.js"></script>

	<script>
		$("#form_tambah").submit(function(e){
			$("#editor").val(tinyMCE.get('editormce').getContent());
		});

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
      				url: 'url-API/Kelas/Modul/Tugas/',
      				data: {"action": "remv", "ID": ID},
      				success: function(res) {
						swal({
				            title: res.response,
				            text: res.message,
				            type: res.icon
				        }, function() {
				            location.reload();
				        });
      				},
      				error: function () {
      					swal("Gagal!", "Data tidak terhapus!", "error");
      				}
      			});
      		});
      	}

		function edit(ID){
      		$('#judul-editor').text(
      		   $('#judul-editor').text().replace('Pembuatan', 'Perubahan')
      		).show();
      		$.ajax({
      			type: 'POST',
      			url: 'url-API/Kelas/Modul/Tugas/',
      			data: {"action": "show", "ID": ID},
      			success: function(res) {
  					$('#IDTugas').val(ID);
  					$('#deadline').val(res.data.deadline);
  					$('#nama').val(res.data.nama);
					tinyMCE.activeEditor.setContent(res.data.deskripsi);
  					$('#btn-submit').attr('name', 'updateTugas');
      			},
      			error: function () {
      				swal("Error!", "Cannot fetch data!", "error");
      			}
      		});
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

		// Destroy action.
		$('#btn-cancel').on('click', function () {
			$('#tugas-preview').show();
			$('#tugas-editor').hide();
			$('#form_tambah').trigger("reset");
			$('#btn-submit').attr('name', 'addTugas');
		});

		// Initialize action.
		$('#btn-tambah, #btn-edit').on('click', function () {
			$('#form_tambah').trigger("reset");
			$('#tugas-preview').hide();
			$('#tugas-editor').show();
		});

		$(document).ready(function() {

			$('.note-statusbar').hide();

			$(".fancybox").fancybox({
				padding: 0,
				openEffect	: 'none',
				closeEffect	: 'none'
			});

			$('input[name="deadline"]').daterangepicker({
				autoUpdateInput: true,
				singleDatePicker: true,
				showDropdowns: true,
				autoApply: true,
				startDate: "2000-01-01",
				minDate: "<?=date('Y-m-d')?>",
				maxDate: "<?=date('Y')+10;?>-12-31",
				locale: {
					format: 'YYYY-MM-DD'
				}
			});
		});
	</script>

	<script src="assets/js/app.js"></script>
	<script type="text/javascript" src="./assets/tinymce4/js/wirislib.js"></script>
	<script type="text/javascript" src="./assets/tinymce4/js/prism.js"></script>

<?php
	require('includes/footer-bottom.php');
?>
