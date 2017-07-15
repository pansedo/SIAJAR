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
								<a href="kelas.php?id=<?=$infoKelas['_id']?>" class="pull-right" title="Kelas" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Kembali ke halaman kelas"><i class="font-icon font-icon-answer" style="color: #3ac9d6;"></i></a>Menu
							</header>
							<div class="box-typical-inner">
								<ul class="side-menu-list">
									<li class="blue">
										<a href="mapel.php?id=<?=$_GET['id']?>">
							                <i class="font-icon font-icon-home"></i>
							                <span class="lbl">Pelajaran</span>
							            </a>
									</li>
									<li class="blue opened">
										<a href="perkembangan.php?id=<?=$_GET['id']?>">
											<i class="font-icon font-icon-zigzag active"></i>
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
							Perkembangan
							<span class="label label-pill label-primary"><?=$infoMapel['modul']?></span>
						</header>
						<br />
						<div class="card-block">
							<table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th>Nama</th>
									<th>Kelompok Belajar</th>
									<th>Nilai Materi</th>
									<th>Nilai Tugas</th>
									<th>Nilai Kuis</th>
									<th>Action</th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th>Name</th>
									<th>Position</th>
									<th>Office</th>
									<th>Age</th>
									<th>Start date</th>
									<th>Salary</th>
								</tr>
								</tfoot>
								<tbody>
								<tr>
									<td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>Edinburgh</td>
									<td>61</td>
									<td>2011/04/25</td>
									<td>$320,800</td>
								</tr>
								<tr>
									<td>Garrett Winters</td>
									<td>Accountant</td>
									<td>Tokyo</td>
									<td>63</td>
									<td>2011/07/25</td>
									<td>$170,750</td>
								</tr>
								<tr>
									<td>Ashton Cox</td>
									<td>Junior Technical Author</td>
									<td>San Francisco</td>
									<td>66</td>
									<td>2009/01/12</td>
									<td>$86,000</td>
								</tr>
								<tr>
									<td>Cedric Kelly</td>
									<td>Senior Javascript Developer</td>
									<td>Edinburgh</td>
									<td>22</td>
									<td>2012/03/29</td>
									<td>$433,060</td>
								</tr>
								<tr>
									<td>Airi Satou</td>
									<td>Accountant</td>
									<td>Tokyo</td>
									<td>33</td>
									<td>2008/11/28</td>
									<td>$162,700</td>
								</tr>
								<tr>
									<td>Brielle Williamson</td>
									<td>Integration Specialist</td>
									<td>New York</td>
									<td>61</td>
									<td>2012/12/02</td>
									<td>$372,000</td>
								</tr>
								<tr>
									<td>Herrod Chandler</td>
									<td>Sales Assistant</td>
									<td>San Francisco</td>
									<td>59</td>
									<td>2012/08/06</td>
									<td>$137,500</td>
								</tr>
								<tr>
									<td>Rhona Davidson</td>
									<td>Integration Specialist</td>
									<td>Tokyo</td>
									<td>55</td>
									<td>2010/10/14</td>
									<td>$327,900</td>
								</tr>
								<tr>
									<td>Colleen Hurst</td>
									<td>Javascript Developer</td>
									<td>San Francisco</td>
									<td>39</td>
									<td>2009/09/15</td>
									<td>$205,500</td>
								</tr>
								<tr>
									<td>Sonya Frost</td>
									<td>Software Engineer</td>
									<td>Edinburgh</td>
									<td>23</td>
									<td>2008/12/13</td>
									<td>$103,600</td>
								</tr>
								<tr>
									<td>Jena Gaines</td>
									<td>Office Manager</td>
									<td>London</td>
									<td>30</td>
									<td>2008/12/19</td>
									<td>$90,560</td>
								</tr>
								<tr>
									<td>Quinn Flynn</td>
									<td>Support Lead</td>
									<td>Edinburgh</td>
									<td>22</td>
									<td>2013/03/03</td>
									<td>$342,000</td>
								</tr>
								<tr>
									<td>Charde Marshall</td>
									<td>Regional Director</td>
									<td>San Francisco</td>
									<td>36</td>
									<td>2008/10/16</td>
									<td>$470,600</td>
								</tr>
								<tr>
									<td>Haley Kennedy</td>
									<td>Senior Marketing Designer</td>
									<td>London</td>
									<td>43</td>
									<td>2012/12/18</td>
									<td>$313,500</td>
								</tr>
								<tr>
									<td>Tatyana Fitzpatrick</td>
									<td>Regional Director</td>
									<td>London</td>
									<td>19</td>
									<td>2010/03/17</td>
									<td>$385,750</td>
								</tr>
								<tr>
									<td>Michael Silva</td>
									<td>Marketing Designer</td>
									<td>London</td>
									<td>66</td>
									<td>2012/11/27</td>
									<td>$198,500</td>
								</tr>
								<tr>
									<td>Paul Byrd</td>
									<td>Chief Financial Officer (CFO)</td>
									<td>New York</td>
									<td>64</td>
									<td>2010/06/09</td>
									<td>$725,000</td>
								</tr>
								<tr>
									<td>Gloria Little</td>
									<td>Systems Administrator</td>
									<td>New York</td>
									<td>59</td>
									<td>2009/04/10</td>
									<td>$237,500</td>
								</tr>
								<tr>
									<td>Bradley Greer</td>
									<td>Software Engineer</td>
									<td>London</td>
									<td>41</td>
									<td>2012/10/13</td>
									<td>$132,000</td>
								</tr>
								<tr>
									<td>Dai Rios</td>
									<td>Personnel Lead</td>
									<td>Edinburgh</td>
									<td>35</td>
									<td>2012/09/26</td>
									<td>$217,500</td>
								</tr>
								<tr>
									<td>Jenette Caldwell</td>
									<td>Development Lead</td>
									<td>New York</td>
									<td>30</td>
									<td>2011/09/03</td>
									<td>$345,000</td>
								</tr>
								<tr>
									<td>Yuri Berry</td>
									<td>Chief Marketing Officer (CMO)</td>
									<td>New York</td>
									<td>40</td>
									<td>2009/06/25</td>
									<td>$675,000</td>
								</tr>
								<tr>
									<td>Caesar Vance</td>
									<td>Pre-Sales Support</td>
									<td>New York</td>
									<td>21</td>
									<td>2011/12/12</td>
									<td>$106,450</td>
								</tr>
								<tr>
									<td>Doris Wilder</td>
									<td>Sales Assistant</td>
									<td>Sidney</td>
									<td>23</td>
									<td>2010/09/20</td>
									<td>$85,600</td>
								</tr>
								<tr>
									<td>Angelica Ramos</td>
									<td>Chief Executive Officer (CEO)</td>
									<td>London</td>
									<td>47</td>
									<td>2009/10/09</td>
									<td>$1,200,000</td>
								</tr>
								<tr>
									<td>Gavin Joyce</td>
									<td>Developer</td>
									<td>Edinburgh</td>
									<td>42</td>
									<td>2010/12/22</td>
									<td>$92,575</td>
								</tr>
								<tr>
									<td>Jennifer Chang</td>
									<td>Regional Director</td>
									<td>Singapore</td>
									<td>28</td>
									<td>2010/11/14</td>
									<td>$357,650</td>
								</tr>
								<tr>
									<td>Brenden Wagner</td>
									<td>Software Engineer</td>
									<td>San Francisco</td>
									<td>28</td>
									<td>2011/06/07</td>
									<td>$206,850</td>
								</tr>
								<tr>
									<td>Fiona Green</td>
									<td>Chief Operating Officer (COO)</td>
									<td>San Francisco</td>
									<td>48</td>
									<td>2010/03/11</td>
									<td>$850,000</td>
								</tr>
								<tr>
									<td>Shou Itou</td>
									<td>Regional Marketing</td>
									<td>Tokyo</td>
									<td>20</td>
									<td>2011/08/14</td>
									<td>$163,000</td>
								</tr>
								<tr>
									<td>Michelle House</td>
									<td>Integration Specialist</td>
									<td>Sidney</td>
									<td>37</td>
									<td>2011/06/02</td>
									<td>$95,400</td>
								</tr>
								<tr>
									<td>Suki Burks</td>
									<td>Developer</td>
									<td>London</td>
									<td>53</td>
									<td>2009/10/22</td>
									<td>$114,500</td>
								</tr>
								<tr>
									<td>Prescott Bartlett</td>
									<td>Technical Author</td>
									<td>London</td>
									<td>27</td>
									<td>2011/05/07</td>
									<td>$145,000</td>
								</tr>
								<tr>
									<td>Gavin Cortez</td>
									<td>Team Leader</td>
									<td>San Francisco</td>
									<td>22</td>
									<td>2008/10/26</td>
									<td>$235,500</td>
								</tr>
								<tr>
									<td>Martena Mccray</td>
									<td>Post-Sales support</td>
									<td>Edinburgh</td>
									<td>46</td>
									<td>2011/03/09</td>
									<td>$324,050</td>
								</tr>
								<tr>
									<td>Unity Butler</td>
									<td>Marketing Designer</td>
									<td>San Francisco</td>
									<td>47</td>
									<td>2009/12/09</td>
									<td>$85,675</td>
								</tr>
								<tr>
									<td>Howard Hatfield</td>
									<td>Office Manager</td>
									<td>San Francisco</td>
									<td>51</td>
									<td>2008/12/16</td>
									<td>$164,500</td>
								</tr>
								<tr>
									<td>Hope Fuentes</td>
									<td>Secretary</td>
									<td>San Francisco</td>
									<td>41</td>
									<td>2010/02/12</td>
									<td>$109,850</td>
								</tr>
								<tr>
									<td>Vivian Harrell</td>
									<td>Financial Controller</td>
									<td>San Francisco</td>
									<td>62</td>
									<td>2009/02/14</td>
									<td>$452,500</td>
								</tr>
								<tr>
									<td>Timothy Mooney</td>
									<td>Office Manager</td>
									<td>London</td>
									<td>37</td>
									<td>2008/12/11</td>
									<td>$136,200</td>
								</tr>
								<tr>
									<td>Jackson Bradshaw</td>
									<td>Director</td>
									<td>New York</td>
									<td>65</td>
									<td>2008/09/26</td>
									<td>$645,750</td>
								</tr>
								<tr>
									<td>Olivia Liang</td>
									<td>Support Engineer</td>
									<td>Singapore</td>
									<td>64</td>
									<td>2011/02/03</td>
									<td>$234,500</td>
								</tr>
								<tr>
									<td>Bruno Nash</td>
									<td>Software Engineer</td>
									<td>London</td>
									<td>38</td>
									<td>2011/05/03</td>
									<td>$163,500</td>
								</tr>
								<tr>
									<td>Sakura Yamamoto</td>
									<td>Support Engineer</td>
									<td>Tokyo</td>
									<td>37</td>
									<td>2009/08/19</td>
									<td>$139,575</td>
								</tr>
								<tr>
									<td>Thor Walton</td>
									<td>Developer</td>
									<td>New York</td>
									<td>61</td>
									<td>2013/08/11</td>
									<td>$98,540</td>
								</tr>
								<tr>
									<td>Finn Camacho</td>
									<td>Support Engineer</td>
									<td>San Francisco</td>
									<td>47</td>
									<td>2009/07/07</td>
									<td>$87,500</td>
								</tr>
								<tr>
									<td>Serge Baldwin</td>
									<td>Data Coordinator</td>
									<td>Singapore</td>
									<td>64</td>
									<td>2012/04/09</td>
									<td>$138,575</td>
								</tr>
								<tr>
									<td>Zenaida Frank</td>
									<td>Software Engineer</td>
									<td>New York</td>
									<td>63</td>
									<td>2010/01/04</td>
									<td>$125,250</td>
								</tr>
								<tr>
									<td>Zorita Serrano</td>
									<td>Software Engineer</td>
									<td>San Francisco</td>
									<td>56</td>
									<td>2012/06/01</td>
									<td>$115,000</td>
								</tr>
								<tr>
									<td>Jennifer Acosta</td>
									<td>Junior Javascript Developer</td>
									<td>Edinburgh</td>
									<td>43</td>
									<td>2013/02/01</td>
									<td>$75,650</td>
								</tr>
								<tr>
									<td>Cara Stevens</td>
									<td>Sales Assistant</td>
									<td>New York</td>
									<td>46</td>
									<td>2011/12/06</td>
									<td>$145,600</td>
								</tr>
								<tr>
									<td>Hermione Butler</td>
									<td>Regional Director</td>
									<td>London</td>
									<td>47</td>
									<td>2011/03/21</td>
									<td>$356,250</td>
								</tr>
								<tr>
									<td>Lael Greer</td>
									<td>Systems Administrator</td>
									<td>London</td>
									<td>21</td>
									<td>2009/02/27</td>
									<td>$103,500</td>
								</tr>
								<tr>
									<td>Jonas Alexander</td>
									<td>Developer</td>
									<td>San Francisco</td>
									<td>30</td>
									<td>2010/07/14</td>
									<td>$86,500</td>
								</tr>
								<tr>
									<td>Shad Decker</td>
									<td>Regional Director</td>
									<td>Edinburgh</td>
									<td>51</td>
									<td>2008/11/13</td>
									<td>$183,000</td>
								</tr>
								<tr>
									<td>Michael Bruce</td>
									<td>Javascript Developer</td>
									<td>Singapore</td>
									<td>29</td>
									<td>2011/06/27</td>
									<td>$183,000</td>
								</tr>
								<tr>
									<td>Donna Snider</td>
									<td>Customer Support</td>
									<td>New York</td>
									<td>27</td>
									<td>2011/01/25</td>
									<td>$112,000</td>
								</tr>
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

			$('#example').DataTable();
		});
	</script>

<script src="assets/js/app.js"></script>
<script src="assets/js/lib/datatables-net/datatables.min.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
