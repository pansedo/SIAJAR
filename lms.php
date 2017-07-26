<?php
    include 'setting/connection.php';
    spl_autoload_register(function ($class) {
        include 'setting/controller/' .$class . '.php';
    });
    $ClassUser = new User();
    $ClassKelas = new Kelas();
    $ClassMedia = new media();
    $countguru = $ClassUser->CountGuru();
    $countsiswa = $ClassUser->CountSiswa();
    $countkelas = $ClassKelas->CountKelas();
    $countmedia = $ClassMedia->CountMedia();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>SEAMOLEC - LEARNING MANAGEMENT SYSTEM</title>
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/edua-icons.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/animate.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/owl.carousel.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/owl.transitions.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/cubeportfolio.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/settings.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/bootsnav.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/lib/front/loader.css">
        <link rel="stylesheet" type="text/css" href="assets/css/separate/pages/login.css">
        <link rel="stylesheet" type="text/css" href="assets/css/owl.theme.css">
        <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.css">

        <link href="assets/img/favicon.ico" rel="shortcut icon">

        <style>
            *{
                font-family: 'Proxima Nova',sans-serif;
            }

            p{
                line-height: 150%;
            }

            .sign-box a{
                color: #29b7c4;
            }

            .errspan {
                float: right;
                margin-right: -25px;
                margin-top: -25px;
                position: relative;
                z-index: 2;
                color: red;
            }
        </style>

    </head>

    <body class="pushmenu-push">
        <a href="#" class="scrollToTop"><i class="fa fa-angle-up"></i></a>
        <div class="loader">
            <div class="bouncybox">
                <div class="bouncy"></div>
            </div>
        </div>

        <div class="modal fade"
             id="login"
             tabindex="-1"
             role="dialog"
             aria-labelledby="loginLabel"
             aria-hidden="true"
             data-backdrop="static"
             data-keyboard="false">
            <div class="modal-dialog" style="width: 350px;" role="document">
                <div class="modal-content">
                    <form method='POST' class="sign-box" id="form-login" onsubmit="return false;">
                    <div style="display: flex">
                        <div class="sign-avatar">
                            <img src="assets/img/kemendikbud.png" style="border-radius: 0px !important;" alt="">
                        </div>
                        <div class="sign-avatar">
                            <img src="assets/img/jabar.png" style="border-radius: 0px !important;" alt="">
                        </div>
                    </div>
                    <div class="modal-header">
                        <h4 class="modal-title text-center">SIAJAR</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Email atau username" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Kata sandi" data-toggle="password" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div style="float: right;">
                                <a href="account-recovery.php">Lupa kata sandi anda ?</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-primary pull-right" name="updateMapel" value="send" >Login</button>
                        <button type="button" class="btn btn-rounded btn-default btn-cancel" data-dismiss="modal">Batal</button>
                    </div>
                    </form>
                </div>
            </div>
        </div><!--.modal-->

        <div class="modal fade"
             id="register"
             tabindex="-1"
             role="dialog"
             aria-labelledby="registerLabel"
             aria-hidden="true"
             data-backdrop="static"
             data-keyboard="false">
            <div class="modal-dialog" style="width: 350px;" role="document">
                <div class="modal-content">
                    <form method='POST' class="sign-box" id="form-register" onsubmit="return false;">
                    <div style="display: flex">
                        <div class="sign-avatar">
                            <img src="assets/img/kemendikbud.png" style="border-radius: 0px !important;" alt="">
                        </div>
                        <div class="sign-avatar">
                            <img src="assets/img/jabar.png" style="border-radius: 0px !important;" alt="">
                        </div>
                    </div>
                    <div class="modal-header">
                        <h4 class="modal-title text-center">SIAJAR</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#menu1">Siswa</a></li>
                            <li><a data-toggle="tab" href="#menu2">Guru</a></li>
                        </ul>
                        <br />
                        <div class="tab-content">
                            <div id="menu1" class="tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="kode_kelas" id="kode_kelas" placeholder="Kode Kelas" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" placeholder="Nama Lengkap" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="username_siswa" id="username_siswa" placeholder="Email atau NIK" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="password_siswa" id="password_siswa" placeholder="Kata sandi" data-toggle="password" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="password" class="form-control re_password_siswa" name="re_password_siswa" id="re_password_siswa" placeholder="Kata ulang sandi" data-toggle="password" />
                                        <span id="icon_re_password_siswa"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-rounded btn-primary pull-right" name="submit_siswa">Daftar Siswa</button>
                                    <button type="button" class="btn btn-rounded btn-default btn-cancel" data-dismiss="modal"  onclick="clear();">Batal</button>
                                </div>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="nama_guru" id="nama_guru" placeholder="Nama Lengkap" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="username_guru" id="username_guru" placeholder="Email atau NIK" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="password" class="form-control" name="password_guru" id="password_guru" placeholder="Kata sandi" data-toggle="password" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="password" class="form-control re_password_guru" name="re_password_guru" id="re_password_guru" placeholder="Kata ulang sandi" data-toggle="password" />
                                                <span id="icon_re_password_guru"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-rounded btn-primary pull-right" name="submit_guru" value="guru">Daftar Guru</button>
                                    <button type="button" class="btn btn-rounded btn-default btn-cancel" data-dismiss="modal"  onclick="clear();">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div><!--.modal-->

        <header>
            <nav class="navbar navbar-default navbar-sticky bootsnav pushy">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="index3.html">
                            <img src="assets/img/front/logo.png" class="logo" alt="">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOut">
                            <li><a href="#" data-toggle="modal" data-target="#login">Login</a>
                            </li>
                            <li><a href="#" data-toggle="modal" data-target="#register">Register</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!--Search-->
        <!-- <div id="search">
            <button type="button" class="close">×</button>
            <form>
                <input type="search" value="" placeholder="Search here...."  required/>
                <button type="submit" class="btn btn_common yellow">Search</button>
            </form>
        </div> -->

        <!--Text Banner-->
        <section class="padding" id="text_rotator_parent">
            <div class="container">
                <div id="text_rotator" class="owl-carousel">
                    <div class="item">
                        <div class="rotate_caption text-center">
                            <h1>Selamat datang di Siajar</h1>
                            <p>Cara paling aman dan termudah bagi pendidik untuk menghubungkan <br> berkolaborasi dengan guru dan siswa.</p>
                            <a href="#" data-toggle="modal" data-target="#register" class="border_radius btn_common yellow">Buat akun Gratis</a>
                            <a href="#" data-toggle="modal" data-target="#login" class="border_radius btn_common yellow">Masuk</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="rotate_caption text-center">
                            <h1>Selamat datang di Siajar</h1>
                            <p>Cara paling aman dan termudah bagi pendidik untuk menghubungkan <br> berkolaborasi dengan guru dan siswa.</p>
                            <a href="#" data-toggle="modal" data-target="#register" class="border_radius btn_common yellow">Buat akun Gratis</a>
                            <a href="#" data-toggle="modal" data-target="#login" class="border_radius btn_common yellow">Masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Text Banner ends-->

        <section style="-moz-box-shadow: 0 3px 3px -3px rgba(0,0,0,.35); -o-box-shadow: 0 3px 3px -3px rgba(0,0,0,.35); -webkit-box-shadow: 0 3px 3px -3px rgba(0,0,0,.35); box-shadow: 0 3px 3px -3px rgba(0,0,0,.35);">
            <div class="text-center">
                <div style="width: 200px; margin:0 auto; padding: 10px; background: #3ac9d6; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; font-family: 'museo_slab700'">Kerjasama Antara</div>
            </div>
            <div id="owl-demo" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
                <div class="owl-item">
                    <div align="center">
                        <a href="https://kemdikbud.go.id/" target="_blank" title="Kementerian Pendidikan dan Kebudayaan">
                            <img style="max-height: 150px; max-width:150px; padding: 20px;" src="assets/img/dikbud.png" alt="KEMENDIKBUD" title="Kementerian Pendidikan dan Kebudayaan">
                        </a>
                    </div>
                </div>

                <div class="owl-item">
                    <div align="center">
                        <a href="http://jabarprov.go.id/" target="_blank" title="Dinas Pendidikan Provinsi Jawa Barat">
                            <img style="max-height: 150px; max-width:150px; padding: 20px;" src="assets/img/jabar.png" alt="Dinas Pendidikan Provinsi Jawa Barat">
                        </a>
                    </div>
                </div>

                <div class="owl-item">
                    <div align="center">
                        <a href="http://pauddikmas-jayagiri.info/" target="_blank" title="PP PAUDDIKMAS JABAR">
                            <img style="max-height: 150px; max-width:150px; padding: 20px;" src="assets/img/jayagiri.png" alt="PP PAUDDIKMAS JABAR">
                        </a>
                    </div>
                </div>

                <div class="owl-item">
                    <div align="center">
                        <a href="http://www.seamolec.org/" target="_blank" title="SEAMEO SEAMOLEC">
                            <img style="max-height: 150px; max-width:150px; padding: 20px;" src="assets/img/20seam.png" alt="SEAMEO SEAMOLEC">
                        </a>
                    </div>
                </div>
            </div>

            <div class="owl-controls clickable">
                <div class="owl-pagination"></div>
            </div>
        </section>

        <!--ABout US-->
        <section id="about" class="padding-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-sm-6 priorty wow fadeInLeft">
                        <h2 class="heading bottom25">Selamat datang di SIAJAR LMS <span class="divider-left"></span></h2>
                        <p class="half_space">Fokus pada mengajar bukan pada tulis-menulis
                        Dengan fitur-fitur intuitif dan penyimpanan tidak terbatas, membuat grup dengan cepat,
                        mengelola kemajuan dan banyak lagi.
                        Siajar telah dirancang untuk memberikan kontrol sepenuhnya terhadap kelas digitalmu.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="about-post">
                                    <a href="#." class="border_radius"><img src="assets/img/front/hands-white.png" alt="hands"></a>
                                    <h4>Jadwal</h4>
                                    <p>dapat diatur sesuai dengan kelas</p>
                                </div>
                                <div class="about-post">
                                    <a href="#." class="border_radius"><img src="assets/img/front/awesome-white.png" alt="hands"></a>
                                    <h4>Siswa Senang</h4>
                                    <p>Siswa dapat belajar dengan menyenangkan dan mudah di gunakan</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="about-post">
                                    <a href="#." class="border_radius"><img src="assets/img/front/maintenance-white.png" alt="hands"></a>
                                    <h4>Bahan Ajar</h4>
                                    <p>Bahan ajar yang dapat disesuaikan oleh guru</p>
                                </div>
                                <div class="about-post">
                                    <a href="#." class="border_radius"><img src="assets/img/front/home-white.png" alt="hands"></a>
                                    <h4>Guru & Siswa</h4>
                                    <p>dapat terhubung dalam satu kelas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-6 wow fadeInRight">
                        <img src="assets/img/front/42580.jpg" alt="our priorties" class="img-responsive" style="width:100%;">
                    </div>
                </div>
            </div>

            <div class="container margin_top">
                <div class="row">
                    <div class="icon_wrap padding-bottom-half clearfix">
                        <div class="col-sm-4 icon_box text-center heading_space wow fadeInUp" data-wow-delay="300ms">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <h4 class="text-capitalize bottom20 margin10">Mudah</h4>
                            <p class="no_bottom" style="text-align: justify;">
                                <?php
                                    $isi = "Dengan fitur-fitur intuitif dan penyimpanan yang tidak terbatas dengan Gudang Media,
                                            dengan cepat membuat grup, memberikan pekerjaan rumah,
                                            menjadwalkan kuis, mengelola kemajuan dan banyak lagi.
                                            Dengan segala sesuatu pada satu platform,
                                            Siajar memperkuat dan meningkatkan apa yang telah anda lakukan di dalam kelas.";

                                    echo substr($isi, 0, 362)." ...";
                                ?>
                            </p>
                        </div>
                        <div class="col-sm-4 icon_box text-center heading_space wow fadeInUp" data-wow-delay="400ms">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <h4 class="text-capitalize bottom20 margin10">Aman</h4>
                            <p class="no_bottom" style="text-align: justify;">Siajar dirancang untuk memberikan kontrol penuh atas kelas digital Anda.
                            Dengan alat yang memungkinkan Anda menentukan siapa yang dapat gabung dengan grup, memantau aktivitas
                            anggota.</p>
                        </div>
                        <div class="col-sm-4 icon_box text-center heading_space wow fadeInUp" data-wow-delay="500ms">
                            <i class="icon-icons20"></i>
                            <h4 class="text-capitalize bottom20 margin10">Serba Guna</h4>
                            <p class="no_bottom" style="text-align: justify;" >
                            <?php
                                $isi = "Apakah Anda ingin menciptakan ruang kelas tanpa kertas,
                                        membina keterampilan kewarganegaraan digital, mengintegrasikan konten
                                        pendidikan dari Gudang Media, atau tumbuh jaringan pembelajaran profesional Anda,
                                        Anda dapat mempersonalisasikan bagaimana Anda menggunakan Siajar.";

                                echo substr($isi, 0, 350)." ...";
                            ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--ABout US-->

        <!--Fun Facts-->
        <section id="counter" class="parallax padding">
            <div class="container">
                <h2 class="hidden">hidden</h2>
                <div class="row number-counters">
                    <div class="col-md-3 col-sm-6 col-xs-6 counters-item text-center wow fadeInUp" data-wow-delay="300ms">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <strong data-to="<?php echo $countguru ;?>">0</strong>
                        <p>Guru </p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6 counters-item text-center wow fadeInUp" data-wow-delay="400ms">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <strong data-to="<?php echo $countsiswa ;?>">0</strong>
                        <p>Siswa</p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6 counters-item text-center wow fadeInUp" data-wow-delay="500ms">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <strong data-to="<?php echo $countkelas ;?>">0</strong>
                        <p>Kelas</p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6 counters-item text-center wow fadeInUp" data-wow-delay="600ms">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <strong data-to="<?php echo $countmedia ;?>">0</strong>
                        <p>Bahan Ajar</p>
                    </div>
                </div>
            </div>
        </section>
        <!--Fun Facts-->

        <!--FOOTER-->
        <footer class="padding-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 footer_panel bottom25">
                        <h3 class="heading bottom25">Tentang SIAJAR<span class="divider-left"></span></h3>
                        <a href="index3.html" class="footer_logo bottom25"><img src="assets/img/front/logo.png" width="150px" alt="Edua"></a>
                        <p>SIAJAR adalah sebuah platform Learning Management System yang di desain untuk sistem pembelajaran masyarakat indonesia</p>
                        <!--  <ul class="social_icon top25">
                        <li><a href="#." class="facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#." class="twitter"><i class="icon-twitter4"></i></a></li>
                        <li><a href="#." class="dribble"><i class="icon-dribbble5"></i></a></li>
                        <li><a href="#." class="instagram"><i class="icon-instagram"></i></a></li>
                        <li><a href="#." class="vimo"><i class="icon-vimeo4"></i></a></li>
                        </ul> -->
                    </div>
                    <div class="col-md-4 col-sm-4 footer_panel bottom25">
                        <!--  <h3 class="heading bottom25">Quick Links<span class="divider-left"></span></h3>
                        <ul class="links">
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Home</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Company</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Services</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Our Team</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Company History</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Certifications</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Blog</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Shop</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Privacy Policy</a></li>
                        <li><a href="#."><i class="icon-chevron-small-right"></i>Contact Us</a></li>
                        </ul> -->
                    </div>
                    <div class="col-md-4 col-sm-4 footer_panel bottom25">
                        <h3 class="heading bottom25">SEAMEO SEAMOLEC <span class="divider-left"></span></h3>
                        <p class=" address"><i class="icon-map-pin"></i>Kompleks Universitas Terbuka
                        Jl. Cabe Raya, Pondok Cabe Pamulang - 15418
                        Tangerang Selatan, Indonesia</p>
                        <p class=" address"><i class="icon-phone"></i>(62-21) 742 3725, 742 4154</p>
                        <p class=" address"><i class="icon-mail"></i><a href="mailto:secretariat@seamolec.org">secretariat@seamolec.org</a></p>
                        <img src="assets/img/front/footer-map-white.png" alt="we are here" class="img-responsive">
                    </div>
                </div>
                <div class="row copyright">
                    <div class="col-md-12 text-center">
                        <p>Copyright &copy; 2017 <a href="#.">SIAJAR - SEAMOLEC</a>. all rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <!--FOOTER ends-->

        <script src="assets/js/lib/front/jquery-2.2.3.js"></script>
        <script src="assets/js/lib/front/bootstrap.min.js"></script>
        <script src="assets/js/lib/front/bootsnav.js"></script>
        <script src="assets/js/lib/front/jquery.appear.js"></script>
        <script src="assets/js/lib/front/jquery-countTo.js"></script>
        <script src="assets/js/lib/front/jquery.parallax-1.1.3.js"></script>
        <script src="assets/js/lib/front/owl.carousel.min.js"></script>
        <script src="assets/js/lib/front/jquery.cubeportfolio.min.js"></script>
        <script src="assets/js/lib/front/jquery.themepunch.tools.min.js"></script>
        <script src="assets/js/lib/front/jquery.themepunch.revolution.min.js"></script>
        <script src="assets/js/lib/front/revolution.extension.layeranimation.min.js"></script>
        <script src="assets/js/lib/front/revolution.extension.navigation.min.js"></script>
        <script src="assets/js/lib/front/revolution.extension.parallax.min.js"></script>
        <script src="assets/js/lib/front/revolution.extension.slideanims.min.js"></script>
        <script src="assets/js/lib/front/revolution.extension.video.min.js"></script>
        <script src="assets/js/lib/front/wow.min.js"></script>
        <script src="assets/js/lib/front/functions.js"></script>
        <script src="assets/js/lib/front/bootstrap-show-password.js"></script>
        <script src="assets/js/owl.carousel.js"></script>

        <script>
            $(function() {
                var register        = "siswa";
                var match_password  = false;

                $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if(target=="#menu1"){
                        register    = "siswa";
                        $("#kode_kelas").prop('required', true);
                        $("#nama_siswa").prop('required', true);
                        $("#username_siswa").prop('required', true);
                        $("#password_siswa").prop('required', true);
                        $("#nama_guru").prop('required', false);
                        $("#username_guru").prop('required', false);
                        $("#password_guru").prop('required', false);
                        $('#nama_guru').val('');
                        $('#username_guru').val('');
                        $('#password_guru').val('');
                        $('#re_password_guru').val('');
                        $('#icon_re_password_guru').html('');
                    }else{
                        register    = "guru";
                        $("#kode_kelas").prop('required', false);
                        $("#nama_siswa").prop('required', false);
                        $("#username_siswa").prop('required', false);
                        $("#password_siswa").prop('required', false);
                        $("#nama_guru").prop('required', true);
                        $("#username_guru").prop('required', true);
                        $("#password_guru").prop('required', true);
                        $('#kode_kelas').val('');
                        $('#nama_siswa').val('');
                        $('#username_siswa').val('');
                        $('#password_siswa').val('');
                        $('#re_password_siswa').val('');
                        $('#icon_re_password_siswa').html('');
                    }
                });

    			$('#form-login').submit(function() {
    				var fd = new FormData(this);
    				fd.append('action','login');
    				$.ajax({
          				type: 'POST',
          				url: 'url-API/auth.php',
          				data: fd,
          				contentType: false,
          				processData: false,
          				success: function(res){
        						alert(res.message);
                                if(res.icon == 'error'){
                                    location.href='lms.php';
                                }else{
                                    location.href='index.php';
                                }
          				},
          				error: function(){
          					swal(res.response, res.message, res.icon);
          				}
          			});
    			});

                $('#form-register').submit(function() {
                    if(match_password){
                        var fd = new FormData(this);
                        fd.append('status', register);
                        $.ajax({
                            type: 'POST',
                            url: 'url-API/auth-reg.php',
                            data: fd,
                            contentType: false,
                            processData: false,
                            success: function(res){
                                    alert(res.message);
                                    if(res.icon == 'error'){
                                        location.href='lms.php';
                                    }else{
                                        location.href='index.php';
                                    }
                            },
                            error: function(){
                                swal(res.response, res.message, res.icon);
                            }
                        });
                    }else{
                        alert("Konfirmasi password tidak sesuai");
                    }
                });

                $('.btn-cancel').click(function() {
                    $('#username').val('');
                    $('#password').val('');
                    $('#kode_kelas').val('');
                    $('#nama_siswa').val('');
                    $('#username_siswa').val('');
                    $('#password_siswa').val('');
                    $('#nama_guru').val('');
                    $('#username_guru').val('');
                    $('#password_guru').val('');
                });

                $( ".re_password_siswa" ).keyup(function( event ) {
                    re_password = $('#re_password_siswa').val();

                    if(re_password == $('#password_siswa').val()){
                        match_password = true;
                        $('#icon_re_password_siswa').html('<i class="fa fa-check errspan" aria-hidden="true" style="color: #3ac9d6"></i>');
                    }else{
                        match_password = false;
                        $('#icon_re_password_siswa').html('<i class="fa fa-times errspan" aria-hidden="true"></i>');
                    }
                });

                $( ".re_password_guru" ).keyup(function( event ) {
                    re_password = $('#re_password_guru').val();

                    if(re_password == $('#password_guru').val()){
                        match_password = true;
                        $('#icon_re_password_guru').html('<i class="fa fa-check errspan" aria-hidden="true" style="color: #3ac9d6"></i>');
                    }else{
                        match_password = false;
                        $('#icon_re_password_guru').html('<i class="fa fa-times errspan" aria-hidden="true"></i>');
                    }
                });
            });

            $(document).ready(function() {
                $("#owl-demo").owlCarousel({
                   autoPlay: 4000, //Set AutoPlay to 3 seconds
                   items : 4,
                   itemsDesktop : [1199,5],
                   itemsDesktopSmall : [979,5],
                   itemsTablet : [768,3],
                   itemsMobile : [479,1]
                });
            });
        </script>
    </body>
</html>
