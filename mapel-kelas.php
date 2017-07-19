<?php
// error_reporting(E_ALL);
require("includes/header-top.php");
require("includes/header-menu.php");

$kelasClass = new Kelas();
$mapelClass = new Mapel();
$userClass	= new User();

$infoKelas	= $kelasClass->getInfoKelas($_GET['id']);
$infoMapel	= $mapelClass->getListbyKelas($_GET['id']);
$infoUser	= $userClass->GetData($_SESSION['lms_id']);

$hakKelas	= $kelasClass->getKeanggotaan($_GET['id'], $_SESSION['lms_id']);
// $anggota	= in_array($_SESSION['lms_id'], array_values($infoKelas['list_member'])) ? true : false;
if(!$hakKelas['status']){
	echo "<script>
			swal({
				title: 'Maaf!',
				text: 'Anda tidak terdaftar pada Kelas / Kelas tidak tsb tidak ada.',
				type: 'error'
			}, function() {
				 window.location = 'index.php';
			});
		</script>";
		die();
}

//---> Proses Penambahan Mata Pelajaran
if(isset($_POST['addMapel'])){
	//---> memeriksa Hak Akses dalam Kelas || Hanya Pemilik dan Guru Mapel yang dapat membuat Kelas
	if ($hakKelas['status'] == 1 || $hakKelas['status'] == 2) {
		$nama	= mysql_escape_string($_POST['namamapel']);
		$kelas	= mysql_escape_string($_GET['id']);
		$rest 	= $mapelClass->addMapel($nama, $kelas, $_SESSION['lms_id']);
		if ($rest['status'] == "Success") {
			echo	"<script>
						swal({
							title: 'Berhasil!',
							text: 'Mata Pelajaran dgn nama \'$nama\' berhasil dibuat!',
							type: 'success'
						}, function() {
							 window.location = 'mapel.php?id=".$rest['IDMapel']."';
						});
					</script>";
		}else {
			echo	"<script>
						swal({
							title: 'Maaf!',
							text: 'Mata Pelajaran tidak berhasil dibuat.',
							type: 'error'
						}, function() {
							 window.location = 'mapel.php?id=".$rest['IDMapel']."';
						});
					</script>";
		}
	}else {
		echo	"<script>
					swal({
						title: 'Maaf!',
						text: 'Anda tidak memiliki kewenangan dalam menambahkan Mata Pelajaran baru.',
						type: 'error'
					}, function() {
						 window.location = 'index.php';
					});
				</script>";
	}

}

//---> Proses Penambah Posting pada Kelas
if(isset($_POST['postingText'])){
	if ($hakKelas['status'] == 1 || $hakKelas['status'] == 2) {
		$post	= trim(htmlentities($_POST['textPost']));
		$rest	= $kelasClass->addPost($post, $infoKelas['_id'], $_SESSION['lms_id']);

		if ($rest['status'] == "Success") {
			echo "<script>document.location='kelas.php?id=".$_GET['id']."'</script>";
		}else{
			echo	"<script>
						swal({
							title: 'Maaf!',
							text: 'Anda tidak memiliki kewenangan dalam menambahkan Posting-an baru.',
							type: 'error'
						}, function() {
							 window.location = 'index.php';
						});
					</script>";
		}
	}else {
		echo	"<script>
					swal({
						title: 'Maaf!',
						text: 'Anda tidak memiliki kewenangan dalam menambahkan Posting-an baru.',
						type: 'error'
					}, function() {
						 window.location = 'index.php';
					});
				</script>";
	}
}

//---> Proses Update Pengaturan Kelas
if(isset($_POST['updateKelas'])){
	if ($hakKelas['status'] == 1) {
		$nama	= mysql_escape_string($_POST['namakelasupdate']);
		$post	= htmlentities($_POST['tentang']);
		$rest	= $kelasClass->updateKelas($nama, $post, $_GET['id']);

		echo	"<script>
					swal({
						title: '$rest[judul]',
						text: '$rest[message]',
						type: '$rest[status]'
					}, function() {
						 window.location = 'kelas.php?id=$rest[IDKelas]';
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
<link rel="stylesheet" href="assets/css/lib/datatables-net/datatables.min.css">
<link rel="stylesheet" href="assets/css/separate/vendor/datatables-net.min.css">
<style media="screen">
	tr:last-child td {
		border-bottom: 1px solid #d8e2e7;
	}
	.user-name{
		font-size: 1.1em;
		font-weight: bold;
	}
	.table a{
		border: none;
	}
</style>
	<div class="modal fade"
		 id="updateKelas"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="updateKelasLabel"
		 aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="POST">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="updateKelasLabel">Pengaturan Kelas</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="namakelasupdate" class="col-md-3 form-control-label">Nama Kelas</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="namakelasupdate" id="namakelasupdate" placeholder="Nama Kelas" value="<?=$infoKelas['nama']?>" />
						</div>
					</div>
					<div class="form-group row">
						<label for="tentang" class="col-md-3 form-control-label">Tentang Kelas</label>
						<div class="col-md-9">
							<textarea class="form-control" name="tentang" id="tentang" placeholder="Deskripsikan tentang kelas anda - Maksimal 260 karakter" maxlength="260"><?=$infoKelas['tentang']?></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-danger pull-left" onclick="" name="hapusKelas"><i class="font-icon-trash"></i> Hapus Kelas</button>
					<button type="submit" class="btn btn-rounded btn-primary" name="updateKelas" value="send" >Simpan</button>
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
						<label for="namamapel" class="col-md-3 form-control-label">Nama Mata Pelajaran</label>
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
													<p class="title"><?=$infoMapel->count()?></p>
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
		<?php
		//---> memeriksa Hak Akses dalam Kelas || Hanya pemilik Kelas yang dapat membuka Pengaturan Kelas
		if ($hakKelas['status'] == 1) {
		?>
			<button type="button" class="change-cover" onclick="update()">
				<i class="font-icon font-icon-pencil"></i>
				Pengaturan Kelas
			</button>
		<?php
		}
		?>
		</div><!--.profile-header-photo-->

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-lg-4">
					<aside id="menu-fixed2" class="profile-side" style="margin: 0 0 20px">
						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Kode Kelas
							<?php
							//---> memeriksa Hak Akses dalam Kelas || Hanya pemilik Kelas yang dapat Kunci kelas/Buka kelas
							if ($hakKelas['status'] == 1) {
							?>
								<div class="btn-group" style='float: right;'>
									<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Aksi
									</button>
									<div class="dropdown-menu" style="margin-left: -100px">
									<?php
									//---> perintah Kunci Kelas / Buka Kelas
									if ($infoKelas['status'] != 'LOCKED') {
		                            	echo '<a class="dropdown-item" onclick="lockKelas(\'1\')"><i class="font-icon font-icon-lock"></i>Kunci Kelas</a>';
									}else {
										echo '<a class="dropdown-item" onclick="lockKelas(\'2\')"><span class="font-icon fa fa-unlock"></span>Buka Kelas</a>';
									}
									?>
									</div>
								</div>
							<?php
							}
							?>
							</header>
							<div class="box-typical-inner">
								<p style="font-size: 2em; font-weight:bold; text-align: center;">
									<?php
									if ($infoKelas['status'] != 'LOCKED') {
										echo '<u>'.$infoKelas['kode'].'</u>';
									}else {
										echo '<i class="font-icon font-icon-lock"></i> LOCKED';
									}
									?>
								</p>
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">Tentang Kelas</header>
							<div class="box-typical-inner">
								<p><?=nl2br($infoKelas['tentang'])?></p>
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Daftar Mata Pelajaran

							<?php
							if ($hakKelas['status'] == 1 || $hakKelas['status'] == 2) {
							?>
								<div class="btn-group" style='float: right;'>
									<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Aksi
									</button>
									<div class="dropdown-menu" style="margin-left: -100px">
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#addMapel"><span class="font-icon font-icon-plus"></span>Tambah Mata Pelajaran</a>
		                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-pencil"></span>Kelola Mata Pelajaran</a>
									</div>
								</div>
							<?php
							}
							?>
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
					<section class="widget widget-tasks card-default">
						<header class="card-header">
							Daftar Mata Pelajaran
							<?php
							if ($hakKelas['status'] == 1 || $hakKelas['status'] == 2) {
								echo '<div class="btn-group" style="float: right;">
										<button type="button" class="btn btn-sm btn-rounded" data-toggle="modal" data-target="#addMapel" title="Tambah" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menambahkan Mata Pelajaran baru.">+ Tambah Mata Pelajaran</button>
									</div>';
							}
							?>
						</header>
						<div class="widget-tasks-item">
							<table id="example" class="display table table-striped" cellspacing="0" width="100%">
								<thead style="display:none;">
									<tr>
										<th>Nama Mata Pelajaran</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php
							if ($infoMapel->count() > 0) {
								foreach ($infoMapel as $data) {
									$menu	= '<div class="btn-group" style="float: right;">
													<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Aksi
													</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" onclick="remove(\''.$data['_id'].'\')">Hapus Mata Pelajaran</a>
													</div>
												</div>';

									echo "	<tr>
												<td><a href='mapel.php?id=$data[_id]' title='$data[nama]' data-toggle='popover' data-placement='bottom' data-trigger='hover' data-content='Klik tautan diatas untuk membuka materi mata pelajaran tersebut.'><span class='user-name'>$data[nama]</span></a></td>
												<td width='70px;' class='shared'>".($hakKelas['status'] == 1 ? $menu : '')."</td>
											</tr>";
								}
							}
							?>
								</tbody>
							</table>
						</div>
					</section><!--.widget-tasks-->
				</div>
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	require('includes/footer-top.php');
?>
<script src="assets/js/lib/datatables-net/datatables.min.js"></script>

<script>
	var table;

	function clearText(elementID){
		$(elementID).html("");
	}

	function update(){
  		$('#updateKelas').trigger("reset");
  		$('#updateKelas').modal("show");
  		$('#updateKelasLabel').text(
  		   $('#updateKelasLabel').text().replace('Tambah Modul', 'Pengaturan Kelas')
  		).show();
  	}

		function remove(ID){
      		swal({
      		  title: "Hapus Mata Pelajaran?",
      		  text: "Semua data akan hilang dan tidak dapat dikembalikan.",
      		  type: "warning",
      		  showCancelButton: true,
			  	confirmButtonText: "Ya",
      			confirmButtonClass: "btn-danger",
      		  closeOnConfirm: false,
      		  showLoaderOnConfirm: true
      		}, function () {
      			$.ajax({
      				type: 'POST',
      				url: 'url-API/Kelas/Mapel/',
      				data: {"action": "removeMapel", "ID": ID},
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

	function lockKelas(ID){
		var isiText = '';
		if(ID == 1){
			isiText = 'Saat Kelas di Kunci, maka tidak ada yang dapt bergabung ke dalam Kelas hingga anda membukanya kembali.';
		}else {
			isiText = 'Kelas akan dibuka, sehingga siapa saja yang memiliki Kode Kelas ini dapat bergabung ke dalam Kelas.';
		}
  		swal({
  		  title: "Apakah anda yakin?",
  		  text: isiText,
  		  type: "warning",
  		  showCancelButton: true,
		  	confirmButtonText: "Setuju!",
  			confirmButtonClass: "btn-warning",
  		  closeOnConfirm: false,
  		  showLoaderOnConfirm: true
  		}, function () {
  			$.ajax({
  				type: 'POST',
  				url: 'url-API/Kelas/',
  				data: {"action": "lockKelas", "ID": "<?=$_GET['id']?>", "user": "<?=$_SESSION['lms_id']?>"},
  				success: function(res) {
					if(res.status == 'Success'){
						swal({
							title: 'Berhasil!',
							text: res.message,
							type: 'success'
						}, function() {
							 window.location = "kelas.php?id=<?=$_GET['id']?>";
						});
					}else {
						swal('Maaf!', 'Kelas tidak berhasil di Kunci.', 'error');
					}
  				},
  				error: function () {
  					swal("Maaf!", "Data tidak berhasil diubah!", "error");
  				}
  			});
  		});
  	}

	$(document).ready(function() {
		table = $('#example').DataTable({
			"order": [[ 1, "asc" ]],
			'responsive' : true,
			'bInfo' : false,
			'bLengthChange' : false,
			'pagingType' : 'simple',
			"lengthMenu": [[20, 50, -1], [20, 50, "All"]]
		});

		$.ajax({
			type: 'POST',
			url: 'url-API/Kelas/Mapel/',
			data: {"action": "showList", "ID": "<?=$_GET['id']?>"},
			success: function(res) {
				$('#listMapel').html('');
				$('#jumlahMapel').html(res.data.length);
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

	});
</script>

<script src="assets/js/app.js"></script>

<?php
	require('includes/footer-bottom.php');
?>
