<?php
require("../../../../setting/connection.php");
spl_autoload_register(function ($class) {
  include '../../../../setting/controller/' .$class . '.php';
});

$method	= $_REQUEST;
$table  = $db->tugas;

if(isset($method['action'])){
    if($method['action'] == 'show'){
        $ID     = new MongoId($method['ID']);
        $data   = $table->findOne(array("_id" => $ID));
        $resp   = array('data'=>$data);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'showAll'){
        $catch  = $table->find(array());
        foreach ($catch as $row) {
            $data[]   = $row;
        }
        $count  = $catch->count();
        $resp   = array('count'=>$count, 'data'=>$data);
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

    if($method['action'] == 'showDetil'){
        $tugas          = $table->findOne(array("_id" => new MongoId($method['ID'])));
        $kumpul_tugas   = $db->tugas_kumpul->findOne(array("id_user" => $method['user'], "id_tugas" => $method['ID']));
        $profil         = $db->user->findOne(array('_id' => new MongoId($method['user'])));

        $data                   = array();
        $data['nama_siswa']     = $profil['nama'];
        $data['foto_siswa']     = $profil['foto'];

        $profil         = $db->user->findOne(array('_id' => new MongoId($tugas['creator'])));

        $data['nama_guru']      = $profil['nama'];
        $data['foto_guru']      = $profil['foto'];
        $data['id_tugas']       = $tugas['_id'];
        $data['id_modul']       = $tugas['id_modul'];
        $data['judul']          = $tugas['nama'];
        $data['deskripsi']      = $tugas['deskripsi'];
        $data['deadline']       = $tugas['deadline'];
        $data['creator']        = $tugas['creator'];
        $data['tugas_created']  = $tugas['date_created'];
        $data['tugas_modified'] = $tugas['date_modified'];

        if($kumpul_tugas){
            if($method['hakKelas'] != "4"){
                $data['penilaian']          = '  <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" onclick="penilaian()" title="Tugas" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk kembali ke daftar tugas."><i class="font-icon font-icon-pencil"></i> Berikan Penilaian</a>
                                                </div>
                                            ';
            }else{
                $data['penilaian']          = '';
            }
            $data['jawaban']                = $kumpul_tugas['deskripsi'];
            $data['kumpul_tugas_created']   = $kumpul_tugas['date_created'];
            $data['kumpul_tugas_modified']  = $kumpul_tugas['date_modified'];
        }else{
            $data['penilaian']              = '';
            $data['jawaban']                = "Belum Dikerjakan";
            $data['kumpul_tugas_created']   = "";
            $data['kumpul_tugas_modified']  = "";
        }

        $resp   = array('data'=>$data);
        $Json   = json_encode($resp);
        header('Content-Type: application/json');

        echo $Json;
    }

    if($method['action'] == 'showDaftarTugasSiswa'){
        $kelasClass		= new Kelas();
        $mapelClass 	= new Mapel();
        $modulClass 	= new Modul();
        $tugasClass     = new Tugas();
        $userClass		= new User();

        $infoModul		= $modulClass->getInfoModul($method['modul']);
        $infoMapel		= $mapelClass->getInfoMapel($infoModul['id_mapel']);
        $infoKelas		= $kelasClass->getInfoKelas($infoMapel['id_kelas']);

        foreach (array_values($infoKelas['list_member']) as $data) {
            $menu		= '';
            $infoUser	= $userClass->GetData($data);
            $infoHak	= $kelasClass->getKeanggotaan($infoMapel['id_kelas'], "$infoUser[_id]");

            if ($infoUser['status'] == 'siswa'){
                switch ($infoHak['status']) {
                    case 1:
                        $posisi	= "Guru Kelas";
                        break;
                    case 2:
                        $posisi	= "Guru Mata Pelajaran";
                        break;
                    case 3:
                        $posisi	= "Co-Teacher";
                        break;
                    default:
                        $posisi	= "Anggota";
                        break;
                }

                $menuAnggota	= '<div class="btn-group" style="float: right;">
                                    <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a onclick="lihat_tugas(\''.$method['ID'].'\', \'tugas-siswa\', \''.$infoUser['_id'].'\')" id="btn-lihat-tugas" class="dropdown-item"><i class="font-icon font-icon-eye"></i> Lihat Detil Tugas</a>
                                    </div>
                                </div>';

                $statusTugas        = $tugasClass->getStatusTugas($method['ID'], $infoUser['_id']) ? "<span class='label label-success'>Sudah mengumpulkan</span>" : "<span class='label label-warning'>Belum mengumpulkan</span>";

                $waktuTugas         = $tugasClass->getStatusTugas($method['ID'], $infoUser['_id']) ? "<i class='fa fa-clock-o' aria-hidden='true'></i> Mengumpulkan 2 hari yang lalu" : "<i class='fa fa-clock-o' aria-hidden='true'></i> -";

                $statusPenilaian    = '';

                $image		= empty($infoUser['foto']) ? "<img src='assets/img/avatar-2-128.png' style='max-width: 75px; max-height: 75px;' />" : "<img src='media/Assets/foto/".$infoUser['foto']."' style='max-width: 75px; max-height: 75px;' />" ;
                echo "	<tr>
                            <td width='80px;'>".$image."</td>
                            <td><span class='user-name'>$infoUser[nama]</span> <br> <div class='color-blue-grey-lighter'>".$waktuTugas."</div>".$statusTugas." </span></td>
                            <td width='70px;' class='shared'>".$statusPenilaian."</td>
                            <td width='70px;' class='shared'>".$menuAnggota."</td>
                        </tr>";
            }
        }
    }

    if($method['action'] == 'insertTugas'){
        $tugasClass     = new Tugas();

        $status         = $tugasClass->insertNilai($method['id_user'], $method['id_tugas'], $method['nilai'], $method['catatan']);

        $resp   = array('status'=>$status);
        $Json   = json_encode($resp);
        header('Content-Type: application/json');

        echo $Json;
    }

    if($method['action'] == 'getNilaiTugas'){
        $tugasClass     = new Tugas();
        $infoTugas      = $tugasClass->getStatusTugas($method['id_tugas'], $method['id_user']);

        $data               = array();
        $data['nilai']      = $infoTugas['nilai'];
        $data['catatan']    = $infoTugas['catatan'];

        $resp   = array('data'=>$data);
        $Json   = json_encode($resp);
        header('Content-Type: application/json');

        echo $Json;
    }

    if($method['action'] == 'remv'){
        $delete = array("_id" => new MongoId($method['ID']));
        $data   = $table->remove($delete);
        $resp   = array('response'=>'Terhapus!', 'message'=>'Data berhasil dihapus!', 'icon'=>'success');
		$Json   = json_encode($resp);
		header('Content-Type: application/json');

		echo $Json;
	}

}

?>
