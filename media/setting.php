<?php
	include "include/header.php";
	include 'include/menu.php';

	if (!isset($_SESSION['lms_id']) && !isset($_SESSION['lms_username']) && !isset($_SESSION['lms_status'])) {
        header("Location:Auth/logout.php");
        exit();
    }else{ 
        set_time_limit(10000); 
        $id_users   = $_SESSION['lms_id'];
        $email    = $_SESSION['lms_username'];
        $status     = $_SESSION['lms_status'];
    }

    $classProfile = new Profile();
	$FuncProfile = $classProfile->GetData($id_users);

	if (isset($_POST['simpan_profil'])) {
		# code...
		$id_profile 	= $id_users;
		$username 		= $FuncProfile['username'];
		$password 		= $FuncProfile['password'];
		// $username 		= "fai19";
		$nama 			= $_POST['nama'];
		$email 			= $_POST['email'];
		$jenis_kelamin 	= $_POST['jenis_kelamin'];
		$sekolah 		= $_POST['instansi'];
		$status 		= $FuncProfile['status'];
		// $status 		= "guru";
		if ($_FILES['foto']['name'] != NULL) {
			# code...
			$foto 		= $_FILES['foto']['name'];
			$foto_size 	= $_FILES['foto']['size'];
			$foto_tmp 	= $_FILES['foto']['tmp_name'];
			$foto_ext	= pathinfo($foto,PATHINFO_EXTENSION);
			$foto_lama	= $FuncProfile['foto'];

			$classProfile->UpdateProfileFoto($id_profile, $password,$username,$nama,$email,$jenis_kelamin,$sekolah,$status,$foto,$foto_size,$foto_tmp,$foto_ext,$foto_lama);
		
		}else{
			$foto = $FuncProfile['foto'];
			$classProfile->UpdateProfile($id_profile, $password,$username,$nama,$email,$jenis_kelamin,$sekolah,$status,$foto);
		}
			
	}

	if (isset($_POST['simpan_sosmed'])) {
		# code...
		$id_profile 	= $id_users;
		$website 		= $_POST['website'];
		$facebook		= $_POST['facebook'];
		$linkedin 		= $_POST['linkedin'];
		$twitter 		= $_POST['twitter'];

		$classProfile->UpdateSosmed($id_profile, $website,$facebook,$linkedin,$twitter);
	}

	if (isset($_POST['simpan_password'])) {
		# code...
		$id_profile 	= $id_users;
		$username 		= $FuncProfile['username'];
		$password 		= $_POST['p_lama'];
		$password_baru 	= $_POST['p_baru'];
		$password_confirm= $_POST['p_baru2'];


		$nama 			= $FuncProfile['nama'];
		$email 			= $FuncProfile['email'];
		$jenis_kelamin 	= $FuncProfile['jk'];
		$sekolah 		= $FuncProfile['sekolah'];
		$status 		= $FuncProfile['status'];
		$foto 			= $FuncProfile['foto'];

		$classProfile->CheckPassword($id_profile, $password, $password_baru, $password_confirm,$username,$nama,$email,$jenis_kelamin,$sekolah,$status,$foto);
	}
?> 
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
					<section class="box-typical">
						<div class="profile-card ">
							<div class="profile-card-photo">
								<img src="Assets/foto/<?php if ($FuncProfile['foto'] != NULL) {echo $FuncProfile['foto'];}else{echo "no_picture.png";} ?>" alt=""/>
							</div>
							<div class="profile-card-name"><?php echo $FuncProfile['nama'];?></div>
							<div class="profile-card-status"><?php echo $FuncProfile['status'];?></div>
							<!-- <div class="profile-card-location">Asal Sekolah</div> -->
						</div>
						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
									<?php if (isset($getMediaCount)){ echo '<b>'. $getMediaCount.' 
									Media Bahan Ajar</b>';}?>
								</div>
							</div>
						</div>

						<ul class="profile-links-list">
							<li class="nowrap">
								<i class="font-icon font-icon-earth-bordered"></i> 
								<a href="#"><?php echo $FuncProfile['sosmed']['website'];?></a>
							</li>
							<li class="nowrap">
								<i class="font-icon font-icon-fb-fill"></i> 
								<a href="#"><?php echo $FuncProfile['sosmed']['facebook'];?></a>
							</li>
							<li class="nowrap">
								<i class="font-icon font-icon-calend"></i> 
								<a href="#"><?php echo selisih_waktu($FuncProfile['date_created']);?></a>
							</li> 
							 
						</ul>
					</section>
				
				</div>
				<div class="col-lg-9 col-lg-pull-6 col-md-6 col-sm-6">
				<!-- Mulai Buku Content -->
				<section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-inline">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" href="#tab-1" role="tab" data-toggle="tab" aria-expanded="false">
								Profil
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tab-2" role="tab" data-toggle="tab" aria-expanded="false">
								Sosial Media
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tab-3" role="tab" data-toggle="tab" aria-expanded="false">
								Kata Sandi
							</a>
						</li>
						
					</ul>
				</div><!--.tabs-section-nav-->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="tab-1" aria-expanded="false">
						<h5 class="m-t-lg with-border">Profil Anda</h5>
						<form method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-6">
									<fieldset class="form-group">
										<div class="profile-card col-lg-6">
										<div class="profile-card-photo">
											<img src="Assets/foto/<?php if ($FuncProfile['foto'] != NULL) {echo $FuncProfile['foto'];}else{echo "no_picture.png";} ?>" alt=""/>
										</div>
										</div>
										<input type="file" name="foto" class="form-control" id="exampleInput" placeholder="Nama Lengkap" >
										
									</fieldset>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									 <fieldset class="form-group">
										<label class="form-label semibold" for="exampleInputEmail1">Nama Lengkap</label>
										<input type="text" name="nama" class="form-control" id="exampleInput" placeholder="Nama Lengkap" value="<?php echo $FuncProfile['nama'];?>">
										<small class="text-muted">We'll never share your email with anyone else.</small>
									</fieldset>
								</div>
								<div class="col-lg-6">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInputEmail1">Email</label>
										<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo $FuncProfile['email'];?>">
									</fieldset>
								</div>
								
							</div>
							<div class="row">
								<div class="col-lg-6">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInput">Jenis Kelamin</label>
										<select id="exampleSelect" name="jenis_kelamin" class="form-control">
											<option value="">Pilih Salah Satu </option>
											<option value="Laki-laki" <?php if ($FuncProfile['jk'] == "Laki-laki") { echo "selected";}?>>Laki-laki</option>
											<option value="Perempuan" <?php if ($FuncProfile['jk'] == "Perempuan") { echo "selected";}?>>Perempuan</option>
										</select>
										
									</fieldset>
								</div>
								<div class="col-lg-6">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInputEmail1">Instansi/Sekolah</label>
										<input type="text" name="instansi" class="form-control" value="<?php echo $FuncProfile['sekolah'];?>"  placeholder="Instansi" >
									</fieldset>
								</div>
								
							</div>
							
							<button type="submit" name="simpan_profil" class="btn">Simpan</button>
						</form>
					</div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tab-2" aria-expanded="false">
					<h5 class="with-border m-t-lg">Sosial Media</h5>
					<form action="" method="POST">
						<div class="form-group">
							<label class="form-label" for="hide-show-password">Website</label>
							<div class="input-append input-group"><input type="text" name="website" class="form-control" placeholder="Website"></div>
						</div>
						<div class="form-group">
							<label class="form-label" for="hide-show-password">Facebook</label>
							<div class="input-append input-group"><input type="text" name="facebook" class="form-control" placeholder="Facebook"></div>
						</div>						
						<div class="form-group">
							<label class="form-label" for="hide-show-password">Linkedin</label>
							<div class="input-append input-group"><input type="text" name="linkedin" class="form-control" placeholder="Linkedin"></div>
						</div>
						<div class="form-group">
							<label class="form-label" for="hide-show-password">Twitter</label>
							<div class="input-append input-group"><input type="text" name="twitter" class="form-control" placeholder="Twitter"></div>
						</div>
						<button type="submit" name="simpan_sosmed" class="btn">Simpan</button>
					</form>
					</div><!--.tab-Ubah Password-->
					<div role="tabpanel" class="tab-pane fade" id="tab-3" aria-expanded="false">
					<form action="" method="POST">
						<h5 class="with-border m-t-lg">Ubah Kata Sandi</h5>
						<div class="form-group">
							<label class="form-label" for="hide-show-password">Kata sandi Lama</label>
							<div class="input-append input-group"><input type="password" name="p_lama" class="form-control" placeholder="Kata Sandi Lama"></div>
						</div>
						<div class="form-group">
							<label class="form-label" for="hide-show-password">Kata Sandi Baru</label>
							<div class="input-append input-group"><input type="password" name="p_baru" class="form-control" placeholder="Kata Sandi Baru"></div>
						</div>						
						<div class="form-group">
							<label class="form-label" for="hide-show-password">Ulangi Kata Sandi Baru</label>
							<div class="input-append input-group"><input type="password" name="p_baru2" class="form-control" placeholder="Ulangi Kata Sandi Baru"></div>
						</div>
						<button type="submit" name="simpan_password" class="btn">Simpan</button>
					</form>			
					</div><!--.tab-pane-->
				</div><!--.tab-content-->
			</section>
				<!-- Selesai Buku Content -->
				</div>
				
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	include "include/footer.php";
?>