<aside id="menu-fixed" class="profile-side" style="margin: 0 0 20px">
	<section class="box-typical">
		<header class="box-typical-header-sm bordered">
			<a href="mapel.php?id=<?=$infoMapel['_id']?>" class="pull-right" title="Mata Pelajaran" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Kembali ke halaman mata pelajaran"><i class="font-icon font-icon-answer" style="color: #3ac9d6;"></i></a><?=$infoModul['nama']?>
		</header>
		<div class="box-typical-inner">
			<ul class="side-menu-list">
				<!-- <li class="blue <?php if($menuModul==1){echo 'opened';} ?>">
					<a href="prasyarat.php?modul=<?=$_GET['id']?>">
		                <i class="font-icon font-icon-home <?php if($menuModul==1){echo 'active';} ?>"></i>
		                <span class="lbl">Prasyarat</span>
		            </a>
				</li> -->
				<li class="blue <?php if($menuModul==2){echo 'opened';} ?>">
		            <a href="modul.php?modul=<?=$_GET['modul']?>">
		                <i class="fa fa-book <?php if($menuModul==2){echo 'active';} ?>"></i>
		                <span class="lbl">Materi</span>
		            </a>
		        </li>
				<li class="blue <?php if($menuModul==3){echo 'opened';} ?>">
					<a href="tugas.php?modul=<?=$_GET['modul']?>">
						<i class="fa fa-file-text-o <?php if($menuModul==3){echo 'active';} ?>"></i>
						<span class="lbl">Tugas</span>
					</a>
				</li>
				<li class="blue <?php if($menuModul==4){echo 'opened';} ?>">
					<a href="create-quiz.php?modul=<?=$_GET['modul']?>">
						<i class="font-icon font-icon-notebook <?php if($menuModul==4){echo 'active';} ?>"></i>
						<span class="lbl">Ujian</span>
					</a>
				</li>
				<li class="blue <?php if($menuModul==5){echo 'opened';} ?>">
					<a href="modul-diskusi.php?modul=<?=$_GET['modul']?>">
						<i class="font-icon font-icon-comments <?php if($menuModul==5){echo 'active';} ?>"></i>
						<span class="lbl">Diskusi</span>
					</a>
				</li>
			</ul>
		</div>
	</section>

</aside><!--.profile-side-->
