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

$hakKelas		= $kelasClass->getKeanggotaan($infoMapel['id_kelas'], $_SESSION['lms_id']);
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
						 window.location = 'perkembangan.php?id=$rest[IDMapel]';
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
                            <h5 class="with-border"><b>Perkembangan Akademik / <a href=""><?=$infoKelas['nama']?></a></b></h5>
                            <div class="col-md-12">
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
                                                    }else {
                                                        echo "<option value=''>-- Belum Tersedia --</option>";
                                                    }
                                                ?>
                                                </select>
                    						</fieldset>
                    					</div>
                    					<div class="col-md-6 col-sm-6">
                                        <?php
                                            if($_SESSION['lms_status'] == 'guru'){
                                        ?>
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
                                        <?php
                                            }
                                        ?>
                    					</div>
                    				</div><!--.row-->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <button type="submit" name="filterData" class="btn pull-right">Tampilkan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
				</div>
			</div><!--.row-->

            <?php
            if (isset($_POST['filterData'])) {
                $idmodul    = $_POST['modulFilter'];
                $idtkb      = isset($_POST['tkbFilter']) ? $_POST['tkbFilter'] : 0;
                $cari       =
                $no         = 0;
                $siswa      = array();

                // ----> Cek Tugas <---- //
                $infoModul  = $modulClass->getInfoModul($idmodul);

                // ----> Cek Tugas <---- //
                $infoTugas  = $tugasClass->getListTugas($idmodul);
                $jmlhTugas  = $infoTugas->count();

                // ----> Cek Ujian <---- //
                $listUjian  = $quizClass->getListbyModul($idmodul);
                $jmlhUjian  = $listUjian->count();
                foreach ($listUjian as $dataUjian) {
                    $ujian[] = $dataUjian;
                }

                $table = '<div class="row">
                            <div class="col-md-12">
                                <section class="card card-default">
                                    <div class="card-block">
                                        <h5 class="with-border"><b>Perkembangan Siswa / <a href="kelas.php?id='.$infoKelas['_id'].'">'.$infoKelas['nama'].'</a> / <a href="modul.php?modul='.$infoModul['_id'].'">'.$infoModul['nama'].'</a></b></h5>
                                        <div class="col-md-12 p-y">
                                            <table id="perkembangan" class="stripe row-border order-column display table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center">Nama Siswa</th>
                                                    <th rowspan="2" class="text-center">Kelompok Belajar</th>
                                                    <th rowspan="2" class="text-center">Nilai Akhir</th>
                                                    <th colspan="'.(2+$jmlhTugas).'" class="text-center">'.$infoModul['nama'].'</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">Nilai Membaca Materi</th>';
                            if ($jmlhTugas > 0) {
                                foreach ($infoTugas as $value) {
                                    $table  .= '    <th class="text-center">Nilai Tugas <br>'.$value['nama'].'</th>';
                                }
                            }
                $table  .= '                        <th class="text-center">Nilai Evaluasi <br> '.@$ujian[0]['nama'].'</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                // Siswa melihat Perkembangannya sendiri....
                if ($_SESSION['lms_status'] == 'siswa') {
                    $nilaiMateri= 0;
                    $nilaiTugas = 0;
                    $nilaiUjian = 0;
                    $anggota        = $kelasClass->getKeanggotaan($infoMapel['id_kelas'], "$_SESSION[lms_id]");

                    if ($anggota['status'] == '4') {
                        $siswa[]        = $userClass->GetData("$_SESSION[lms_id]");
                        $siswa[$no]['tkb']   = @$anggota['tkb'];

                        // --- Nilai Membaca Materi
                        $CekNilaiMateri = $modulClass->getStatusMateri($idmodul, "$_SESSION[lms_id]");
                        $nilaiMateri    = $nilaiMateri + $CekNilaiMateri['nilai'];
                        $siswa[$no]['nilai']['modul'] = $nilaiMateri;

                        // --- Melihat nilai tugas berdasarkan jumlah tugas yang tersedia.
                        $kumpulTugas = 0;
                        if ($jmlhTugas > 0) {
                            $siswa[$no]['nilai']['totalTugas'] = 0;
                            foreach ($infoTugas as $tugas) {
                                $nilaiTugas     = 0;
                                $cekNilaiTugas  = $tugasClass->getStatusTugas($tugas['_id'], "$_SESSION[lms_id]");
                                $nilaiTugas     = $nilaiTugas + $cekNilaiTugas['nilai'];
                                $siswa[$no]['nilai']['tugas'][$kumpulTugas]['id']   = $tugas['_id'];
                                $siswa[$no]['nilai']['tugas'][$kumpulTugas]['nama'] = $tugas['nama'];
                                $siswa[$no]['nilai']['tugas'][$kumpulTugas]['nilai']= $nilaiTugas;
                                $siswa[$no]['nilai']['totalTugas'] += $nilaiTugas;
                                $kumpulTugas++;
                            }
                            $totalTugas = round(($siswa[$no]['nilai']['totalTugas']/$jmlhTugas), 2);

                            // --- Nilai Ujian
                            if ($jmlhUjian > 0) {
                                $cekNilaiUjian  = $tugasClass->getStatusQuiz($ujian[0]['_id'], "$_SESSION[lms_id]");
                                $nilaiUjian     = $nilaiUjian + $cekNilaiUjian['nilai'];
                                $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                            }else {
                                $nilaiUjian     = 0;
                                $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                            }
                        }else {
                            // --- Nilai Tugas
                            $totalTugas = 100;

                            // --- Nilai Ujian
                            if ($jmlhUjian > 0) {
                                $cekNilaiUjian      = $tugasClass->getStatusQuiz($listUjian[0]['_id'], "$_SESSION[lms_id]");
                                $nilaiUjian         = $nilaiUjian + $cekNilaiUjian['nilai'];
                                $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                            }else {
                                $nilaiUjian     = 0;
                                $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                            }
                        }

                        // Kriteria Penilaian (Persentase) yg diambil dari Pengaturan Modul.
                        $persentaseModul = $infoModul['nilai']['materi'];
                        $persentaseTugas = $infoModul['nilai']['tugas'];
                        $persentaseUjian = $infoModul['nilai']['ujian'];
                        $nilaiMinimal    = $infoModul['nilai']['minimal'];

                        // Penghitungan nilai sesuai persentase yang ada pada tiap Modul.
                        $nilaiAkhirMateri   = $persentaseModul == 0 ? 0 : round($nilaiMateri * ($persentaseModul/100), 2);
                        $nilaiAkhirTugas    = $persentaseTugas == 0 ? 0 : round($totalTugas * ($persentaseTugas/100), 2);
                        $nilaiAkhirUjian    = $persentaseUjian == 0 ? 0 : round($nilaiUjian * ($persentaseUjian/100), 2);

                        $hasil  = round($nilaiAkhirMateri + $nilaiAkhirTugas + $nilaiAkhirUjian, 2);

                        $table  .= '    <tr>
                                            <td class="text-center">'.$siswa[$no]['nama'].'</td>
                                            <td class="text-center">'.$siswa[$no]['tkb'].'</td>
                                            <td class="text-center"><h4 class="no-margin"><b><u>'.$hasil.'</u></b></h4></td>
                                            <td class="text-center">'.$nilaiMateri.'</td>';
                        if ($jmlhTugas > 0) {
                            $t=1;
                            foreach ($siswa[$no]['nilai']['tugas'] as $tableTugas) {
                                $table  .= '<td class="text-center">'.$tableTugas['nilai'].'</td>';
                                $t++;
                            }
                        }

                        $table  .= '        <td class="text-center">'.$nilaiUjian.'</td>
                                        </tr>';

                        $no++;
                    }


                    $table  .= '                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div><!--.row-->';

                // Guru melihat Perkembangannya siswa/i nya....
                }else{
                    // ----> Anggota Kelas <---- //
                    $listA      = $infoKelas['list_member'];
                    foreach ($listA as $dataA) {
                        $nilaiMateri= 0;
                        $nilaiTugas = 0;
                        $nilaiUjian = 0;
                        $anggota        = $kelasClass->getKeanggotaan($infoMapel['id_kelas'], $dataA);

                        if ($anggota['status'] == '4') {
                            if ($idtkb == '0') {
                                $siswa[]        = $userClass->GetData($dataA);
                                $siswa[$no]['tkb']   = @$anggota['tkb'];

                                // --- Nilai Membaca Materi
                                $CekNilaiMateri = $modulClass->getStatusMateri($idmodul, $dataA);
                                $nilaiMateri    = $nilaiMateri + $CekNilaiMateri['nilai'];
                                $siswa[$no]['nilai']['modul'] = $nilaiMateri;

                                // --- Nilai Tugas
                                $kumpulTugas = 0;
                                if ($jmlhTugas > 0) {
                                    $siswa[$no]['nilai']['totalTugas'] = 0;
                                    foreach ($infoTugas as $tugas) {
                                        $nilaiTugas     = 0;
                                        $cekNilaiTugas  = $tugasClass->getStatusTugas($tugas['_id'], $dataA);
                                        $nilaiTugas     = $nilaiTugas + $cekNilaiTugas['nilai'];
                                        $siswa[$no]['nilai']['tugas'][$kumpulTugas]['id']   = $tugas['_id'];
                                        $siswa[$no]['nilai']['tugas'][$kumpulTugas]['nama'] = $tugas['nama'];
                                        $siswa[$no]['nilai']['tugas'][$kumpulTugas]['nilai']= $nilaiTugas;
                                        $siswa[$no]['nilai']['totalTugas'] += $nilaiTugas;
                                        $kumpulTugas++;
                                    }
                                    $totalTugas = round(($siswa[$no]['nilai']['totalTugas']/$jmlhTugas), 2);

                                    // --- Nilai Ujian
                                    if ($jmlhUjian > 0) {
                                        $cekNilaiUjian  = $tugasClass->getStatusQuiz($ujian[0]['_id'], $dataA);
                                        $nilaiUjian     = $nilaiUjian + $cekNilaiUjian['nilai'];
                                        $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                                    }else {
                                        $nilaiUjian     = 0;
                                        $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                                    }
                                }else {
                                    // --- Nilai Tugas
                                    $totalTugas = 100;

                                    // --- Nilai Ujian
                                    if ($jmlhUjian > 0) {
                                        $cekNilaiUjian      = $tugasClass->getStatusQuiz($listUjian[0]['_id'], $dataA);
                                        $nilaiUjian         = $nilaiUjian + $cekNilaiUjian['nilai'];
                                        $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                                    }else {
                                        $nilaiUjian     = 0;
                                        $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                                    }
                                }

                                $persentaseModul = $infoModul['nilai']['materi'];
                                $persentaseTugas = $infoModul['nilai']['tugas'];
                                $persentaseUjian = $infoModul['nilai']['ujian'];
                                $nilaiMinimal    = $infoModul['nilai']['minimal'];

                                $nilaiAkhirMateri   = $persentaseModul == 0 ? 0 : round($nilaiMateri * ($persentaseModul/100), 2);
                                $nilaiAkhirTugas    = $persentaseTugas == 0 ? 0 : round($totalTugas * ($persentaseTugas/100), 2);
                                $nilaiAkhirUjian    = $persentaseUjian == 0 ? 0 : round($nilaiUjian * ($persentaseUjian/100), 2);

                                $hasil  = round($nilaiAkhirMateri + $nilaiAkhirTugas + $nilaiAkhirUjian, 2);

                                $table  .= '    <tr>
                                                    <td class="text-center">'.$siswa[$no]['nama'].'</td>
                                                    <td class="text-center">'.$siswa[$no]['tkb'].'</td>
                                                    <td class="text-center"><h4 class="no-margin"><b><u>'.$hasil.'</u></b></h4></td>
                                                    <td class="text-center" id="tdAwal"><span id="nilaiMateri" ondblclick="updateNilai(this.id, \'tdAwal\', \'updtNMateri\', \''.$siswa[$no]['_id'].'\', \''.$idmodul.'\', \''.$nilaiMateri.'\')">'.$nilaiMateri.'</span></td>';
                                if ($jmlhTugas > 0) {
                                    $t=1;
                                    foreach ($siswa[$no]['nilai']['tugas'] as $tableTugas) {
                                $table  .=  '       <td class="text-center" id="tdTugas'.$t.'"><span id="nilaiTugas'.$t.'" ondblclick="updateNilai(this.id, \'tdTugas'.$t.'\', \'updtNTugas\', \''.$siswa[$no]['_id'].'\', \''.$tableTugas['id'].'\', \''.$tableTugas['nilai'].'\')">'.$tableTugas['nilai'].'</span></td>';
                                $t++;
                                    }
                                }

                                $table  .= '        <td class="text-center" id="tdAkhir"><span id="nilaiUjian" ondblclick="updateNilai(this.id, \'tdAkhir\', \'updtNUjian\', \''.$siswa[$no]['_id'].'\', \''.$ujian[0]['_id'].'\', \''.$nilaiUjian.'\')">'.$nilaiUjian.'</span></td>
                                                </tr>';

                                $no++;
                            }else {
                                if ($anggota['tkb'] == $idtkb) {
                                    $siswa[]            = $userClass->GetData($dataA);
                                    $siswa[$no]['tkb']  = @$anggota['tkb'];

                                    // --- Nilai Membaca Materi
                                    $CekNilaiMateri = $modulClass->getStatusMateri($idmodul, $dataA);
                                    $nilaiMateri    = $nilaiMateri + $CekNilaiMateri['nilai'];
                                    $siswa[$no]['nilai']['modul'] = $nilaiMateri;

                                    // --- Nilai Tugas
                                    $kumpulTugas = 0;
                                    if ($jmlhTugas > 0) {
                                        $siswa[$no]['nilai']['totalTugas'] = 0;
                                        foreach ($infoTugas as $tugas) {
                                            $nilaiTugas     = 0;
                                            $cekNilaiTugas  = $tugasClass->getStatusTugas($tugas['_id'], $dataA);
                                            $nilaiTugas     = $nilaiTugas + $cekNilaiTugas['nilai'];
                                            $siswa[$no]['nilai']['tugas'][$kumpulTugas]['id']   = $tugas['_id'];
                                            $siswa[$no]['nilai']['tugas'][$kumpulTugas]['nama'] = $tugas['nama'];
                                            $siswa[$no]['nilai']['tugas'][$kumpulTugas]['nilai']= $nilaiTugas;
                                            $siswa[$no]['nilai']['totalTugas'] += $nilaiTugas;
                                            $kumpulTugas++;
                                        }
                                        $totalTugas = round(($siswa[$no]['nilai']['totalTugas']/$jmlhTugas), 2);

                                        // --- Nilai Ujian
                                        if ($jmlhUjian > 0) {
                                            $cekNilaiUjian  = $tugasClass->getStatusQuiz($ujian[0]['_id'], $dataA);
                                            $nilaiUjian     = $nilaiUjian + $cekNilaiUjian['nilai'];
                                            $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                                        }else {
                                            $nilaiUjian     = 0;
                                            $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                                        }
                                    }else {
                                        // --- Nilai Tugas
                                        $totalTugas = 100;

                                        // --- Nilai Ujian
                                        if ($jmlhUjian > 0) {
                                            $cekNilaiUjian      = $tugasClass->getStatusQuiz($listUjian[0]['_id'], $dataA);
                                            $nilaiUjian         = $nilaiUjian + $cekNilaiUjian['nilai'];
                                            $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                                        }else {
                                            $nilaiUjian     = 0;
                                            $siswa[$no]['nilai']['ujian'] = $nilaiUjian;
                                        }
                                    }

                                    $persentaseModul = $infoModul['nilai']['materi'];
                                    $persentaseTugas = $infoModul['nilai']['tugas'];
                                    $persentaseUjian = $infoModul['nilai']['ujian'];
                                    $nilaiMinimal    = $infoModul['nilai']['minimal'];

                                    $nilaiAkhirMateri   = $persentaseModul == 0 ? 0 : round($nilaiMateri * ($persentaseModul/100), 2);
                                    $nilaiAkhirTugas    = $persentaseTugas == 0 ? 0 : round($totalTugas * ($persentaseTugas/100), 2);
                                    $nilaiAkhirUjian    = $persentaseUjian == 0 ? 0 : round($nilaiUjian * ($persentaseUjian/100), 2);

                                    $hasil  = round($nilaiAkhirMateri + $nilaiAkhirTugas + $nilaiAkhirUjian, 2);

                                    $table  .= '    <tr>
                                                        <td class="text-center">'.$siswa[$no]['nama'].'</td>
                                                        <td class="text-center">'.$siswa[$no]['tkb'].'</td>
                                                        <td class="text-center"><h4 class="no-margin"><b><u>'.$hasil.'</u></b></h4></td>
                                                        <td class="text-center" id="tdAwal"><span id="nilaiMateri" ondblclick="updateNilai(this.id, \'tdAwal\', \'updtNMateri\', \''.$siswa[$no]['_id'].'\', \''.$idmodul.'\', \''.$nilaiMateri.'\')">'.$nilaiMateri.'</span></td>';
                                    if ($jmlhTugas > 0) {
                                        $t=1;
                                        foreach ($siswa[$no]['nilai']['tugas'] as $tableTugas) {
                                    $table  .=  '       <td class="text-center" id="tdTugas'.$t.'"><span id="nilaiTugas'.$t.'" ondblclick="updateNilai(this.id, \'tdTugas'.$t.'\', \'updtNTugas\', \''.$siswa[$no]['_id'].'\', \''.$tableTugas['id'].'\', \''.$tableTugas['nilai'].'\')">'.$tableTugas['nilai'].'</span></td>';
                                    $t++;
                                        }
                                    }

                                    $table  .= '        <td class="text-center" id="tdAkhir"><span id="nilaiUjian" ondblclick="updateNilai(this.id, \'tdAkhir\', \'updtNUjian\', \''.$siswa[$no]['_id'].'\', \''.$ujian[0]['_id'].'\', \''.$nilaiUjian.'\')">'.$nilaiUjian.'</span></td>
                                                    </tr>';

                                    $no++;
                                }
                            }
                        }

                    }
                }

                $table  .= '                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div><!--.row-->';

                // echo "<div class='col-md-12'>
                //         <pre>";
                // print_r($siswa);
                // echo "  </pre>
                //     </div>";

                echo "$table";
            }
            ?>

		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	require('includes/footer-top.php');
?>
    <script src="assets/js/lib/datatables-net/datatables.min.js"></script>
    <script src="assets/js/lib/datatables-net/buttons-1.2.0/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/datatables-net/buttons-1.2.0/js/buttons.flash.min.js"></script>
    <script src="assets/js/lib/datatables-net/buttons-1.2.0/js/buttons.print.min.js"></script>

	<script>
        var table;

        <?php
        if (isset($_POST['filterData'])) {
            echo 'table = $("#perkembangan").dataTable({
					"dom"			 : "Bfrtip",
					"buttons"		 : ["copy", "csv", "excel", "pdf", "print"],
                    "scrollX"        : true,
                    "scrollCollapse" : true,
                    "fixedColumns"   : true,
                    "order"          : [[ 1, "asc" ],[ 0, "asc" ]],
                    "bInfo"          : false,
                    "pagingType"     : "simple",
                    "lengthMenu"     : [[25, 50, -1], [25, 50, "All"]],
            });';
        }
        ?>

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

        function updateNilai(idKlik, idtd, jenis, siswa, id, nilai){
            // alert(idKlik+' - '+idtd+' - '+user+' - '+modul+' : '+nilai);
            $('#'+idKlik).html('<input type="number" class="form-group thVal" min="0" max="100" maxlength="3" style="padding: 5px; border: 1px solid #ddd; border-radius: 3px; z-index: 9999; text-align: center" value="'+nilai+'">');

            $(".thVal").focus();
            $(".thVal").keyup(function (event) {
                if (event.keyCode == 27 ) {
                    $('#'+idKlik).html(nilai);
                }

                if ($(this).val() > 100) {
                    alert('Nilai Maksimal adalah 100');
                    $('#'+idKlik).html(nilai);
                }

                if (event.keyCode == 13) {
                    nilai   = $(".thVal").val().trim();
                    $('#'+idtd).html('<span id="'+idKlik+'" ondblclick="updateNilai(\''+idKlik+'\', \''+idtd+'\', \''+jenis+'\', \''+siswa+'\', \''+id+'\', \''+$(".thVal").val().trim()+'\')">'+$(".thVal").val().trim()+'</span>');
                    // $('#'+idKlik).html($(".thVal").val().trim());

                    $.ajax({
                        type: 'POST',
                        url: 'url-API/Kelas/Modul/',
                        data: {'action':jenis, 's':siswa, 'i':id, 'n':nilai},
                        success: function(res) {
    						swal({
    				            title: res.response,
    				            text: res.message,
    				            type: res.icon
    				        }, function() {
    				            // location.reload();
    				        });
          				},
          				error: function () {
          					swal("Maaf!", "Data tidak tersimpan!", "error");
          				}
                    });
                }

            });

            $(".thVal").focusout(function () { // you can use $('html')
                $('#'+idtd).html('<span id="'+idKlik+'" ondblclick="updateNilai(\''+idKlik+'\', \''+idtd+'\', \''+jenis+'\', \''+siswa+'\', \''+modul+'\', \''+$(".thVal").val().trim()+'\')">'+$(".thVal").val().trim()+'</span>');
            });
        }

        function update(){
      		$('#updateMapel').trigger("reset");
      		$('#updateMapel').modal("show");
      		$('#updateMapelLabel').text(
      		   $('#updateMapelLabel').text().replace('Tambah Modul', 'Pengaturan Mata Pelajaran')
      		).show();
			$('#namaMapelupdate').val("<?=$infoMapel['nama']?>");
			$('#idMapelupdate').val("<?=$_GET['id']?>");
      	}
        //
        // var nilai;
        // var idKlik;
        // var idtd;
        //
        // $('.editable').click(function(e){
        //     idKlik  = $(this).attr('id');
        //     nilai   = $(this).html();
        //
        //     if (idKlik == 'nilaiMateri') {
        //         idtd    = '#tdAwal';
        //         $('#tdAwal').html('<input type="number" class="form-group thVal" min="0" max="100" maxlength="3" style="padding: 5px; border: 1px solid #ddd; border-radius: 3px; z-index: 9999; text-align: center" value="'+nilai+'">');
        //     }else if (idKlik == 'nilaiUjian') {
        //         idtd    = '#tdAkhir';
        //         $('#tdAkhir').html('<input type="number" class="form-group thVal" min="0" max="100" maxlength="3" style="padding: 5px; border: 1px solid #ddd; border-radius: 3px; z-index: 9999; text-align: center" value="'+nilai+'">');
        //     }
        //
        //     updateVal(idtd, idKlik, nilai);
        //     console.log("Nilai dari "+idtd+" adalah "+nilai);
        // });
        //
        // function updateVal(currentEle, spanEle, value) {
        //     $(".thVal").focus();
        //     $(".thVal").keyup(function (event) {
        //         if (event.keyCode == 13) {
        //             $(currentEle).html('<span class="editable" id="'+spanEle+'">'+$(".thVal").val().trim()+'</span>');
        //         }
        //
        //         if (event.keyCode == 27 ) {
        //             $(currentEle).html('<span class="editable" id="'+spanEle+'">'+value+'</span>');
        //         }
        //
        //         if ($(this).val() > 100) {
        //             alert('Nilai Maksimal adalah 100');
        //             $(currentEle).html('<span class="editable" id="'+spanEle+'">'+value+'</span>');
        //         }
        //     });
        //     //
        //     $(".thVal").focusout(function () { // you can use $('html')
        //         if ($(this).val() > 100) {
        //             $(currentEle).html('<span class="editable" id="'+spanEle+'">'+value+'</span>');
        //         } else if ($(this).val() == 0) {
        //             $(currentEle).html('<span class="editable" id="'+spanEle+'">'+value+'</span>');
        //         } else {
        //             $(currentEle).html('<span class="editable" id="'+spanEle+'">'+$(".thVal").val().trim()+'</span>');
        //         }
        //     });
        // }
	</script>

<script src="assets/js/app.js"></script>
<script src="assets/js/lib/datatables-net/datatables.min.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
