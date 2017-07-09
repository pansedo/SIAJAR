<?php
require("includes/header-top.php");
require("includes/header-menu.php");

$mapelClass = new Mapel();
$modulClass = new Modul();
$quizClass  = new Quiz();

if(isset($_POST['addQuiz'])){
	$nama = mysql_escape_string($_POST['namakuis']);

	if (!empty($_POST['idmodul'])) {
		$rest = $quizClass->setModul($nama, $_GET['modul'], $_POST['idmodul']);
	}else{
		$rest = $quizClass->addQuiz($nama, $_GET['modul'], $_POST['durasi'],$_POST['mulai'],$_POST['selesai'], $_SESSION['lms_id']);
	}

	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['status']."'); document.location='quiz-action.php?act=update&md=".$_GET['modul']."&qz=".$materi['_id']."'</script>";
	}
}

$menuModul	= 4;
$infoModul	= $modulClass->getInfoModul($_GET['modul']);
$infoMapel	= $mapelClass->getInfoMapel($infoModul['id_mapel']);
$listQuiz	= $quizClass->getListbyModul($_GET['modul']);
?>
	<div class="modal fade"
		 id="updateMapel"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="updateMapelLabel"
		 aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="POST">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="updateMapelLabel">Pengaturan Mata Pelajaran</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="namaMapelupdate" class="col-md-3 form-control-label">Mata Pelajaran</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="namaMapelupdate" id="namaMapelupdate" placeholder="Nama Mata Pelajaran" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-danger pull-left" onclick="" name="hapusKelas"><i class="font-icon-trash"></i> Hapus Mata Pelajaran</button>
					<button type="submit" class="btn btn-rounded btn-primary" name="updateMapel" value="send" >Simpan</button>
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Tutup</button>
				</div>
				</form>
			</div>
		</div>
	</div><!--.modal-->

	<div class="modal fade"
		 id="addModul"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="addModulLabel"
		 aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="POST">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="addModulLabel">Tambah Kuis</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">

							<div class="form-group row">
								<label for="namamodul" class="col-md-3 form-control-label">Nama Kuis</label>
								<input type="hidden" name="idmodul" id="idmodul" class="" maxlength="11" />
								<div class="col-md-9">
									<input type="text" class="form-control" name="namakuis" id="namamodul" placeholder="Nama Kuis" title="Nama Kuis" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Silahkan isikan Nama Modul yang akan dibuat!" />
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label" name="durasi" for="exampleInput">Durasi</label>
								<div class="col-md-9">
										<input type="number" class="form-control" name="durasi" id="exampleInput" placeholder="0" maxlength="3">
										<small class="text-muted">Lama Pengerjaan dalam satuan menit.</small>
								</div>

							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label"  for="exampleInput">Tanggal Mulai</label>
								<div class="col-md-9">
								<input type="date" class="form-control" name="mulai" id="exampleInput" placeholder="dd/mm/yyyy">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label" for="exampleInput">Tanggal Selesai</label>
								<div class="col-md-9">
								<input type="date" class="form-control" name="selesai" id="exampleInput" placeholder="dd/mm/yyyy">
								</div>

							</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="addQuiz" value="send" class="btn btn-rounded btn-primary">Simpan</button>
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
												<p class="title">Ujian <?=$infoModul['nama']?></p>
												<p>Mata Pelajaran <?=$infoMapel['nama']?></p>
											</div>
											<div class="tbl-cell tbl-cell-stat">
												<div class="inline-block">
													<!-- <p class="title"><?//=$infoMapel['modul']?></p> -->
													<!-- <p>Quiz</p> -->
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
			<!-- <button type="button" class="change-cover" onclick="update()">
				<i class="font-icon font-icon-pencil"></i>
				Pengaturan Mata Pelajaran
			</button> -->
		</div><!--.profile-header-photo-->

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-lg-4">
					<?php
						require("includes/modul-menu.php");
					?>
				</div>

				<div class="col-xl-9 col-lg-8">
					<section class="widget widget-activity">
						<header class="widget-header">
							Ujian
							<span class="label label-pill label-primary"><?=$listQuiz->count();?></span>

						</header>
						<div>
						<div class="card-block" id="accordion">
							<?php
					$no	= 1;
					// print_r($listQuiz);
					if ($listQuiz->count() > 0) {
						foreach ($listQuiz as $materi) {
							$submittedQuiz = $quizClass->isSumbmitted((string)$_SESSION['lms_id'], (string)$materi['_id']);
							?>
								<article class="box-typical profile-post panel">
									<div class="profile-post-header">
										<div class="user-card-row">
											<div class="tbl-row">
												<div class="tbl-cell tbl-cell-photo">
													<a href="#demo<?=$no?>" data-toggle="collapse" data-parent="#accordion">
														<?php
															if($submittedQuiz){
														?>
															<img src="assets/img/quiz.png" alt="">
														<?php }else{ ?>
															<img src="assets/img/quiz-empty.png" alt="">
														<?php } ?>
													</a>
												</div>
												<div class="tbl-cell">
													<div class="user-card-row-name">
														<?php
															if($submittedQuiz){
														?>
															<a href="#" onclick="message()"><?=$materi['nama']?></a>
														<?php }else{ ?>
															<a href="quiz-start.php?id=<?=$materi['_id']?>"><?=$materi['nama']?></a>
														<?php } ?>
													</div>
													<div class="color-blue-grey-lighter"><?=($materi['date_created'] == $materi['date_modified'] ? "Diterbitkan " : "Diperbarui ").selisih_waktu($materi['date_modified'])?></div>
												</div>
												<div class="tbl-cell" align="right">
												<?php if ($_SESSION['lms_id'] == $materi['creator']) {?>
														<a href="quiz-action.php?act=update&md=<?=$infoModul['_id']?>&qz=<?=$materi['_id']?>" class="shared" title="Edit" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk memperbarui isi dari Ujian yang sudah dibuat." style="right: 35px">
															<i class="font-icon font-icon-pencil"></i>
														</a>
														<a onclick="remove(<?=$materi['_id']?>)"   class="shared" title="Hapus" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menghapus Materi yang sudah dibuat.">
															<i class="font-icon font-icon-trash"></i>
														</a>
												<?php } ?>
											</div>
											</div>
										</div>
									</div>
									<div id="demo<?=$no?>" class="profile-post-content collapse">
										<?php
											if($submittedQuiz){
												$nilaiQuiz      = $quizClass->hitungNilaiQuiz($_SESSION['lms_id'], (string)$materi['_id']);
										?>
										Nilai Ujian :<?=$nilaiQuiz?> <br />
										<?php }else{ ?>
										Durasi :<?=$materi["durasi"]?> menit<br />
										Tanggal Berakhir :<?=$materi["end_date"]?> <br />
										<?php } ?>
									</div>
								</article>
							<?php
							$no++;
						}
					}else {
						?>
								<article class="box-typical profile-post">
									<div class="profile-post-content" align="center">
										<span>
										 Belum ada Kuis saat ini. <br />
										<button type="button" class="btn btn-sm btn-inline" onclick="add()" title="Tambah" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menambahkan Quiz baru.">+ Buat Baru</button>
										</span>
									</div>
								</article>
				<?php
					}
				?>
							</div>
						</div>
					</section><!--.widget-tasks-->
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

		function add(){
      		$('#addModul').trigger("reset");
      		$('#addModul').modal('show');
			$('#addModulLabel').text(
      		   $('#addModulLabel').text().replace('Edit Modul', 'Tambah Modul')
      		).show();
      	};

		function update(){
      		$('#updateMapel').trigger("reset");
      		$('#updateMapel').modal("show");
      		$('#updateMapelLabel').text(
      		   $('#updateMapelLabel').text().replace('Tambah Modul', 'Pengaturan Mata Pelajaran')
      		).show();
			$('#namaMapelupdate').val("<?=$infoMapel['nama']?>");
      	}

		function edit(ID){
      		$('#addModul').trigger("reset");
      		$('#addModulLabel').text(
      		   $('#addModulLabel').text().replace('Tambah Modul', 'Edit Modul')
      		).show();
			// $('#addModul').modal('show');
      		$.ajax({
      			type: 'POST',
      			url: 'url-API/Kelas/Modul/',
      			data: {"action": "show", "ID": ID},
      			success: function(res) {
      				if(res.data._id.$id){
      					$('#addModul').modal('show');
      					$('#idmodul').val(ID);
      					$('#namamodul').val(res.data.nama);
      				}else {
      					swal("Gagal!", "Data tidak ditemukan!", "error");
      				}
      			},
      			error: function () {
      				swal("Gagal!", "Gagal mencari data!", "error");
      			}
      		});
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
      				url: 'url-API/Kelas/Modul/',
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

		function message(){
			swal({
                title: "Ujian Sudah Dikerjakan!",
                text: "Anda Tidak Bisa Mengerjakannya Kembali!",
                type: "warning",
                confirmButtonText: "Ya",
                confirmButtonClass: "btn-primary",
                closeOnConfirm: true,
                showLoaderOnConfirm: true
            });
		};

		$(document).ready(function() {
			$(".fancybox").fancybox({
				padding: 0,
				openEffect	: 'none',
				closeEffect	: 'none'
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
