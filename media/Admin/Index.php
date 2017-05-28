<?php
	include 'header.php';
	include 'menu.php';

	$classMedia = new Media();
	$datamedialimit = $classMedia->GetMediaByLimit(10);
	$datacount = $classMedia->GetCountData();
?>

	<div class="page-content">
	   <div class="container-fluid">
	        <div class="row">
	        	<div class="col-xl-6">
	                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
	                   <table id="table-edit" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th width="1%">No</th>
							<th width="25%">User</th>
							<th width="50%">Judul</th>
							<th width="10%">Kategori</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						$i = 1;
							foreach ($datamedialimit as $datamedia) {
						?>
							<tr>
								<td><?php echo $i; $i++ ?></td>
								<td><?php echo $datamedia['nama_user'] ?></td>
								<td><?php echo $datamedia['judul'] ?></td>
								<td><?php echo $datamedia['kategori'] ?></td>
							</tr>
						<?php
						}
						?>
						</tbody>
					</table>
		        </section><!--.box-typical-dashboard-->
	            </div><!--.col-->
	            <div class="col-xl-6">
	                <div class="row">
	                    <div class="col-sm-6">
	                        <article class="statistic-box red">
	                            <div>
	                                <div class="number"><?php echo $datacount['dokumen']; ?></div>
	                                <div class="caption"><div>Media</div></div>
	                                 <div class="percent">
	                                    <div class="arrow up"></div>
	                                </div>	
	                            </div>
	                        </article>
	                    </div><!--.col-->
	                    <div class="col-sm-6">
	                        <article class="statistic-box purple">
	                            <div>
	                                <div class="number"><?php echo $datacount['tag']; ?></div>
	                                <div class="caption"><div>Hastag</div></div>
	                                 <div class="percent">
	                                    <div class="arrow up"></div>
	                                </div>
	                            </div>
	                        </article>
	                    </div><!--.col-->
	                    <div class="col-sm-6">
	                        <article class="statistic-box yellow">
	                            <div>
	                                <div class="number"><?php echo $datacount['kategori']; ?></div>
	                                <div class="caption"><div>Kategori</div></div>
	                                 <div class="percent">
	                                    <div class="arrow up"></div>
	                                </div>
	                            </div>
	                        </article>
	                    </div><!--.col-->
	                    <div class="col-sm-6">
	                        <article class="statistic-box green">
	                            <div>
	                                <div class="number"><?php echo $datacount['user']; ?></div>
	                                <div class="caption"><div>Users</div></div>
	                                <div class="percent">
	                                    <div class="arrow up"></div>
	                                </div>
	                            </div>
	                        </article>
	                    </div><!--.col-->
	                </div><!--.row-->
	            </div><!--.col-->
	            <div class="col-xl-6">
	        <!--     <section class="box-typical box-typical-dashboard panel panel-default scrollable">
	                    <header class="box-typical-header panel-heading">
	                        <h3 class="panel-title">Comments</h3>
	                    </header>
	                    <div class="box-typical-body panel-body">
	                        <article class="comment-item">
	                            <div class="user-card-row">
	                                <div class="tbl-row">
	                                    <div class="tbl-cell tbl-cell-photo">
	                                        <a href="#">
	                                            <img src="img/photo-64-1.jpg" alt="">
	                                        </a>
	                                    </div>
	                                    <div class="tbl-cell">
	                                        <span class="user-card-row-name"><a href="#">Matt McGill</a></span>
	                                    </div>
	                                    <div class="tbl-cell tbl-cell-date">
	                                        <span class="semibold">Today</span>
	                                        12:45
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="comment-item-txt">
	                                <p>That’s a great idea! I’m sure we could start this project as soon as possible.</p>
	                                <p>Let’s meet tomorow!</p>
	                            </div>
	                            <div class="comment-item-meta">
	                                <a href="#" class="star">
	                                    <i class="font-icon font-icon-star"></i>
	                                </a>
	                                <a href="#">
	                                    <i class="font-icon font-icon-re"></i>
	                                </a>
	                            </div>
	                        </article>
	                        <article class="comment-item">
	                            <div class="user-card-row">
	                                <div class="tbl-row">
	                                    <div class="tbl-cell tbl-cell-photo">
	                                        <a href="#">
	                                            <img src="img/photo-64-2.jpg" alt="">
	                                        </a>
	                                    </div>
	                                    <div class="tbl-cell">
	                                        <span class="user-card-row-name"><a href="#">Tim Collins</a></span>
	                                    </div>
	                                    <div class="tbl-cell tbl-cell-date">
	                                        <span class="semibold">Today</span>
	                                        12:45
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="comment-item-txt">
	                                <p>That’s a great idea! I’m sure we could start this project as soon as possible.</p>
	                                <p>Let’s meet tomorow!</p>
	                            </div>
	                            <div class="comment-item-meta">
	                                <a href="#" class="star active">
	                                    <i class="font-icon font-icon-star"></i>
	                                </a>
	                                <a href="#">
	                                    <i class="font-icon font-icon-re"></i>
	                                </a>
	                            </div>
	                        </article>
	                    </div>
	            </section> -->
	            </div>
	        </div>
	    </div>
	</div>

<?php
	include 'footer.php';
?>