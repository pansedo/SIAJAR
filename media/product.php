<?php
	include "include/header.php";
	?>
	<script type="text/javascript" src="./assets/tinymce4/js/tinymce/tinymce.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

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
         toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
         toolbar2: "| link unlink anchor | image media | forecolor backcolor | print preview | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry",
         image_advtab: true
        });
</script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script> -->

<!-- Style for html code -->
<link type="text/css" rel="stylesheet" href="./assets/tinymce4/css/prism.css" />
	<?php
	include 'include/menu.php';

	$classMedia = new Media(); 
	$classTag = new Tag();
	$classProfile = new Profile();
	$classKategori = new Kategori();
	$classPengaduan = new Pengaduan();
	$classRating = new Rating(); 

	if (isset($_POST['reportdokumen'])) {
		$iddokumen = mysql_escape_string($_POST['iddokumen']);
		$keterangan = mysql_escape_string($_POST['keterangan']);

		$classPengaduan->CreatePengaduan($iddokumen,$keterangan,$id_users);
	}
 
	if (isset($_GET['id'])) { 
		# code...
		$id 			= base64_decode($_GET['id']);
		$getMediaById 	= $classMedia->GetMediaBy($id); 
		$getTagByMedia 	= $classTag->TagByMedia($id);
		$getUserById 	= $classProfile->GetData($getMediaById['id_user']);
		$getKategori 	= $classKategori->getkategoriutamabyId($getMediaById['id_kategori']);
		$FuncProfile = $classProfile->GetData($getMediaById['id_user']);
		$getRating = $classRating->GetRatingBy($getMediaById['_id']);
	
?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3">
					<section class="box-typical">
						<div class="profile-card">
							<div class="profile-card-photo">
								<img src="Assets/foto/<?php if ($getUserById['foto'] != NULL) {echo $getUserById['foto'];}else{echo "no_picture.png";} ?>" alt=""/>
							</div>
							<div class="profile-card-name"><?php echo $getUserById['nama'];?></div>
							<div class="profile-card-location"><?php echo $getUserById['sekolah'];?></div>
						</div>
						<section class="proj-page-section proj-page-labels">
							<ul class="profile-links-list">
								<li class="nowrap">
									<i class="font-icon font-icon-earth-bordered"></i> 
									<a href="#"><?php echo $FuncProfile['sosmed']['website'];?></a>
								</li>
								<li class="nowrap">
									<i class="font-icon font-icon-fb-fill"></i> 
									<a href="#"><?php echo $FuncProfile['sosmed']['facebook'];?></a>
								</li>
								<li class="nowrap">
									<i class="font-icon font-icon-calend"></i> 
									<a href="#"><?php echo selisih_waktu($FuncProfile['date_created']);?></a>
								</li> 
							</ul>
						</section>

						<section class="proj-page-section proj-page-labels">
							<header class="proj-page-subtitle padding-sm">
								<h3>Tag</h3>
							</header>
							<?php
								foreach ($getTagByMedia as $datatag) { 
									echo "<a href='searchtag.php?tag=".$datatag['nama']."' class='label label-light-grey'>".$datatag['nama']."</a>";
								} 
							?>
						</section>
						<?php
							if (isset($id_users)) {
								?>
								<section class="proj-page-section proj-page-labels">
									<center>
										<button type="button" class="btn btn btn-inline btn-danger" data-toggle="modal" data-target="#myModal">
											Report Dokumen
										</button>
									</center>
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<form  action="#" method="POST" role="form" enctype="multipart/form-data">
										  <div class="modal-dialog" role="document">
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h4 class="modal-title" id="myModalLabel"><?php echo $getMediaById['judul'];?></h4>
										      </div>
										      <div class="modal-body">
										      	<p> Dokumen akan di report bila tidak sesuai dengan bahan ajar pendidikan dan menyalah gunakan aturan </p>
												<textarea class="form-control" name="keterangan" style=" width:100%; height:200px" placeholder="Alasan Report Media : <?php echo $getMediaById['judul'];?> "></textarea>
										      </div>
										      <div class="modal-footer">
												<input type="hidden" name="iddokumen" value="<?php echo $getMediaById['_id'];?>">
										        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-default btn-danger" name="reportdokumen" value="nonactive" >Adukan Dokumen</button>
										      </div>
										    </div>
										  </div>
										</form>
									</div>
								</section>
								<?php
							}
						?>
						
					</section>

				</div>
				<div class="col-lg-9">
					<section class="box-typical proj-page">
						<div align="center">
						<img src="<?php echo $getMediaById['path_image'];?>" style="width:300px; height:400px;">
						</div>
						<section class="proj-page-section proj-page-header">
							<div class="tbl proj-page-team">
								<div class="tbl-row">
									<div class="tbl-cell">
									<div class="row">
										<div class="col-lg-7">
											<div class="title">
												<h2><?php echo $getMediaById['judul'];?></h2>
											</div>
										</div>
										<div class="col-lg-5" style="text-align: right;">
											<div class="title" >
												<div class="sharebox" data-services="facebook google+ tumblr twitter">&nbsp<button class="btn btn-default btn-sm"onclick="CopyLink()">Copy Link</button>&nbsp</div>
												  </ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>

						<section class="proj-page-section">
							<div class="tbl proj-page-team">
								<div class="tbl-row">
									<div class="tbl-cell .col-lg-7">
										<div class="project">Kategori:
										<?php
											foreach ($getKategori as $dataKategori) {
											echo "<a href='#'>".$dataKategori['kategori']."</a>";
										}?>
										</div>
									</div>
									<div class="tbl-cell .col-lg-3" style="text-align: right;">
									 <fieldset id='rate' class="rating" <?php if (is_null($id_users)) { echo 'disabled'; }  ?>>
				                        <input class="stars" type="radio" id="star5" name="rating" value="5" <?=$getRating==5?'checked':'';?> /> 
				                        <label class = "full" for="star5" title="Sangat Bagus - 5 Bintang"></label>
				                        <input class="stars" type="radio" id="star4" name="rating" value="4" <?=$getRating==4?'checked':'';?> /> 
				                        <label class = "full" for="star4" title="Bagus - 4 Bintang"></label>
				                        <input class="stars" type="radio" id="star3" name="rating" value="3" <?=$getRating==3?'checked':'';?> /> 
				                        <label class = "full" for="star3" title="Biasa - 3 Bintang"></label>
				                        <input class="stars" type="radio" id="star2" name="rating" value="2" <?=$getRating==2?'checked':'';?> /> 
				                        <label class = "full" for="star2" title="Kurang - 2 Bintang"></label>
				                        <input class="stars" type="radio" id="star1" name="rating" value="1" <?=$getRating==1?'checked':'';?> /> 
				                        <label class = "full" for="star1" title="Sangat Kurang - 1 Bintang"></label>
				                    </fieldset>
				                    <script type="text/javascript">
					                    $(document).ready(function () {
					                    	$("#rate .stars").click(function () {
									            $.post('url/rating.php',{rate:$(this).val(), iddokumen: "<?php echo $getMediaById['_id']?>",idusers:"<?php echo $id_users ?>"},function(d){
								                    alert(d);
								                    location.reload();
									            });
									            $(this).attr("checked");
									        });
								        });
				                    </script>
									</div>
									<!-- <div class="tbl-cell tbl-cell-date">3 days ago - 23 min read</div> -->
								</div>
							</div>

						</section><!--.proj-page-section-->

						<section class="proj-page-section">
							<div class="proj-page-txt">
								<p><?php echo $getMediaById['deskripsi'];?></p>
							</div>
						</section>

						<section class="proj-page-section">
						<?php
							$date = date_create($getMediaById['date_created']);
							if ($getMediaById['path_document'] != "") {
								# code...
							
						?>
							<header class="proj-page-subtitle">
								<h3>Attachments</h3>
							</header>
							<div class="proj-page-attach">
							<?php
								$dataExt = explode(".", $getMediaById['path_document']);
								$ext = (count($dataExt) - 1);
								// echo $dataExt[$ext];
								$ekstensi = strtolower($dataExt[$ext]);
								$format = array("jpg", "jpeg", "png", "gif", "bmp", "pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx", "mp4", "3gp", "flv", "avi", "mp3", "ogg");
								$video = array("mp4", "3gp", "flv", "avi");
								$musik = array("mp3", "ogg");
								$gambar = array("jpg", "jpeg", "png", "gif", "bmp");
								if ($ekstensi == "pdf") {
									echo "<i class='font-icon fa fa-file-pdf-o'></i>";
								}else if ($ekstensi == "doc" || $ekstensi == "docx") {
									# code...
									echo "<i class='font-icon fa fa-file-word-o'></i>";
								}else if (in_array($ekstensi, $gambar)) {
									# code...
									echo "<i class='font-icon fa fa-file-picture-o'></i>";
								}else if (in_array($ekstensi, $musik)) {
									# code...
									echo "<i class='font-icon fa fa-file-audio-o'></i>";
								}else if ($ekstensi == "xls" || $ekstensi == "xlsx") {
									# code...
									echo "<i class='font-icon fa fa-file-excel-o'></i>";
								}else if ($ekstensi == "ppt" || $ekstensi == "pptx") {
									# code...
									echo "<i class='font-icon fa fa-file-powerpoint-o'></i>";
								}else if (in_array($ekstensi, $video)) {
									# code...
									echo "<i class='font-icon fa fa-file-movie-o'></i>";
								}else{
									echo "<i class='font-icon fa fa-file'></i>";
									
								}

								
							?>
								
								
								<p class="name"><?php echo $getMediaById['judul'];?>.<?php echo $ekstensi;?></p>
								<p class="date"><?php echo date_format($date,'d-m-Y H:i:s');?></p>
								<p>
									<!-- <a href="#">View</a> -->
									<a href="<?php echo $getMediaById['path_document'];?>"  download="<?php echo $getMediaById['judul'];?>.<?php echo $ekstensi;?>">Download</a>
									<a onclick="copyToClipboard('<?php echo $_SERVER['HTTP_HOST']."/siajar/media/".$getMediaById['path_document']; ?>')">Lampirkan</a>
								</p>
							</div>
					<?php
						}
						if($getMediaById['tautan'] != ""){
							if (substr($getMediaById['tautan'], 0,4) == "http"){
								$http = "";
							}else{
								$http = "http://";
							}
					?>
						<header class="proj-page-subtitle">
								<h3>Link</h3>
							</header>
							<div class="proj-page-attach">
							
								<i class='font-icon fa fa-link'></i>								
								<p class="name"><?php echo $getMediaById['judul'];?></p>
								<p class="date"><?php echo date_format($date,'d-m-Y H:i:s');?></p>
								<p>
									<a href="<?php echo $http;echo $getMediaById['tautan'];?>" target="_blank">View</a>
									<a onclick="copyToClipboard('<?php echo $http;echo $getMediaById['tautan'];?>')">Lampirkan</a>
									
								</p>
							</div>
					<?php
						}	
					?>

						</section><!--.proj-page-attach-section-->

					</section>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	function copyToClipboard(url) {
	        var textArea = document.createElement("textarea");
	        textArea.style.background = 'transparent';
	        textArea.value = url;
	        document.body.appendChild(textArea);
	        textArea.select();
	        try {
	            var successful = document.execCommand('copy');
	            swal({
				  title: 'Berhasil !',
				  text: 'Link Berhasil Di Copy!',
				  type: 'success',
				  timer: 2000
				})
	        } catch (err) {
	            console.log('Oops, unable to copy');
	        }
	        document.body.removeChild(textArea);
	    } 
	function Lampirkan(url){
		var link = url;
		copyToClipboard(""+link);
	}
	</script>

<?php
}
	include "include/footer.php";
?>