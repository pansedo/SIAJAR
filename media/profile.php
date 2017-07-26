<?php
	include "include/header.php";
	include 'include/menu.php';

	if (!isset($_SESSION['lms_id']) && !isset($_SESSION['lms_username']) && !isset($_SESSION['lms_status'])) {
        
    }else{ 
        set_time_limit(10000); 
        $id_users   = $_SESSION['lms_id'];
        $email    = $_SESSION['lms_username'];
        $status     = $_SESSION['lms_status'];

    }

    $classKategori = new Kategori();
	$classMedia = new Media();

	$getkategoriutama = $classKategori->GetKategoriUtama();
	
	


    $classProfile = new Profile();
    if (isset($_GET['id'])) {
    	# code...
    	$FuncProfile = $classProfile->GetData($_GET['id']);
    	$getMedia = $classMedia->GetMediabyUser($_GET['id']);
    	$getMediaCount = $classMedia->GetMediabyUserCount($_GET['id']);
    }else if (isset($id_users)) {
    	# code...
    	$FuncProfile = $classProfile->GetData($id_users);
		$getMedia = $classMedia->GetMediabyUser($id_users);
		$getMediaCount = $classMedia->GetMediabyUserCount($id_users);
    }else{
    	header("Location:index.php");
        exit();
		
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
						$date = date_create($data['date_created']);
				?>
					<div class="col-lg-4 col-lg-pull-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
						<!-- <div class="card-grid-col"> -->
							<article class="card-typical">
								<div class="card-typical-section" style="height:80px">
									<div class="user-card-row">
										<div class="tbl-row">
											<div class="tbl-cell tbl-cell-photo">
												<a href="#">
													<img  src="Assets/foto/<?php if ($data['foto'] != NULL) {echo $data['foto'];}else{echo "no_picture.png";} ?>" alt="">
												</a>
											</div>
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="product.php?id=<?php echo base64_encode($data['_id']);?>"><?php echo $data['judul']; ?></a></p>
												<p class="color-blue-grey-lighter"><?php echo selisih_waktu(date_format($date,'d-m-Y H:i:s'));?></p>
											</div>
											
										</div>
									</div>
								</div>
								<div class="card-typical-section card-typical-content">
									<!-- <div class="photo" style="min-width: 200px; height:300px; background-image:url('<?php// echo $data['path_image']; ?>'; position: center center"> -->
									 <div class="photo" > 
										<a href="product.php?id=<?php echo base64_encode($data['_id']);?>"><img style="  min-width: 200px; height:350px; background:<?php echo $data['path_image']; ?>" src="<?php echo $data['path_image']; ?>"  alt=""></a>
									</div>
									<header class="title"><a href="#"></a></header>
									<p><?php //echo substr($data['deskripsi'], 0, 30)."..."; ?></p>
								</div>
								<div class="card-typical-section">
									<div class="card-typical-linked" style="height:33px">oleh <a href="#"><?php echo $data['nama_user']; ?></a></div>
									
									<div class="tbl-cell tbl-cell-status" style="float:right">
									<?php 
										if (isset($id_users)){ if ($id_users == $data['id_user']) {
											# code...
										
									?>		
										<a href="media.php?action=edit&id=<?php echo base64_encode($data['_id']);?>" class="font-icon font-icon-pencil"></a>
										<a href="media.php?action=edit&id=<?php echo base64_encode($data['_id']);?>" class="font-icon font-icon-trash "></a>
									<?php } 
									}?>
									</div>
									<!-- <a href="#" class="card-typical-likes">
										<i class="font-icon font-icon-heart"></i>
										123
									</a> -->
								</div>
							</article><!--.card-typical-->
						<!-- </div> -->
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