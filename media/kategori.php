<?php
	include "include/header.php";
	include 'include/menu.php';

	$classMedia = new Media();
    // $getMedia = $classMedia->GetMedia();
    // $getMediaPagging = $classMedia->GetMediaPagging();

    if (isset($_GET['idkat'])) { 
        if ($_GET['idkat'] == "") {
            echo "<script>document.location.href='index.php'</script>";
        }
        $idkat = base64_decode($_GET['idkat']);
        $MediaByKategori = $classMedia->classMediaByKategori($idkat);
        ?>
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-8">
                    <?php
                        $no = 1;
                        foreach ($MediaByKategori as $data) {
                    ?>
                        <div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
                        <div class="card-grid-col">
                            <article class="card-typical">
                                <div class="card-typical-section">
                                    <div class="user-card-row">
                                        <div class="tbl-row">
                                            <div class="tbl-cell tbl-cell-photo">
                                                <a href="#">
                                                    <img  src="Assets/foto/<?php if ($data['foto'] != NULL) {echo $data['foto'];}else{echo "no_picture.png";} ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="tbl-cell">
                                                <p class="user-card-row-name"><a href="product.php?id=<?php echo base64_encode($data['_id']);?>"><?php echo $data['judul']; ?></a></p>
                                                <p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
                                            </div>
                                            <div class="tbl-cell tbl-cell-status">
                                                <a href="#" class="font-icon font-icon-star active"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-typical-section card-typical-content">
                                    <!-- <div class="photo" style="min-width: 200px; height:300px; background-image:url('<?php// echo $data['path_image']; ?>'; position: center center"> -->
                                     <div class="photo" > 
                                        <a href="product.php?id=<?php echo base64_encode($data['_id']);?>"><img style="  min-width: 200px; height:300px; background:<?php echo $data['path_image']; ?>" src="<?php echo $data['path_image']; ?>"  alt=""></a>
                                    </div>
                                    <header class="title"><a href="#"></a></header>
                                    <p><?php echo substr($data['deskripsi'], 0, 30)."..."; ?></p>
                                </div>
                                <div class="card-typical-section">
                                    <div class="card-typical-linked">oleh <a href="#"><?php echo $data['nama_user']; ?></a></div>
                                    <!-- <a href="#" class="card-typical-likes">
                                        <i class="font-icon font-icon-heart"></i>
                                        123
                                    </a> -->
                                </div>
                            </article><!--.card-typical-->
                        </div>
                        </div>
                        <?php
                            }
                            

                        ?>
                        <!-- Selesai Buku Content -->
                        
                        <div class="col-lg-12" align="center">
                            <?php
                                // $classMedia->PaggingSearch(isset($_GET['page']) ? $_GET['page'] : 1,$text);
                            ?>
                        </div>
                    </div>
                        
                    </div>
                </div><!--.row-->
            </div>
        </div>
     <?php
    }else{
        echo "<script>document.location.href='index.php'</script>";
    }
?> 



<?php
    include "include/footer.php";
?>