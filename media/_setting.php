<?php
	include "header.php";

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
?> 
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
					<section class="box-typical">
						<div class="profile-card">
							<div class="profile-card-photo">
								<img src="Assets/img/photo-220-1.jpg" alt=""/>
							</div>
							<div class="profile-card-name"><?php echo $FuncProfile['nama'];?></div>
							<div class="profile-card-status"><?php echo $FuncProfile['sekolah'];?></div>
							<div class="profile-card-location">Asal Sekolah</div>
							<button type="button" class="btn btn-rounded">Follow</button>
							<button type="button" class="btn btn-danger btn-rounded">Wishlist</button>
						</div>

						<div class="profile-statistic tbl">
							<div class="tbl-row">
								<div class="tbl-cell">
									<b>200</b>
									Connections
								</div>
								<div class="tbl-cell">
									<b>57</b>
									Books
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
								<i class="font-icon font-icon-in-fill"></i>
								<a href="#"><?php echo $FuncProfile['sosmed']['linkedin'];?></a>
							</li>
							<li class="nowrap">
								<i class="font-icon font-icon-tw-fill"></i>
								<a href="#"><?php echo $FuncProfile['sosmed']['twitter'];?></a>
							</li>
						</ul>
					</section>

					<section class="box-typical">
						<header class="box-typical-header-sm">
							Friends
							&nbsp;
							<a href="#" class="full-count">268</a>
						</header>
						<div class="friends-list">
							<article class="friends-list-item">
								<div class="user-card-row">
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-photo">
											<a href="#">
												<img src="Assets/img/photo-64-2.jpg" alt="">
											</a>
										</div>
										<div class="tbl-cell">
											<p class="user-card-row-name status-online"><a href="#">Dan Cederholm</a></p>
											<p class="user-card-row-location">New York</p>
										</div>
									</div>
								</div>
							</article>
							<article class="friends-list-item">
								<div class="user-card-row">
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-photo">
											<a href="#">
												<img src="Assets/img/photo-64-1.jpg" alt="">
											</a>
										</div>
										<div class="tbl-cell">
											<p class="user-card-row-name"><a href="#">Oykun Yilmaz</a></p>
											<p class="user-card-row-location">Los Angeles</p>
										</div>
									</div>
								</div>
							</article>
							<article class="friends-list-item">
								<div class="user-card-row">
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-photo">
											<a href="#">
												<img src="Assets/img/photo-64-3.jpg" alt="">
											</a>
										</div>
										<div class="tbl-cell">
											<p class="user-card-row-name"><a href="#">Bill S Kenney</a></p>
											<p class="user-card-row-location">Cardiff</p>
										</div>
									</div>
								</div>
							</article>
							<article class="friends-list-item">
								<div class="user-card-row">
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-photo">
											<a href="#">
												<img src="Assets/img/photo-64-4.jpg" alt="">
											</a>
										</div>
										<div class="tbl-cell">
											<p class="user-card-row-name"><a href="#">Maggy Smith</a></p>
											<p class="user-card-row-location">Dusseldorf</p>
										</div>
									</div>
								</div>
							</article>
							<article class="friends-list-item">
								<div class="user-card-row">
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-photo">
											<a href="#">
												<img src="Assets/img/photo-64-2.jpg" alt="">
											</a>
										</div>
										<div class="tbl-cell">
											<p class="user-card-row-name"><a href="#">Dan Cederholm</a></p>
											<p class="user-card-row-location">New York</p>
										</div>
									</div>
								</div>
							</article>
						</div>
					</section>
				</div>
				<div class="col-lg-9 col-lg-pull-6 col-md-6 col-sm-6">
				<!-- Mulai Buku Content -->
				<?php
					$x = 1;
					while($x <= 10){
					$x++;
				?>
					<div class="col-lg-4 col-lg-pull-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
						<div class="card-grid-col">
							<article class="card-typical">
								<div class="card-typical-section card-typical-content">
									<div class="photo">
										<img src="Assets/img/gall-img-1.jpg" alt="">
									</div>
									<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
									<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow!</p>
								</div>
								<div class="card-typical-section">
									<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
									<a href="#" class="card-typical-likes">
										<i class="font-icon font-icon-heart"></i>
										123
									</a>
								</div>
							</article>
						</div>
					</div>
				<?php
					}
				?>
				<!-- Selesai Buku Content -->
				</div>
				
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	include "Footer.php";
?>