<?php
	include 'header.php';
	include 'menu.php';

	$classMedia = new Media();
?>

	<div class="page-content">
	   <div class="container-fluid">
	        <div class="row">
	        	<div class="col-xl-6">
	                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
	                   <table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>
					<th width="1">
						#
					</th>
					<th>Name</th>
					<th>Description</th>
					<th class="table-icon-cell">
						<i class="font-icon font-icon-heart"></i>
					</th>
					<th class="table-icon-cell">
						<i class="font-icon font-icon-comment"></i>
					</th>
					<th width="120">Date Created</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Last quarter revene</td>
						<td class="color-blue-grey-lighter">Revene for last quarter in state America for year 2013, whith...</td>
						<td class="table-icon-cell">5</td>
						<td class="table-icon-cell">24</td>
						<td class="table-date">6 minets ago</td>
						<td class="table-photo">
							<img src="img/photo-64-1.jpg" alt="" data-toggle="tooltip" data-placement="bottom" title="Nicholas<br/>Barrett">
						</td>
					</tr>
					
				</tbody>
			</table>
	                </section><!--.box-typical-dashboard-->
	                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
	                    <header class="box-typical-header panel-heading">
	                        <h3 class="panel-title">Contacts</h3>
	                    </header>
	                    <div class="box-typical-body panel-body">
	                        <div class="contact-row-list">
	                            <article class="contact-row">
	                                <div class="user-card-row">
	                                    <div class="tbl-row">
	                                        <div class="tbl-cell tbl-cell-photo">
	                                            <a href="#">
	                                                <img src="img/photo-64-2.jpg" alt="">
	                                            </a>
	                                        </div>
	                                        <div class="tbl-cell">
	                                            <p class="user-card-row-name"><a href="#">Tim Collins</a></p>
	                                            <p class="user-card-row-mail"><a href="#">timcolins@mail.com</a></p>
	                                        </div>
	                                        <div class="tbl-cell tbl-cell-status">Director at Tony’s</div>
	                                    </div>
	                                </div>
	                            </article>
	                            <article class="contact-row">
	                                <div class="user-card-row">
	                                    <div class="tbl-row">
	                                        <div class="tbl-cell tbl-cell-photo">
	                                            <a href="#">
	                                                <img src="img/photo-64-1.jpg" alt="">
	                                            </a>
	                                        </div>
	                                        <div class="tbl-cell">
	                                            <p class="user-card-row-name"><a href="#">Maggy Smith</a></p>
	                                            <p class="user-card-row-mail"><a href="#">maggysmith@mail.com</a></p>
	                                        </div>
	                                        <div class="tbl-cell tbl-cell-status">PR Manager</div>
	                                    </div>
	                                </div>
	                            </article>
	                            <article class="contact-row">
	                                <div class="user-card-row">
	                                    <div class="tbl-row">
	                                        <div class="tbl-cell tbl-cell-photo">
	                                            <a href="#">
	                                                <img src="img/photo-64-3.jpg" alt="">
	                                            </a>
	                                        </div>
	                                        <div class="tbl-cell">
	                                            <p class="user-card-row-name"><a href="#">Molly Bridjet</a></p>
	                                            <p class="user-card-row-mail"><a href="#">mollybr@mail.com</a></p>
	                                        </div>
	                                        <div class="tbl-cell tbl-cell-status">Assistan</div>
	                                    </div>
	                                </div>
	                            </article>
	                            <article class="contact-row">
	                                <div class="user-card-row">
	                                    <div class="tbl-row">
	                                        <div class="tbl-cell tbl-cell-photo">
	                                            <a href="#">
	                                                <img src="img/photo-64-4.jpg" alt="">
	                                            </a>
	                                        </div>
	                                        <div class="tbl-cell">
	                                            <p class="user-card-row-name"><a href="#">Maggy Smith</a></p>
	                                            <p class="user-card-row-mail"><a href="#">maggysmith@mail.com</a></p>
	                                        </div>
	                                        <div class="tbl-cell tbl-cell-status">PR Manager</div>
	                                    </div>
	                                </div>
	                            </article>
	                            <article class="contact-row">
	                                <div class="user-card-row">
	                                    <div class="tbl-row">
	                                        <div class="tbl-cell tbl-cell-photo">
	                                            <a href="#">
	                                                <img src="img/photo-64-2.jpg" alt="">
	                                            </a>
	                                        </div>
	                                        <div class="tbl-cell">
	                                            <p class="user-card-row-name"><a href="#">Tim Collins</a></p>
	                                            <p class="user-card-row-mail"><a href="#">timcolins@mail.com</a></p>
	                                        </div>
	                                        <div class="tbl-cell tbl-cell-status">Director at Tony’s</div>
	                                    </div>
	                                </div>
	                            </article>
	                            <article class="contact-row">
	                                <div class="user-card-row">
	                                    <div class="tbl-row">
	                                        <div class="tbl-cell tbl-cell-photo">
	                                            <a href="#">
	                                                <img src="img/photo-64-1.jpg" alt="">
	                                            </a>
	                                        </div>
	                                        <div class="tbl-cell">
	                                            <p class="user-card-row-name"><a href="#">Maggy Smith</a></p>
	                                            <p class="user-card-row-mail"><a href="#">maggysmith@mail.com</a></p>
	                                        </div>
	                                        <div class="tbl-cell tbl-cell-status">PR Manager</div>
	                                    </div>
	                                </div>
	                            </article>
	                            <article class="contact-row">
	                                <div class="user-card-row">
	                                    <div class="tbl-row">
	                                        <div class="tbl-cell tbl-cell-photo">
	                                            <a href="#">
	                                                <img src="img/photo-64-3.jpg" alt="">
	                                            </a>
	                                        </div>
	                                        <div class="tbl-cell">
	                                            <p class="user-card-row-name"><a href="#">Molly Bridjet</a></p>
	                                            <p class="user-card-row-mail"><a href="#">mollybr@mail.com</a></p>
	                                        </div>
	                                        <div class="tbl-cell tbl-cell-status">Assistan</div>
	                                    </div>
	                                </div>
	                            </article>
	                            <article class="contact-row">
	                                <div class="user-card-row">
	                                    <div class="tbl-row">
	                                        <div class="tbl-cell tbl-cell-photo">
	                                            <a href="#">
	                                                <img src="img/photo-64-4.jpg" alt="">
	                                            </a>
	                                        </div>
	                                        <div class="tbl-cell">
	                                            <p class="user-card-row-name"><a href="#">Maggy Smith</a></p>
	                                            <p class="user-card-row-mail"><a href="#">maggysmith@mail.com</a></p>
	                                        </div>
	                                        <div class="tbl-cell tbl-cell-status">PR Manager</div>
	                                    </div>
	                                </div>
	                            </article>
	                        </div>
	                    </div><!--.box-typical-body-->
	                </section><!--.box-typical-dashboard-->
	            </div><!--.col-->
	            <div class="col-xl-6">
	                <div class="row">
	                    <div class="col-sm-6">
	                        <article class="statistic-box red">
	                            <div>
	                                <div class="number">1456</div>
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
	                                <div class="number">2028</div>
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
	                                <div class="number">10</div>
	                                <div class="caption"><div>Pengaduan Media</div></div>
	                                 <div class="percent">
	                                    <div class="arrow up"></div>
	                                </div>
	                            </div>
	                        </article>
	                    </div><!--.col-->
	                    <div class="col-sm-6">
	                        <article class="statistic-box green">
	                            <div>
	                                <div class="number">917</div>
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
	            <section class="box-typical box-typical-dashboard panel panel-default scrollable">
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
	            </section>
	            </div>
	        </div>
	    </div>
	</div>

<?php
	include 'footer.php';
?>