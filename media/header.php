<?php
    session_start();
    ob_start(); 
	// error_reporting(0);
	include 'Connection/connection.php';
    
    spl_autoload_register(function ($class) {
      include 'Controller/' .$class . '.php';
    });
?>  
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Learning Management System - Seamolec</title>

	<link href="Assets/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="Assets/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="Assets/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="Assets/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="Assets/img/favicon.png" rel="icon" type="image/png">
	<link href="Assets/img/favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" href="Assets/css/separate/vendor/slick.min.css">
	<link rel="stylesheet" href="Assets/css/separate/pages/profile.min.css">
	<link rel="stylesheet" href="Assets/css/separate/pages/project.min.css">
	<link rel="stylesheet" href="Assets/css/separate/elements/cards.min.css">
	<link rel="stylesheet" href="Assets/css/separate/pages/widgets.min.css">
    <link rel="stylesheet" href="Assets/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="Assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/main.source.css">

    <!-- <link rel="stylesheet" href="Assets/css/style_manual.css"> -->
	<link rel="stylesheet" href="Assets/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="Assets/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="Assets/css/separate/vendor/tags_editor.min.css">

	<link rel="stylesheet" href="Assets/css/separate/vendor/tags_editor.min.css">
	<link rel="stylesheet" href="Assets/css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="Assets/css/separate/vendor/select2.min.css">
	<script src="Assets/js/lib/jquery/jquery.min.js"></script>
	<link rel="stylesheet" href="Assets/css/style_manual.css">


	<link rel="stylesheet" type="text/css" href="Assets/css/lib/uploadfile/component.css" />
	<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
</head>
<body class="with-side-menu sidebar-hidden chrome-browser ">
	<header class="site-header">
	    <div class="container-fluid">
	
	        <a href="#" class="site-logo">
	            <img class="hidden-md-down" src="Assets/img/logo-2.png" alt="">
	            <img class="hidden-lg-up" src="Assets/img/logo-2-mob.png" alt="">
	        </a>
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">

	                    <?php
	                    	if (isset($_SESSION['lms_id'])) {
	                    ?>
	                      <div class="dropdown dropdown-notification notif">
	                        <a href="#"
	                           class="header-alarm dropdown-toggle active"
	                           id="dd-notification"
	                           data-toggle="dropdown"
	                           aria-haspopup="true"
	                           aria-expanded="false">
	                            <i class="font-icon-alarm"></i>
	                        </a>
	                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
	                        	 
	                            <div class="dropdown-menu-notif-header">
	                                Notifications
	                                <span class="label label-pill label-danger">4</span>
	                            </div>
	                            <div class="dropdown-menu-notif-list">
	                                <div class="dropdown-menu-notif-item">
	                                    <div class="photo">
	                                        <img src="Assets/img/photo-64-1.jpg" alt="">
	                                    </div>
	                                    <div class="dot"></div>
	                                    <a href="#">Morgan</a> was bothering about something
	                                    <div class="color-blue-grey-lighter">7 hours ago</div>
	                                </div>
	                            </div>
	                            <div class="dropdown-menu-notif-more">
	                                <a href="#">See more</a>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                            <img src="Assets/img/avatar-2-64.png" alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
	                            <a class="dropdown-item" href="Index.php"><span class="font-icon glyphicon glyphicon-home"></span>Home</a>
	                            <a class="dropdown-item" href="Profile.php"><span class="font-icon glyphicon glyphicon-user"></span>Profile</a>
	                            <a class="dropdown-item" href="Setting.php"><span class="font-icon glyphicon glyphicon-cog"></span>Settings</a>
	                            <div class="dropdown-divider"></div>
	                            <a class="dropdown-item" href="Auth/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Logout</a>
	                        </div>
	                    </div>
	                    <?php		
	                    	}
	                    ?>

	
	                    <button type="button" class="burger-right">
	                        <i class="font-icon-menu-addl"></i>
	                    </button>
	                </div><!--.site-header-shown-->
	
	                <div class="mobile-menu-right-overlay"></div>
	                <div class="site-header-collapsed">
	                    <div class="site-header-collapsed-in">
	                     
	                        <div class="site-header-search-container">
	                            <form action="search.php" method="POST" name="pencarian" id="pencarian" class="site-header-search closed">
	                                <input type="text"  name="search" id="search" placeholder="Search"/>
	                               <!--  <button type="submit" name="submit"> 
	                                    <span class="font-icon-search"></span>
	                                </button> -->
	                                 <input type="SUBMIT" name="SUBMIT" id="SUBMIT" value="search" >
	                                <div class="overlay"></div>
	                            </form>

	                        </div>
	                        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
					            <span>toggle menu</span>
					        </button>
					
					        <button class="hamburger hamburger--htla">
					            <span>toggle menu</span>
					        </button>
	                        <?php
			                    	if (isset($_SESSION['lms_id'])) {
			                    ?>
			                        <a href="upload.php" class="btn btn-inline btn-sm btn-primary-outline">
			                            <i class="fa fa-upload"></i> Upload

			                        </a>
			                        
			                    <?php
			                		}else{
			                	?>
			                		<a class="btn btn-sm btn-inline btn-primary-outline" href="Auth/Signin.php">
			                            <i class="fa fa-lock"></i> Login
			                        </a>
			                	<?php
			                		}
			                    ?>
			                
	                    </div><!--.site-header-collapsed-in-->
	                </div><!--.site-header-collapsed-->
	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->
	<div class="modal fade bd-example-modal-lg"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="myLargeModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
					<h5 class="m-t-lg with-border">Profil Anda</h5>
						<form method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-6">
									<fieldset class="form-group">
										<div class="profile-card col-lg-6">
										<div class="profile-card-photo">
											<img src="" alt=""/>
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
										<input type="text" name="nama" class="form-control" id="exampleInput" placeholder="Nama Lengkap" value="">
										<small class="text-muted">We'll never share your email with anyone else.</small>
									</fieldset>
								</div>
								<div class="col-lg-6">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInputEmail1">Email</label>
										<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="">
									</fieldset>
								</div>
								
							</div>
							<div class="row">
								<div class="col-lg-6">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInput">Jenis Kelamin</label>
										<select id="exampleSelect" name="jenis_kelamin" class="form-control">
											<option value="">Pilih Salah Satu </option>
											<option value="Laki-laki" >Laki-laki</option>
											<option value="Perempuan" >Perempuan</option>
										</select>
										
									</fieldset>
								</div>
								<div class="col-lg-6">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInputEmail1">Instansi/Sekolah</label>
										<input type="text" name="instansi" class="form-control" value=""  placeholder="Instansi" >
									</fieldset>
								</div>
								
							</div>
							<button type="submit" name="simpan_profil" class="btn">Simpan</button>
						</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-rounded btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div><!--.modal-->