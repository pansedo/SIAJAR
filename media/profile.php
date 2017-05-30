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

    $classKategori = new Kategori();
	$classMedia = new Media();

	$getkategoriutama = $classKategori->GetKategoriUtama();
	$getMedia = $classMedia->GetMediabyUser($id_users);
	$getMediaCount = $classMedia->GetMediabyUserCount($id_users);


    $classProfile = new Profile();
	$FuncProfile = $classProfile->GetData($id_users);

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
							<div class="profile-card-status"><?php echo $FuncProfile['sekolah'];?></div>
							<!-- <div class="profile-card-location">Asal Sekolah</div> -->
						</div>
						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
									<b><?php echo $getMediaCount; ?></b>
									Media Bahan Ajar
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
				<div >
				<?php
					$no = 1;
					if ($getMedia == 0) {
						# code...
						echo "Belum ada dokumen";
					}else{
					foreach ($getMedia as $data) {
				?>
					<div class="col-lg-4 col-lg-pull-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
						<div class="card-grid-col">
							<article class="card-typical">
								<div class="card-typical-section card-typical-content">
									<div class="photo">
										<img src="<?php echo $data['path_image']; ?>" alt="">
									</div>
									<header class="title"><a href="product.php?id=<?php echo base64_encode($data['_id']);?>"><?php echo $data['judul']; ?></a></header>
									<p><?php echo substr($data['deskripsi'], 0, 100)."..."; ?></p>
								</div>
								<div class="card-typical-section">
									<div class="card-typical-linked">in <a href="#"><?php echo $data['nama_user']; ?></a></div>
									<a class="btn btn-sm btn-success card-typical-likes" href="media.php?action=edit&id=<?php echo base64_encode($data['_id']);?>" class="card-typical-likes">
										<i class="font-icon font-icon-pencil"></i>										
									</a>
									<!-- <form action="" method="POST"> -->
										<button class="btn btn-sm btn-danger card-typical-likes" onclick="myFunction('<?php echo base64_encode($data['_id']);?>')" href="?action=hapus" >
											<i class="font-icon font-icon-trash"></i>										
										</button>
									<!-- </form> -->
								</div>
							</article>
						</div>
					</div>
				<?php
					}
				}
				?>
				<!-- Selesai Buku Content -->
				</div>
				<div class="col-lg-12" align="center">
					<?php
						$classMedia->paggingByUser($id_users, isset($_GET['page']) ? $_GET['page'] : 1);
					?>
				</div>
				<!-- <button class="btn btn-primary" onclick="myFunction()">Test</button> -->
				</div>
				
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->
	<script type="text/javascript">
		function myFunction(id) {
		   swal({
		      title: 'Anda yakin ingin menghapus media ini?',
		      text: 'File akan dihapus secara permanen dari sistem ini !',
		      type: 'warning',
		      showCancelButton: true,
		      confirmButtonColor: '#3085d6',
		      cancelButtonColor: '#d33',
		      confirmButtonText: 'Iya, Hapus Sekarang!',
		      cancelButtonText: 'Tidak, Batalkan!',
		      confirmButtonClass: 'btn btn-success',
		      cancelButtonClass: 'btn btn-danger',
		      buttonsStyling: false
		    }).then(function () {
		      // swal('Terhapus!', 'Your file has been deleted!', 'success');
		      document.location.href='media.php?action=hapus&id='+id;
		    }, function (dismiss) {
		      // dismiss can be 'cancel', 'overlay', 'close', 'timer'
		      if (dismiss === 'cancel') {
		        swal('Dibatalkan', 'File anda masih tersedia di sistem ini', 'error')
		      }
		    }
  			);

		}
		</script>

<?php
	include "include/footer.php";
?>