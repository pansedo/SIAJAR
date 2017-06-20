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

<link href="assets/img/favicon.ico" rel="shortcut icon">

</head>

<body class="pushmenu-push">
<a href="#" class="scrollToTop"><i class="fa fa-angle-up"></i></a>
<div class="loader">
  <div class="bouncybox">
      <div class="bouncy"></div>
    </div>
</div>


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

          <li><a href="index.php">Login</a>
          </li>
          <li><a href="index.php">Register</a>
        </ul>
      </div>
    </div>
  </nav>
</header>


<!--Search-->
<div id="search">
  <button type="button" class="close">×</button>
  <form>
    <input type="search" value="" placeholder="Search here...."  required/>
    <button type="submit" class="btn btn_common yellow">Search</button>
  </form>
</div>

<!--Text Banner-->
<section class="padding" id="text_rotator_parent">
  <div class="container">
    <div id="text_rotator" class="owl-carousel">
      <div class="item">
        <div class="rotate_caption text-center">
          <h1>Selamat datang di Siajar</h1>
          <p>Cara paling aman dan termudah bagi pendidik untuk menghubungkan <br> berkolaborasi dengan guru dan siswa.</p>
          <a href="#." class="border_radius btn_common blue">Buat akun Gratis</a>
        </div>
      </div>
      <div class="item">
        <div class="rotate_caption text-center">
          <h1>Selamat datang di Siajar</h1>
          <p>Cara paling aman dan termudah bagi pendidik untuk menghubungkan <br> berkolaborasi dengan guru dan siswa.</p>
          <a href="#." class="border_radius btn_common yellow">Masuk</a>
          </div>
      </div>
    </div>
  </div>
</section>
<!--Text Banner ends--> 


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
            <a href="#." class="border_radius"><img src="assets/img/front/hands.png" alt="hands"></a>
            <h4>Jadwal</h4>
            <p>dapat diatur sesuai dengan kelas</p>
            </div>
            <div class="about-post">
            <a href="#." class="border_radius"><img src="assets/img/front/awesome.png" alt="hands"></a>
            <h4>Siswa Senang</h4>
            <p>Siswa dapat belajar dengan menyenangkan dan mudah di gunakan</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="about-post">
            <a href="#." class="border_radius"><img src="assets/img/front/maintenance.png" alt="hands"></a>
            <h4>Bahan Ajar</h4>
            <p>Bahan ajar yang dapat disesuaikan oleh guru</p>
            </div>
            <div class="about-post">
            <a href="#." class="border_radius"><img src="assets/img/front/home.png" alt="hands"></a>
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
         <p class="no_bottom" style="text-align: justify;">Dengan fitur-fitur intuitif dan penyimpanan yang tidak terbatas dengan Gudang Media, 
         dengan cepat membuat grup, memberikan pekerjaan rumah,
          menjadwalkan kuis, mengelola kemajuan dan banyak lagi. 
          Dengan segala sesuatu pada satu platform, 
          Siajar memperkuat dan meningkatkan apa yang telah anda lakukan di dalam kelas.</p>
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
         <p class="no_bottom" style="text-align: justify;" >Apakah Anda ingin menciptakan ruang kelas tanpa kertas, 
         membina keterampilan kewarganegaraan digital, mengintegrasikan konten 
         pendidikan dari Gudang Media, atau tumbuh jaringan pembelajaran profesional Anda, 
         Anda dpt mempersonalisasikan bagaimana Anda menggunakan Siajar.</p>
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
        <img src="assets/img/front/footer-map.png" alt="we are here" class="img-responsive">
      </div>
    </div>
  </div>
</footer>
<div class="copyright">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <p>Copyright &copy; 2017 <a href="#.">SIAJAR - SEAMOLEC</a>. all rights reserved.</p>
      </div>
    </div>
  </div>
</div>
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

</body>
</html>
