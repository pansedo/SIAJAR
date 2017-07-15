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

$menuModul		= 2;
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
<link rel="stylesheet" href="assets/css/lib/datatables-net/datatables.min.css">
<link rel="stylesheet" href="assets/css/separate/vendor/datatables-net.min.css">

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
		</div><!--.profile-header-photo-->

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12 col-lg-12">
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
	</script>

	<script src="assets/js/app.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
