<?php
require("includes/header-top.php");
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
require("includes/header-menu.php");

$mapelClass 	= new Mapel();
$modulClass 	= new Modul();
$materiClass    = new Materi();
$soalClass 	= new Soal();
$quizClass  = new Quiz();

$menuModul		= 2;
$infoQuiz   = $quizClass->getInfoQuiz($_GET['qz']);
if (isset($_GET['md'])) {
  $infoModul		= $modulClass->getInfoModul($_GET['md']);
  $infoMapel    = $mapelClass->getInfoMapel($infoModul['id_mapel']);
}
if (isset($_GET['id'])) {
  # code...
  $infoSoal = $soalClass->getInfoSoal($_GET['id']);
$listJawaban = $soalClass->getListJawaban($_GET['id']);
}


if(isset($_POST['updateQuiz'])){
    // print_r($_POST);
    $soal       = $_POST['soal'];
    $jawaban    = $_POST['jawaban'];
    $benar      = $_POST['benar'];

// print_r($benar);
    if (isset($_GET['id'])) {
      $id_paket = $_GET['qz'];
    }else{
      $id_paket = $infoQuiz['id_paket'];
    }
    $rest = $soalClass->updateSoal($_GET['id'],$soal,$jawaban,$benar,$id_paket, $_SESSION['lms_id']);

    echo "string ".$rest['status'];
    if ($rest['status'] == "Sukses") {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        if (isset($_GET['md'])) {
          # code...
          echo "<script>alert('".$rest['status']."'); document.location='quiz-action.php?act=update&md=".$_GET['md']."&qz=".$_GET['qz']."'</script>";
        }else if (isset($_GET['id'])) {
          # code...
          echo "<script>alert('".$rest['status']."'); document.location='paket-detail.php?id=".$_GET['qz']."'</script>";
        }
        
    }else{
        echo "<script>alert('Gagal Update'".$rest['status'].")</script>";
    }
}

if(isset($_POST['addQuiz'])){
  // print_r($_POST);
  $soal     = $_POST['soal'];
  $jawaban  = $_POST['jawaban'];
  $benar    = $_POST['benar'];

// print_r($benar);
  $soalClass->addSoal($soal,$jawaban,$benar,$infoQuiz['id_paket'], $_SESSION['lms_id']);
}


?>
	<div class="page-content">
		<div class="profile-header-photo">
			<div class="profile-header-photo-in">
				<div class="tbl-cell">
					<div class="info-block">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="tbl info-tbl">
										<div class="tbl-row">
											<div class="tbl-cell">
												<p class="title"><?php if (isset($_GET['md'])) {?>Modul <?=$infoModul['nama']; }?></p>
												<p><?php if (isset($_GET['md'])) {?>Mata Pelajaran <?=$infoMapel['nama']; }?></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--.profile-header-photo-->

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<section class="card card-default">
                    <?php
                        if (isset($_GET['act']) && isset($_GET['id']) && ($_GET['act'] == 'update')) {
                    ?>
                        <div class="card-block">
                            <h5 class="with-border" >Perbarui Soal</h5>
                           <form id="form_tambah" method="POST">
                                <div class="modal-body">
                                    <fieldset class="form-group">
                                        <label class="form-label semibold" for="exampleInput">Soal</label>
                                     <textarea class ="myeditablediv" name="soal" ><?=$infoSoal['soal']?></textarea>
                                    </fieldset>
                                    <label class="form-label semibold" for="exampleInput">Jawaban</label>
                                    <hr />
                                    <?php 
                                    $i = 0;
                                    foreach ($listJawaban as $jawaban) {
                                      $i= $i + 1;

                                    ?>
                                    <fieldset class="form-group">
                                       <label class="form-label " for="exampleInput">Pilhan <?=$i;?></label>
                                        <textarea class ="myeditablediv" name="jawaban[]" ><?=$jawaban['text'];?></textarea>
                                        Atur Jawaban Benar <input type="radio" name="benar" value="0" <?php if($jawaban['status'] == "benar"){echo "checked";} ?>>
                                    </fieldset>
                                    <?php
                                    }
                                    ?>
                                    <div class ="opsitambahan">
                                        
                                    </div>
                                    <a style="align:right;color:#009dff;" id="tambahopsi" onclick="tambahOpsi();">+ Tambah Pilihan</a>
                                    <br />
                                    <br />
                                    
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="updateQuiz" value="send" class="btn btn-rounded btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                            </form>
                        </div>
                    <?php
                        }else {
                    ?>
						<div class="card-block">
              <h5 class="with-border" >Penambahan Soal</h5>
              <form id="form_tambah" method="POST">
                <div class="modal-header">
                  <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                  </button>
                  <h4 class="modal-title" id="addModulLabel">Tambah Kuis</h4>
                </div>
                <div class="modal-body">
                  <fieldset class="form-group">
                    <label class="form-label semibold" for="exampleInput">Soal</label>
                    <textarea class ="myeditablediv" id="soal" name="soal" ></textarea>
                  </fieldset>
                  <label class="form-label semibold" for="exampleInput">Jawaban</label>
                  <hr />
                  <fieldset class="form-group">
                    <label class="form-label " for="exampleInput">Pilhan 1</label>
                    <textarea class ="myeditablediv" id="jawab1" name="jawaban[]" ></textarea>
                    Atur Jawaban Benar <input type="radio" name="benar" value="0" checked="checked">
                  </fieldset>
                  <fieldset class="form-group">
                    <label class="form-label " for="exampleInput">Pilihan 2</label>
                    <textarea class="myeditablediv" id="jawab2" name="jawaban[]" ></textarea>
                    Atur Jawaban Benar <input type="radio" name="benar" value="1">
                  </fieldset>
                  <div class ="opsitambahan">

                  </div>
                  <a style="align:right;color:#009dff;" id="tambahopsi" onclick="tambahOpsi();">+ Tambah Pilihan</a>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="addQuiz" value="send" class="btn btn-rounded btn-primary">Simpan</button>
                  <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Tutup</button>
                </div>
              </form>
						</div>
                    <?php
                        }
                    ?>
					</section>
				</div>
			</div><!--.row-->

		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	require('includes/footer-top.php');
?>
<script>
$(document).ready(function(){
    $("#hapuspilihan").click(function(){
      var id = this.id();
      alert('asdsadad');
        $("#asu").remove();
    });
});
</script>
	<script>
                var i = 2;
                var j = 1;
            function tambahOpsi(){
                    i = i+1;
                    j = j+1;
                // js.src = "./assets/tinymce4/js/tinymce/plugins/tiny_mce_wiris/integration/WIRISplugins.js?viewer=image";
                // js.src = "./assets/tinymce4/js/tinymce/tinymce.min.js";

                // $(".opsitambahan").append("<fieldset class='form-group'><label class='form-label' for='exampleInput'>Pilihan "+i+"</label><textarea class='myeditablediv' name='jawaban[]' ></textarea>Atur Jawaban Benar <input type='radio' name='benar' value='"+j+"'></fieldset>");
        $(".opsitambahan").append("<fieldset class='form-group' id='pilihan"+i+"'><label class='form-label' id="+i+" for='exampleInput'>Pilihan "+i+"</label><textarea class='myeditablediv' name='jawaban[]' ></textarea>Atur Jawaban Benar <input type='radio' name='benar' value='"+j+"'><br><a class='btn btn-warning' id='pilihan"+i+"' onclick='hapusOpsi("+i+");' name=''>x</a></fieldset>");

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

                

                
            }
        $("#form_tambah").submit(function(e){
            $("#editor").val(tinyMCE.get('editormce').getContent());
        });

		$(document).ready(function() {
			$('.note-statusbar').hide();
		});

    function hapusOpsi(a){
      var ab = '#pilihan'+a;
      // alert (ab);
      $(''+ab).remove();
    }

		function clearText(elementID){
			$(elementID).html("");
		}

		function remove(ID){
      		swal({
      		  title: "Apakah anda yakin?",
      		  text: "Data yang sudah dihapus tidak dapat dikembalikan!",
      		  type: "warning",
      		  showCancelButton: true,
			  	confirmButtonText: "Setuju!",
      			confirmButtonClass: "btn-danger",
      		  closeOnConfirm: false,
      		  showLoaderOnConfirm: true
      		}, function () {
      			$.ajax({
      				type: 'POST',
      				url: 'url-API/Kelas/Modul/Materi/',
      				data: {"action": "remv", "ID": ID},
      				success: function(res) {
						swal({
				            title: res.response,
				            text: res.message,
				            type: res.icon
				        }, function() {
				            location.reload();
				        });
      				},
      				error: function () {
      					swal("Gagal!", "Data tidak terhapus!", "error");
      				}
      			});
      		});
      	}
	</script>

	<script src="assets/js/app.js"></script>
    <script type="text/javascript" src="./assets/tinymce4/js/wirislib.js"></script>
	<script type="text/javascript" src="./assets/tinymce4/js/prism.js"></script>

<?php
	require('includes/footer-bottom.php');
?>
