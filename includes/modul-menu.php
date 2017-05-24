<aside id="menu-fixed" class="profile-side" style="margin: 0 0 20px">
	<section class="box-typical">
		<header class="box-typical-header-sm bordered">
			<?=$infoModul['nama']?>
		</header>
		<div class="box-typical-inner">
			<ul class="side-menu-list">
				<li class="blue <?php if($menuModul==1){echo 'opened';} ?>">
					<a href="prasyarat.php?id=<?=$_GET['id']?>&pelajaran=<?=$_GET['pelajaran']?>">
		                <i class="font-icon font-icon-home <?php if($menuModul==1){echo 'active';} ?>"></i>
		                <span class="lbl">Prasyarat</span>
		            </a>
				</li>
				<li class="blue <?php if($menuModul==2){echo 'opened';} ?>">
		            <a href="materi.php?id=<?=$_GET['id']?>&pelajaran=<?=$_GET['pelajaran']?>">
		                <i class="font-icon font-icon-notebook <?php if($menuModul==2){echo 'active';} ?>"></i>
		                <span class="lbl">Materi</span>
		            </a>
		        </li>
				<li class="blue <?php if($menuModul==3){echo 'opened';} ?>">
					<a href="#">
						<i class="font-icon font-icon-zigzag <?php if($menuModul==3){echo 'active';} ?>"></i>
						<span class="lbl">Tugas</span>
					</a>
				</li>
				<li class="blue <?php if($menuModul==4){echo 'opened';} ?>">
					<a href="#">
						<i class="font-icon font-icon-zigzag <?php if($menuModul==4){echo 'active';} ?>"></i>
						<span class="lbl">Kuis</span>
					</a>
				</li>
			</ul>
		</div>
	</section>

</aside><!--.profile-side-->
