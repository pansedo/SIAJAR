<aside id="menu-fixed" class="profile-side" style="margin: 0 0 20px">
    <section class="box-typical">
        <header class="box-typical-header-sm bordered">
            <a href="kelas.php?id=<?=$infoKelas['_id']?>" class="pull-right" title="Kelas" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Kembali ke halaman kelas"><i class="font-icon font-icon-answer" style="color: #3ac9d6;"></i></a>Menu
        </header>
        <div class="box-typical-inner">
            <ul class="side-menu-list">
                <li class="blue <?php if($menuMapel==1){echo 'opened';} ?>">
                    <a href="mapel.php?id=<?=$_GET['id']?>">
                        <i class="font-icon font-icon-home <?php if($menuMapel==1){echo 'active';} ?>"></i>
                        <span class="lbl">Silabus</span>
                    </a>
                </li>
                <li class="blue <?php if($menuMapel==2){echo 'opened';} ?>">
                    <a href="mapel.php?id=<?=$_GET['id']?>">
                        <i class="glyphicon glyphicon-book <?php if($menuMapel==2){echo 'active';} ?>"></i>
                        <span class="lbl">Pelajaran</span>
                    </a>
                </li>
                <li class="blue <?php if($menuMapel==3){echo 'opened';} ?>">
                    <a href="perkembangan.php?id=<?=$_GET['id']?>">
                        <i class="font-icon font-icon-zigzag <?php if($menuMapel==3){echo 'active';} ?>"></i>
                        <span class="lbl">Perkembangan</span>
                    </a>
                </li>
            </ul>
        </div>
    </section>

</aside><!--.profile-side-->
