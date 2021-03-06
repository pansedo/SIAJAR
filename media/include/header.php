<?php
    session_start();
    ob_start();
	// error_reporting(0);
	$id_users = null;
	include 'Connection/connection.php';

    spl_autoload_register(function ($class) {
      include 'Controller/' .$class . '.php';
    });
    $base_url = "http://sumberbelajar.seamolec.org";
	if (!isset($_SESSION['lms_id']) && !isset($_SESSION['lms_username']) && !isset($_SESSION['lms_status'])) {
        // header("Location:Auth/$base_url");
        // exit();
    }else{
        set_time_limit(10000);
        $id_users   = $_SESSION['lms_id'];
        $email    = $_SESSION['lms_username'];
        $status     = $_SESSION['lms_status'];


        $classProfile = new Profile();
		$FuncProfile = $classProfile->GetData($id_users);

    }

    function selisih_waktu($timestamp){
    	$selisih = time() - strtotime($timestamp) ;

	    $detik  = $selisih ;
	    $menit  = round($selisih / 60 );
	    $jam    = round($selisih / 3600 );
	    $hari   = round($selisih / 86400 );
	    $minggu = round($selisih / 604800 );
	    $bulan  = round($selisih / 2419200 );
	    $tahun  = round($selisih / 29030400 );

	    if ($detik <= 60) {
	        $waktu = $detik.' detik yang lalu';
	    } else if ($menit <= 60) {
	        $waktu = $menit.' menit yang lalu';
	    } else if ($jam <= 24) {
	        $waktu = $jam.' jam yang lalu';
	    } else if ($hari <= 7) {
	        $waktu = $hari.' hari yang lalu';
	    } else if ($minggu <= 4) {
	        $waktu = $minggu.' minggu yang lalu';
	    } else if ($bulan <= 12) {
	        $waktu = $bulan.' bulan yang lalu';
	    } else {
	        $waktu = $tahun.' tahun yang lalu';
	    }

	    return $waktu;
	}

    $classKategori = new Kategori();
    $getkategoriutama = $classKategori->GetKategoriUtama();
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

    <link rel="stylesheet" href="Assets/css/style_manual.css">
	<link rel="stylesheet" href="Assets/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="Assets/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="Assets/css/separate/vendor/tags_editor.min.css">

	<link rel="stylesheet" href="Assets/css/separate/vendor/tags_editor.min.css">
	<link rel="stylesheet" href="Assets/css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="Assets/css/separate/vendor/select2.min.css">
	<script src="Assets/js/lib/jquery/jquery.min.js"></script>
	<link rel="stylesheet" href="Assets/css/style_manual.css">

	<script  src="Assets/js/lib/sweetalert/sweetalert2.min.js"></script>
	<link rel="stylesheet"  href="Assets/js/lib/sweetalert/sweetalert2.min.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<<<<<<< HEAD
	 Share Icon
	<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
=======
	<!-- // <script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>  -->
>>>>>>> 577bee08b80e1abf6c8da3627ecb5945dff812bf

	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	 Share Icon
	<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script> -->
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="Assets/js/lib/simple-share/jquery.sharebox.js"></script>
	<link href="Assets/js/lib/simple-share/jquery.sharebox.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="Assets/css/lib/uploadfile/component.css" />
	<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

	<script type="text/javascript" src="./assets/tinymce4/js/tinymce/tinymce.min.js"></script>

<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script> -->

<!-- Style for html code -->

<script type="text/javascript">
        tinymce.init({
            selector: '.myeditablediv',
            height : 100,
            menubar: false,
            auto_focus:true,

        // To avoid TinyMCE path conversion from base64 to blob objects.
        // https://www.tinymce.com/docs/configure/file-image-upload/#images_dataimg_filter
        images_dataimg_filter : function(img) {
            return img.hasAttribute('internal-blob');
        },
        setup : function(ed)
        {
            ed.on('init', function()
            {
                this.getDoc().body.style.fontSize = '16px';
                this.getDoc().body.style.fontFamily = 'Arial, "Helvetica Neue", Helvetica, sans-serif';
            });
        },
         plugins: [
              "advlist autolink link image lists charmap print preview hr anchor pagebreak",
              "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
              "table contextmenu directionality emoticons paste textcolor responsivefilemanager code tiny_mce_wiris"
         ],
         toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect| link unlink anchor | image media | forecolor backcolor  | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry",
         // image_advtab: true
        });
</script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script> -->

<!-- Style for html code -->
<link type="text/css" rel="stylesheet" href="./assets/tinymce4/css/prism.css" />
</head>
<body class="with-side-menu sidebar-hidden chrome-browser ">
<header class="site-header">
	    <div class="container-fluid">

	        <a href="<?=$base_url?>" class="site-logo">
	            <img class="hidden-md-down" src="Assets/img/logo-2.png" alt="">
	            <img class="hidden-lg-up" src="Assets/img/logo-2-mob.png" alt="">
	        </a>

	        <div class="site-header-content">
	            <div class="site-header-content-in">

	                <div class="site-header-shown">
	                <?php
	                	if (isset($_SESSION['lms_id'])) {
	                ?>


	                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                            <img src="Assets/foto/<?php if ($FuncProfile['foto'] != NULL) {echo $FuncProfile['foto'];}else{echo "no_picture.png";} ?>" alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
	                            <!-- <a class="dropdown-item" href="<?php //echo $base_url ?>"><span class="font-icon glyphicon glyphicon-home"></span></a> -->
	                            <a class="dropdown-item" href="profile.php"><span class="font-icon glyphicon glyphicon-user"></span>Profil</a>
	                            <a class="dropdown-item" href="setting.php"><span class="font-icon glyphicon glyphicon-cog"></span>Pengaturan</a>
	                            <div class="dropdown-divider"></div>
	                            <a class="dropdown-item" href="Auth/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Keluar</a>
	                        </div>
	                    </div>
						<?php
	 					} ?>
	                    <button type="button" class="burger-right">
	                        <i class="font-icon-menu-addl"></i>
	                    </button>

	                </div><!--.site-header-shown-->

	                <div class="mobile-menu-right-overlay"></div>
	                <div class="site-header-collapsed">
					<!-- HEADER MENU -->
	                    <div class="site-header-collapsed-in">
	                        <div class="dropdown dropdown-typical">
	                            <a href="<?php echo $base_url ?>" class="dropdown-toggle no-arr">
								   <span class="font-icon font-icon-home"></span> Beranda
								   <span class="lbl"></span>
							   </a>
	                        </div>
							<div class="dropdown dropdown-typical">
	                            <a class="dropdown-toggle" id="dd-header-marketing" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                                <span class="font-icon font-icon-users"></span> Jenjang Pendidikan
	                                <span class="lbl"></span>
	                            </a>

	                            <div class="dropdown-menu" aria-labelledby="dd-header-marketing">
	                            <?php
	                            	foreach ($getkategoriutama as $data) {
	                            		echo "<a class='dropdown-item' href='kategori.php?idkat=".base64_encode($data['_id'])."'>".$data['kategori']."</a>";
	                            	}
	                            ?>
	                                <!-- <a class="dropdown-item" href="#">Digital Class Development 1</a>
	                                <a class="dropdown-item" href="#">Digital Class Development 2</a>
	                                <a class="dropdown-item" href="#">Digital Class Development 3</a> -->
	                            </div>
	                        </div>
							<!-- <div class="dropdown dropdown-typical">
							   <a href="#" class="dropdown-toggle no-arr">
								   <span class="font-icon font-icon-share"></span> Gudang Media
								   <span class="lbl"></span>
							   </a>
						   </div> -->
						    <div class="site-header-collapsed-in">

	                        <div class="site-header-search-container">
	                       	<?php
	                            if (!isset($_SESSION['lms_id'])) {

			                ?>
		        				<a class="btn btn-sm btn-inline btn-primary-outline" href="Auth/Signin.php">
		                            <i class="fa fa-lock"></i> Login
		                        </a>
		                	<?php
		                		}else{
		                    ?>
		                    	<a href="media.php?action=unggah" class="btn btn-inline btn-sm btn-primary-outline">
			                            <i class="fa fa-upload"></i> Unggah
			                        </a>
			                <?php
			                	}
			                ?>

	                            <form action="search.php" method="POST" class="site-header-search">
	                                <input type="text"  name="search"  placeholder="Search"/>
	                                <button type="submit">
	                                    <span class="font-icon-search"></span>
	                                </button>
	                                <div class="overlay"></div>
	                            </form>



	                        </div>
						   <div class="dropdown dropdown-typical">

			                    </div>
	                    </div><!--.site-header-collapsed-in-->
	                </div><!--.site-header-collapsed-->
	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->



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
