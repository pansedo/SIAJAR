<?php
require("includes/header-top.php");
require("includes/header-menu.php");

$mapelClass = new Mapel();
$modulClass = new Modul();
$kelasClass = new Kelas();
$tugasClass = new Tugas();

$infoMapel	= $mapelClass->getInfoMapel($_GET['id']);
$listModul	= $modulClass->getListbyMapel($_GET['id']);
$infoKelas	= $kelasClass->getInfoKelas($infoMapel['id_kelas']);

$hakKelas	= $kelasClass->getKeanggotaan($infoMapel['id_kelas'], $_SESSION['lms_id']);
$anggota	= in_array($_SESSION['lms_id'], array_values($infoKelas['list_member'])) ? true : false;
if(!$anggota){
	echo "<script>
			swal({
				title: 'Maaf!',
				text: 'Anda tidak terdaftar pada Kelas ini.',
				type: 'error'
			}, function() {
				 window.location = 'index.php';
			});
		</script>";
		die();
}

if(isset($_POST['addModul']) || isset($_POST['updateModul'])){
	if (isset($_POST['updateModul'])) {
		$rest = $modulClass->setModul($_POST, $_GET['id']);
	}else{
		$rest = $modulClass->addModul($_POST, $_GET['id'], $_SESSION['lms_id']);
	}

	if ($rest['status'] == "Success") {
		echo "<script>alert('".$rest['status']."'); document.location='mapel.php?id=".$rest['IDMapel']."'</script>";
	}
	// print_r($rest);
}

if(isset($_POST['updateMapel'])){
	if ($hakKelas['status'] == 1 || $hakKelas['status'] == 2) {
		$nama	= mysql_escape_string($_POST['namaMapelupdate']);
		$rest	= $mapelClass->updateMapel($nama, $_GET['id']);

		echo	"<script>
					swal({
						title: '$rest[judul]',
						text: '$rest[message]',
						type: '$rest[status]'
					}, function() {
						 window.location = 'mapel.php?id=$rest[IDMapel]';
					});
				</script>";
	}else {
		echo	"<script>
					swal({
						title: 'Maaf!',
						text: 'Anda tidak memiliki kewenangan dalam merubah Pengaturan kelas.',
						type: 'error'
					}, function() {
						 window.location = 'index.php';
					});
				</script>";
	}
}

?>
<link rel="stylesheet" href="./assets/css/separate/pages/others.min.css">

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
							<input type="hidden" class="form-control" name="idMapelupdate" id="idMapelupdate"  />
							<input type="text" class="form-control" name="namaMapelupdate" id="namaMapelupdate" placeholder="Nama Mata Pelajaran" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-danger pull-left" onclick="" name="hapusMapel"><i class="font-icon-trash"></i> Hapus Mata Pelajaran</button>
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
				<form method="POST" id="addModulForm">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="addModulLabel">Tambah Modul</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="namamodul" class="col-md-3 form-control-label">Nama Modul</label>
						<div class="col-md-9">
							<input type="hidden" name="idmodul" id="idmodul" class="" maxlength="11" />
							<input type="text" class="form-control" name="namamodul" id="namamodul" placeholder="Nama Modul" title="Nama Modul" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Silahkan isikan Nama Modul yang akan dibuat!" required/>
						</div>
					</div>
					<div class="form-group row">
						<label for="namamodul" class="col-md-3 form-control-label">Prasyarat Modul</label>
						<div class="col-md-9">
							<select class="form-control" name="prasyaratmodul" id="prasyaratmodul" title="Prasyarat Modul" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Silahkan pilih modul yang akan dijadikan prasyarat untuk membuka modul ini! Jika tidak ada silahkan pilih 'Tidak ada'" required>
								<option value="0">-- Tidak ada --</option>
								<?php
								foreach ($listModul as $data) {
									echo '<option value="'.$data['_id'].'">'.$data['nama'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="nilaimateri" class="col-md-3 form-control-label">Nilai Materi</label>
						<div class="col-md-3">
							<div class="input-group">
								<input type="number" min="0" max="100" value="0" class="form-control" onchange="checkTotal()" name="nilaimateri" id="nilaimateri" required>
								<div class="input-group-addon">%</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="nilaitugas" class="col-md-3 form-control-label">Nilai Tugas</label>
						<div class="col-md-3">
							<div class="input-group">
								<input type="number" min="0" max="100" value="0" class="form-control" onchange="checkTotal()" name="nilaitugas" id="nilaitugas" required>
								<div class="input-group-addon">%</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="nilaiujian" class="col-md-3 form-control-label">Nilai Ujian</label>
						<div class="col-md-3">
							<div class="input-group">
								<input type="number" min="0" max="100" value="0" class="form-control" onchange="checkTotal()" name="nilaiujian" id="nilaiujian" required>
								<div class="input-group-addon">%</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="namamodul" class="col-md-3 form-control-label">Nilai Minimal</label>
						<div class="col-md-2">
							<input type="number" min="0" max="100" value="0" class="form-control" placeholder="1 - 100" name="nilaiminimal" id="nilaiminimal" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="btn-submit" name="addModul" value="send" class="btn btn-rounded btn-primary">Simpan</button>
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
			<?php
			if ($_SESSION['lms_id'] == $infoMapel['creator']) {
			?>
			<button type="button" class="change-cover" onclick="update()">
				<i class="font-icon font-icon-pencil"></i>
				Pengaturan Mata Pelajaran
			</button>
			<?php
			}
			?>
		</div><!--.profile-header-photo-->

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-lg-4">
					<aside id="menu-fixed" class="profile-side" style="margin: 0 0 20px">
						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Menu
							</header>
							<div class="box-typical-inner">
								<ul class="side-menu-list">
									<li class="blue opened">
										<a href="mapel.php?id=<?=$_GET['id']?>">
							                <i class="font-icon font-icon-home active"></i>
							                <span class="lbl">Pelajaran</span>
							            </a>
									</li>
									<li class="blue">
										<a href="scheduler.html">
											<i class="font-icon font-icon-zigzag"></i>
											<span class="lbl">Perkembangan</span>
										</a>
									</li>
								</ul>
							</div>
						</section>

					</aside><!--.profile-side-->
				</div>

				<div class="col-xl-9 col-lg-8">
					<section class="widget widget-activity">
						<header class="widget-header">
							Alur Pembelajaran
							<span class="label label-pill label-primary"><?=$infoMapel['modul']?></span>
						<?php
						if ($hakKelas['status'] == 1 || $hakKelas['status'] == 2) {
							if(($hakKelas['status'] == 2) && ($infoMapel['creator'] == $_SESSION['lms_id'])){
								echo '<div class="btn-group" style="float: right;">
										<button type="button" class="btn btn-sm btn-rounded btn-inline" onclick="add()" title="Tambah" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menambahkan Modul baru.">+ Tambah Modul</button>
									</div>';
							}elseif($hakKelas['status'] == 1) {
								echo '<div class="btn-group" style="float: right;">
										<button type="button" class="btn btn-sm btn-rounded btn-inline" onclick="add()" title="Tambah" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menambahkan Modul baru.">+ Tambah Modul</button>
									</div>';
							}
						}
						?>
						</header>
						<div>
							<?php
								if ($listModul->count() > 0) {
									$no = 1;
									foreach ($listModul as $modul) {
										// $$tugasClass->getStatusTugas($modul['_id'], $_SESSION['lms_id']);
										if ($modulClass->getLearningPath($modul['prasyarat']) == "LULUS") {
							?>
										<div class="widget-activity-item">
											<div class="user-card-row">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-photo">
														<a href="modul.php?modul=<?=$modul['_id']?>">
															<img src="assets/img/folder.png" alt="">
														</a>
													</div>
													<div class="tbl-cell">
														<p>
															<a href="modul.php?modul=<?=$modul['_id']?>" class="semibold"><?=''.$no.'. '.$modul['nama']?></a>
														</p>
														<p><?=selisih_waktu($modul['date_created'])?></p>
													</div>
											<?php
											if ($_SESSION['lms_id'] == $modul['creator']) {
											?>
													<div class="tbl-cell" align="right">
														<a onclick="edit('<?=$modul['_id']?>')" title="Edit" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk memperbarui Modul yang sudah dibuat."><i class="font-icon font-icon-pencil"></i></a>
														<a onclick="remove('<?=$modul['_id']?>')" title="Hapus" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menghapus Modul yang sudah dibuat."><i class="font-icon font-icon-trash"></i></a>
													</div>
											<?php
											}
											?>
												</div>
											</div>
										</div>
								<?php
										}else {
								?>
										<div class="widget-activity-item">
											<div class="user-card-row">
												<div class="tbl-row">
													<div class="tbl-cell tbl-cell-photo">
														<a href="modul.php?modul=<?=$modul['_id']?>">
															<img src="assets/img/folder-na.png" alt="">
														</a>
													</div>
													<div class="tbl-cell">
														<p>
															<a onclick="" class="semibold"><?=''.$no.'. '.$modul['nama']?></a>
														</p>
														<p><?=selisih_waktu($modul['date_created'])?></p>
													</div>
											<?php
											if ($_SESSION['lms_id'] == $modul['creator']) {
											?>
													<div class="tbl-cell" align="right">
														<a onclick="edit('<?=$modul['_id']?>')" title="Edit" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk memperbarui Modul yang sudah dibuat."><i class="font-icon font-icon-pencil"></i></a>
														<a onclick="remove('<?=$modul['_id']?>')" title="Hapus" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menghapus Modul yang sudah dibuat."><i class="font-icon font-icon-trash"></i></a>
													</div>
											<?php
											}
											?>
												</div>
											</div>
										</div>
								<?php
										}
										$no++;
									}
								} else {
									echo '
												<div class="add-customers-screen tbl">
													<div class="add-customers-screen-in">
														<div class="add-customers-screen-user">
															<i class="fa fa-file-text-o"></i>
														</div>
														<h2>Modul masih Kosong</h2>
														<p class="lead color-blue-grey-lighter">Belum ada modul yang tersedia saat ini.</p>
													</div>
												</div>';
								}
							?>
							<!-- <div class="widget-activity-item">
								<div class="user-card-row">
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-photo">
											<a href="#">
												<img src="assets/img/folder-na.png" alt="">
											</a>
										</div>
										<div class="tbl-cell">
											<p>
												<a href="#" class="semibold">Modul Non Aktif</a>
												added a new product
												<a href="#">Free UI Kit</a>
											</p>
											<p>Just Now</p>
										</div>
									</div>
								</div>
							</div> -->
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

		function checkTotal(){
      		var materi 	= parseInt($('#nilaimateri').val());
      		var tugas	= parseInt($('#nilaitugas').val());
      		var ujian	= parseInt($('#nilaiujian').val());
			var total	= 100;
			var gabung	= materi+tugas+ujian;

			// alert(gabung+' - '+total);
			if (gabung > total) {
				swal({
					title: 'Maaf!',
					text: 'Jumlah total nilai HARUS 100%, tidak boleh lebih ataupun kurang.',
					type: 'warning'
				}, function() {
					$('#nilaimateri').val(0);
					$('#nilaitugas').val(0);
					$('#nilaiujian').val(0);
				});

				//	swal({
				//		title: "Maaf!",
				//		text: "Jumlah total nilai tidak dapat lebih dari 100%, Apakah anda mengisi kembali ?",
				//		type: "warning",
				//		showCancelButton: true,
				//  	confirmButtonText: "Ya",
	      		//		confirmButtonClass: "btn-danger",
				//		closeOnConfirm: false,
				//		showLoaderOnConfirm: true
				//	}, function () {
				//		$('#nilaimateri').val(0);
				//		$('#nilaitugas').val(0);
				//		$('#nilaiujian').val(0);
				//	});
			}
      	};

		function add(){
      		$('#addModulForm').trigger("reset");
      		$('#addModul').modal('show');
			$('#addModulLabel').text(
      		   $('#addModulLabel').text().replace('Edit Modul', 'Tambah Modul')
      		).show();
			$('#btn-submit').attr('name', 'addModul');
			$.ajax({
				type: 'POST',
				url: 'url-API/Kelas/Modul/',
				data: {"action": "showAll", "IDKelas": '<?=$_GET['id']?>'},
				success: function(res) {
					if(res.data.length > 0){
						var html	= '<option value="0">-- Tidak ada --</option>';
			          	for(var i=0;i<res.data.length;i++){
			       			html += '<option value="'+res.data[i]._id.$id+'">'+res.data[i].nama+'</option>';
			          	}
			          $("#prasyaratmodul").html('');
			          $("#prasyaratmodul").html(html);
				  	}else {
				  		swal("Gagal!", "Data tidak tersedia!", "error");
				  	}
			  	},
				error: function () {
					swal("Gagal!", "Data tidak dapat diambil!", "error");
				}
			});
      	};

		function update(){
      		$('#updateMapel').trigger("reset");
      		$('#updateMapel').modal("show");
      		$('#updateMapelLabel').text(
      		   $('#updateMapelLabel').text().replace('Tambah Modul', 'Pengaturan Mata Pelajaran')
      		).show();
			$('#namaMapelupdate').val("<?=$infoMapel['nama']?>");
			$('#idMapelupdate').val("<?=$_GET['id']?>");
      	}

		function edit(ID){
      		$('#addModulForm').trigger("reset");
      		$('#addModulLabel').text(
      		   $('#addModulLabel').text().replace('Tambah Modul', 'Edit Modul')
      		).show();
			$.ajax({
				type: 'POST',
				url: 'url-API/Kelas/Modul/',
				data: {"action": "showAll", "IDKelas": '<?=$_GET['id']?>'},
				success: function(res) {
					if(res.data.length > 0){
						var html	= '<option value="0">-- Tidak ada --</option>';
			          	for(var i=0;i<res.data.length;i++){
							if(res.data[i]._id.$id != ID){
			       				html += '<option value="'+res.data[i]._id.$id+'">'+res.data[i].nama+'</option>';
							}
			          	}
			          $("#prasyaratmodul").html('');
			          $("#prasyaratmodul").html(html);

					  $.ajax({
		        			type: 'POST',
		        			url: 'url-API/Kelas/Modul/',
		        			data: {"action": "show", "ID": ID},
		        			success: function(res) {
		        				if(res.data._id.$id){
		        					$('#btn-submit').attr('name', 'updateModul');
		        					$('#addModul').modal('show');
		        					$('#idmodul').val(ID);
		        					$('#namamodul').val(res.data.nama);
		        					$('#nilaimateri').val(res.data.nilai.materi);
		        					$('#nilaitugas').val(res.data.nilai.tugas);
		        					$('#nilaiujian').val(res.data.nilai.ujian);
		        					$('#nilaiminimal').val(res.data.nilai.minimal);
		  							SelectElement('prasyaratmodul', res.data.prasyarat);
		        				}else {
		        					swal("Gagal!", "Data tidak ditemukan!", "error");
		        				}
		        			},
		        			error: function () {
		        				swal("Gagal!", "Gagal mencari data!", "error");
		        			}
		        		});
			        }else {
			          swal("Error!", "Data tidak ditemukan!", "error");
			        }
				},
				error: function () {
					swal("Gagal!", "Data tidak tersedia!", "error");
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

		$(document).ready(function() {
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
