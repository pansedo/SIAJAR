<?php
require("includes/header-top.php");
require("includes/header-menu.php");

$userClass	= new User();
$profilClass = new Profile();
$ProvkotClass = new Provkot();

$userProfil	= $userClass->GetData($_SESSION['lms_id']);
if (isset($userProfil['kota']) || !empty($userProfil['kota'])) {
	$getKota = $ProvkotClass->getKota((int)$userProfil['kota']);
	$asalKota = $getKota['nama_kab_kot'];
}
?>

	<div class="page-content">
		<div class="profile-header-photo">
			<div class="profile-header-photo-in">
				<div class="tbl-cell">
					<div class="info-block">
						<div class="container-fluid">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<div class="tbl info-tbl">
										<div class="tbl-row">
											<div class="tbl-cell">
												<p class="title"><?=$_SESSION['lms_name']?></p>
												<p><?=ucfirst($_SESSION['lms_status'])?></p>
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
					<aside id="menu-fixed2" class="profile-side">
						<section class="box-typical profile-side-user">
							<button type="button" class="avatar-preview avatar-preview-128">
								<img src="media/Assets/foto/<?php if ($FuncProfile['foto'] != NULL) {echo $FuncProfile['foto'];}else{echo "no_picture.png";} ?>" alt=""/>
							</button>
							<button type="button" id="ohyeah" class="btn btn-rounded"><?=$_SESSION['lms_status'] == 'guru' ? 'Kirim Pesan' : '<span data-toggle="modal" data-target="#joinKelas"><i class="font-icon font-icon-user"></i> Gabung Kelas</span>'; ?></button>

						</section>
						<?php
						if(strtolower($_SESSION['lms_status']) == 'siswa'){
						echo '
							<section class="box-typical profile-side-stat">
								<div class="tbl">
									<div class="tbl-row">
										<div class="tbl-cell">
											<span class="number" id="jmlKelas">0</span>
											kelas yang diikuti
										</div>
									</div>
								</div>
							</section>';
						}elseif (strtolower($_SESSION['lms_status']) == 'guru') {
							echo '<section class="box-typical profile-side-stat">
								<header class="box-typical-header-sm bordered">Mengampu</header>
								<div class="tbl">
									<div class="tbl-row">
										<div class="tbl-cell">
											<span class="number" id="jmlKelas">0</span>
											Kelas
										</div>
									</div>
								</div>
							</section>';
						}
						?>

						<!-- <section class="box-typical">
							<header class="box-typical-header-sm bordered">Tentang Saya</header>
							<div class="box-typical-inner">
								<p>
									<ul style="list-style-type: circle;margin-left: 20px;">
										<li>Simple</li>
										<li>Pekerja Keras</li>
										<li>Periang</li>
										<li>Rajin Olahraga</li>
									</ul>
								</p>
							</div>
						</section> -->

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">Info</header>
							<div class="box-typical-inner">
								<?php echo (isset($userProfil['kota']) && !empty($userProfil['kota'])) ? '
								<p class="line-with-icon">
									<i class="font-icon font-icon-pin-2"></i>
									<a href="#">'.$asalKota.'</a>
								</p>' : '';
								?>
								<?php echo (isset($userProfil['sekolah']) && !empty($userProfil['sekolah'])) ? '
								<p class="line-with-icon">
									<i class="font-icon font-icon-users-two"></i>
									<a href="#"> '.$userProfil['sekolah'].'</a>
								</p>' : '';
								?>
								<p class="line-with-icon">
									<i class="font-icon font-icon-user"></i>
									<?=ucfirst($_SESSION['lms_status'])?>
								</p>
								<?php echo (isset($userProfil['sosmed']['facebook']) && !empty($userProfil['sosmed']['facebook'])) ? '
								<p class="line-with-icon">
									<i class="font-icon font-icon-facebook"></i>
									<a href="#"> '.$userProfil['sosmed']['facebook'].'</a>
								</p>' : '';
								?>
								<?php echo (isset($userProfil['sosmed']['website']) && !empty($userProfil['sosmed']['website'])) ? '
								<p class="line-with-icon">
									<i class="font-icon font-icon-earth"></i>
									<a href="#"> '.$userProfil['sosmed']['website'].'</a>
								</p>' : '';
								?>
								<p class="line-with-icon">
									<i class="font-icon font-icon-calend"></i>
									Bergabung <?=selisih_waktu($userProfil['date_created'])?>
								</p>
							</div>
						</section>

						<section class="box-typical">
							<header class="box-typical-header-sm bordered">
								Daftar Kelas
								<div class="btn-group" style='float: right;'>
									<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Aksi
									</button>
									<div class="dropdown-menu" style="margin-left: -100px">
										<?php
										if (strtolower($_SESSION['lms_status']) == 'guru') {
											echo '
												<a class="dropdown-item" href="#" data-toggle="modal" data-target="#addKelas"><span class="font-icon font-icon-plus"></span>Tambah Kelas</a>
				                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-pencil"></span>Kelola Kelas</a>';
										}
										?>
		                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#joinKelas"><span class="font-icon font-icon-user"></span>Gabung Kelas</a>
									</div>
								</div>
							</header>
							<div class="box-typical-inner" id="listKelas">
								<p style="text-align: center;">
									Menunggu..
								</p>
							</div>
						</section>

					</aside><!--.profile-side-->
				</div>

				<div class="col-xl-9 col-lg-8">
					<section class="tabs-section">

						<div class="tab-content no-styled profile-tabs">

							<?php
								$listPosting	= $kelasClass->postingSeluruh($_SESSION['lms_id']);

								if ($listPosting['count'] > 0) {
									foreach ($listPosting['data'] as $posting) {
										$image		= empty($posting['user_foto']) ? "<img src='assets/img/avatar-2-128.png' style='max-width: 75px; max-height: 75px;' />" : "<img src='".$infoUser['foto']."' style='max-width: 75px; max-height: 75px;' />" ;
										echo '	<article class="box-typical profile-post">
													<div class="profile-post-header">
														<div class="user-card-row">
															<div class="tbl-row">
																<div class="tbl-cell tbl-cell-photo">
																	<a href="#">'.$image.'</a>
																</div>
																<div class="tbl-cell">
																	<div class="user-card-row-name"><a href="#"><b>'.$posting['user'].'</b></a> &nbsp; <i class="fa fa-play" style="font-size: 70%; display: inline-block;"></i> &nbsp; <a href="kelas.php?id='.$posting['id_kelas'].'"><b>'.$posting['kelas'].'</b></a></div>
																	<div class="color-blue-grey-lighter">'.selisih_waktu($posting['date_created']).'</div>
																</div>
															</div>
														</div>';
														if ($_SESSION['lms_id'] == $posting['creator']) {
														echo '		<a class="shared" onclick="removePost(\''.$posting['_id'].'\')" title="Hapus" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Tombol untuk menghapus Kiriman yang sudah dibuat.">
																		<i class="font-icon font-icon-trash"></i>
																	</a>';
														}
										echo '		</div>
													<div class="profile-post-content">
														<p>
															'.nl2br($posting['isi_postingan']).'
														</p>
													</div>
												</article>';
									}
								}else {
									echo '	<article class="box-typical profile-post">
												<div class="profile-post-content">
													<p align="center">
													 Belum ada Postingan saat ini.
													</p>
												</div>
											</article>';
								}
							?>

						</div><!--.tab-content-->
					</section><!--.tabs-section-->
				</div>
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	require('includes/footer-top.php');
?>

	<script>
		function removePost(ID){
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
					url: 'url-API/Kelas/Posting/',
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
			$.ajax({
				type: 'POST',
				url: 'url-API/Kelas/',
				data: {"action": "showList", "ID": "<?=$_SESSION['lms_id']?>"},
				success: function(res) {
					$('#listKelas').html('');
					$('#jmlKelas').html(res.data.length);
					if(res.data.length > 0){
						for(i=0; i<=res.data.length; i++){
							$('#listKelas').append('<p class="line-with-icon">'+
									'<i class="font-icon font-icon-folder"></i>'+
									'<a href="kelas.php?id='+res.data[i]._id.$id+'">'+res.data[i].nama+'</a>'+
								'</p>');
						}
					}else{
						$('#listKelas').append('<p style="text-align:center;">'+
									'Belum ada Kelas'+
								'</p>');
					}
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					// console.log('ERROR !');
					 alert(textStatus);
				}
			});

			$(".fancybox").fancybox({
				padding: 0,
				openEffect	: 'none',
				closeEffect	: 'none'
			});

		});
		// error gara-gara  'sudo /edx/bin/update edx-platform master'
	</script>

	<script src="assets/js/app.js"></script>
<?php
	require('includes/footer-bottom.php');
?>
