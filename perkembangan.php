<?php
require("includes/header-top.php");
require("includes/header-menu.php");

$kelasClass 	= new Kelas();
$mapelClass 	= new Mapel();
$modulClass 	= new Modul();
$materiClass 	= new Materi();
$tugasClass 	= new Tugas();
$quizClass 	    = new Quiz();
$userClass 	    = new User();

$menuMapel      = 3;
$infoMapel		= $mapelClass->getInfoMapel($_GET['id']);
$listModul		= $modulClass->getListbyMapel($_GET['id']);
$infoKelas		= $kelasClass->getInfoKelas($infoMapel['id_kelas']);

if(isset($_POST['addMateri']) || isset($_POST['updateMateri'])){
    $judul  = mysql_escape_string(trim($_POST['judul']));
    $isi    = $_POST['isi_materi'];
    $stat   = $_POST['publikasi'];
	if(isset($_POST['addMateri'])){
		$rest   = $materiClass->addMateri($_GET['modul'], $judul, $isi, $stat, $_SESSION['lms_id']);
	}else{
        // $rest['status'] = "Success";
		$rest 	= $materiClass->updateMateri($_GET['materi'], $judul, $isi, $stat);
	}

	if ($rest['status'] == "Success") {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
		echo "<script>alert('".$rest['status']."'); document.location='materi.php?modul=".$_GET['modul']."'</script>";
	}else{
		echo "<script>alert('Gagal Update')</script>";
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
		<div class="profile-header-photo" style="background-image: url('assets/img/Artboard 1.png');">
			<div class="profile-header-photo-in">
				<div class="tbl-cell">
					<div class="info-block">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="tbl info-tbl">
										<div class="tbl-row">
											<div class="tbl-cell">
												<p class="title">Mata Pelajaran <?=$infoMapel['nama']?></p>
												<p><?=$infoKelas['nama']?></p>
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
					<?php
						require("includes/mapel-menu.php");
					?>
				</div>
				<div class="col-xl-9 col-lg-8">
					<section class="card card-default">

						<div class="card-block">
                            <h5 class="with-border"><b>Perkembangan Siswa / <a href=""><?=$infoKelas['nama']?></a></b></h5>
                            <div class="col-md-12 b-b border-default p-b">
                                <h6>Pilah Berdasarkan : </h6>
                                <form id="form_tambah" method="POST">
                                    <div class="row">
                    					<div class="col-md-6 col-sm-6">
                    						<fieldset class="form-group">
                    							<label class="form-control-label" for="modulFilter">Modul</label>
                                                <select class="form-control" name="modulFilter" id="modulFilter" required>
                                                <?php
                                                    $jmlhModul = $listModul->count();
                                                    if ($jmlhModul > 0) {
                                                            echo "<option value=''>-- Pilih Modul --</option>";
                                                        foreach ($listModul as $data) {
                                                            echo "<option value='$data[_id]'>$data[nama]</option>";
                                                        }
                                                    }
                                                ?>
                                                </select>
                    						</fieldset>
                    					</div>
                    					<div class="col-md-6 col-sm-6">
                    						<fieldset class="form-group">
                                                <label class="form-control-label" for="tkbFilter">Kelompok Belajar</label>
                                                <select class="form-control" name="tkbFilter" id="tkbFilter">
                                                <?php
                                                    $jmlhTKB = explode(',', $infoKelas['tkb']);
                                                    sort($jmlhTKB);
                                                    if ($jmlhTKB > 0) {
                                                            echo "<option value='0'>-- Semua Kelompok Belajar --</option>";
                                                        foreach ($jmlhTKB as $data) {
                                                            echo "<option value='$data'>$data</option>";
                                                        }
                                                    }else {
                                                        echo "<option value=''>Tidak ada Kelompok Belajar</option>";
                                                    }
                                                ?>
                                                </select>
                    						</fieldset>
                    					</div>
                    				</div><!--.row-->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <button type="submit" name="filterData" class="btn pull-right">Tampilkan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php
                        if (isset($_POST['filterData'])) {
                            $idmodul    = $_POST['modulFilter'];
                            $idtkb      = $_POST['tkbFilter'];
                            $no         = 0;
                            $nilaiModul = 0;
                            $nilaiTugas = 0;
                            $nilaiUjian = 0;
                            $siswa      = array();

                            // ----> Cek Tugas <---- //
                            $infoTugas  = $tugasClass->getListTugas($idmodul);
                            $jmlhTugas  = $infoTugas->count();

                            $table = '<div class="col-md-12">
                                        <table id="perkembangan" class="stripe row-border order-column display table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead id="judulTable">
                                            <tr id="judulModul">
                                                <th class="text-center">Nama Siswa</th>
                                                <th class="text-center">Kelompok Belajar</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Nilai Membaca Materi</th>';
                            foreach ($tugasModuls as $value) {
                                $table  .= '    <th class="text-center">'.$value['nama'].'</th>';
                            }
                            $table  .= '        <th class="text-center">Nilai Ujian</th>
                                            </tr>
                                        </thead>';

                            // ----> Anggota Kelas <---- //
                            $listA      = $infoKelas['list_member'];
                            foreach ($listA as $dataA) {
                                $siswa          = $userClass->GetData($dataA['id_user']);
                                $siswa['tkb']   = $dataA['tkb'];

                                // --- Nilai Membaca Materi
                                $infoModul      = $modulClass->getInfoModul($idmodul);
                                $nilaiModul     += $infoModul['nilai'];
                                $siswa['nilai']['modul'] = $nilaiModul;

                                // --- Nilai Tugas
                                if ($jmlhTugas > 0) {
                                    $kumpulTugas = 0;
                                    foreach ($infoTugas as $tugas) {
                                        $cekNilaiTugas  = $this->db->tugas_kumpul->findOne(array("id_tugas"=>"$tugas[_id]", "id_user"=>"$user"));
                                        $nilaiTugas     = $nilaiTugas + $cekNilaiTugas['nilai'];
                                        $nilai['tugas']['nama'] = $tugas['nama'];
                                        $nilai['tugas']['nilai']= $tugas['nilai'];
                                        $kumpulTugas++;
                                    }
                                    $totalTugas = round(($nilaiTugas/$jmlhTugas), 2);

                                    $evaluasi  = $quizClass->getInfoQuiz($idmodul);
                                    if ($evaluasi) {
                                        $cekNilaiEvaluasi   = $this->db->kumpul_quiz->findOne(array("id_quiz"=>"$evaluasi[_id]", "id_user"=>"$user"));
                                        $nilaiUjian      += $cekNilaiEvaluasi['nilai'];
                                    }
                                }else {
                                    $totalTugas = 100;
                                    $evaluasi  = $this->db->quiz->findOne(array('id_modul' => "$idmodul"));
                                    if ($evaluasi) {
                                        $cekNilaiEvaluasi   = $this->db->kumpul_quiz->findOne(array("id_quiz"=>"$evaluasi[_id]", "id_user"=>"$user"));
                                        $nilaiUjian      += $cekNilaiEvaluasi['nilai'];
                                    }
                                }


                            }


                        }
                        ?>
                            <!-- <div class="col-md-12">
                                <table id="perkembangan" class="stripe row-border order-column display table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead id="judulTable">
                                        <tr id="judulModul">
                                            <th class="text-center">Nama Siswa</th>
                                            <th class="text-center">Kelompok Belajar</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="nilaiSiswa">
                                        <tr>
                                            <td colspan="3" class="text-center"> Silahkan pilah berdasarkan modul dan kelompok belajar</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> -->
						</div>

					</section>
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

		$(document).ready(function() {
			$('.note-statusbar').hide();
		});

        $('#modul').change(function(){

            // $('#nilaiSiswa').html('');
            // $('#perkembangan').dataTable({
            //     'searching'      : false,
            //     'scrollX'        : true,
            //     'scrollCollapse' : true,
            //     'fixedColumns'   : true,
            //     'order'          : [[ 1, 'asc' ],[ 0, 'asc' ]],
            //     'bInfo'          : false,
            //     'bLengthChange'  : false,
            //     'pagingType'     : 'simple',
            //     'lengthMenu'     : [[25, 50, -1], [25, 50, "All"]],
            //     'processing'     : true,
            //     'serverSide'     : true,
            //     ajax: {
            //         url: "url-API/Kelas/",
            //         data: function ( d ) { d.action = 'daftarPerkembangan', d.Modul = $('#modul').val(), d.Kelas = "<?=$infoKelas['_id']?>" },
            //         success: function(res) {
            //             var html = '<th rowspan="2" class="text-center">Nama Siswa</th>';
            //                 html +='<th rowspan="2" class="text-center">Kelompok Belajar</th>'+
            //                         '<th rowspan="2" class="text-center">Total</th>'+
            //                         '<th colspan="'+res.kolom+'" class="text-center">Total</th>';
            //             $('#judulModul').html(html);
      // 				}
            //     },
            //     columnDefs: [
            //
            //     ],
            // });
        });

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
      				url: 'url-API/Kelas/Modul/Materi/',
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

			$('#example').DataTable();
		});
	</script>

<script src="assets/js/app.js"></script>
<script src="assets/js/lib/datatables-net/datatables.min.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
