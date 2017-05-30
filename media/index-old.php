<?php
	include "include/header.php";
	include 'include/Menu.php';
?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
			<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6" >
					<div style="position:fixed">
						<section class="box-typical" >
							<header class="box-typical-header-sm">
								Trending this week
								&nbsp;
								<a href="#" class="full-count">268</a>
							</header>
							<div class="friends-list">
								<article class="friends-list-item">
									<div class="user-card-row">
										<div class="tbl-row">
											
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="#">SMK</a></p>
												<!-- <p class="user-card-row-location">New York</p> -->
											</div>
										</div>
									</div>
								</article>
								<article class="friends-list-item">
									<div class="user-card-row">
										<div class="tbl-row">
											
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="#">Oykun Yilmaz</a></p>
												<!-- <p class="user-card-row-location">Los Angeles</p> -->
											</div>
										</div>
									</div>
								</article>
								<article class="friends-list-item">
									<div class="user-card-row">
										<div class="tbl-row">
											
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="#">Bill S Kenney</a></p>
												<!-- <p class="user-card-row-location">Cardiff</p> -->
											</div>
										</div>
									</div>
								</article>
								<article class="friends-list-item">
									<div class="user-card-row">
										<div class="tbl-row">
											
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="#">Maggy Smith</a></p>
												<!-- <p class="user-card-row-location">Dusseldorf</p> -->
											</div>
										</div>
									</div>
								</article>
								<article class="friends-list-item">
									<div class="user-card-row">
										<div class="tbl-row">
											
											<div class="tbl-cell">
												<p class="user-card-row-name"><a href="#">Dan Cederholm</a></p>
												<!-- <p class="user-card-row-location">New York</p> -->
											</div>
										</div>
									</div>
								</article>
							</div>
						</section><!--.box-typical-->
					</div>
				</div><!--.col- -->
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
									<div class="card-typical-section">
										<div class="user-card-row">
											<div class="tbl-row">
												<div class="tbl-cell tbl-cell-photo">
													<a href="#">
														<img src="Assets/img/avatar-1-64.png" alt="">
													</a>
												</div>
												<div class="tbl-cell">
													<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
													<p class="color-blue-grey-lighter">23 Januari 2017</p>
												</div>
												<div class="tbl-cell tbl-cell-status">
													<!-- <a href="#" class="font-icon font-icon-star"></a> -->
												</div>
											</div>
										</div>
									</div>
									<div class="card-typical-section card-typical-content">
										<div class="photo">
											<img src="Assets/img/gall-img-1.jpg" alt="">
										</div>
										<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
										<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow!</p>
									</div>
									<div class="card-typical-section">
										<div class="card-typical-linked">untuk <a href="#">SMK</a></div>
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
		</div>
	</div>

<?php
	include "Footer.php";
?>