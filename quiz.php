<?php
require("includes/header-top.php");
?>

<link rel="stylesheet" href="./assets/css/separate/vendor/blockui.min.css">

<?php
require("includes/header-menu.php");

$quizClass 	    = new Quiz();
$soalClass 	    = new Soal();

$infoQuiz	    = $quizClass->getInfoQuiz($_GET['id']);
$idModul        = $infoQuiz['id_modul'];

if(isset($_GET['paket'])){
    $list_soal      = $soalClass->getListSoalbyQuiz($_GET['paket']);
    $jumlah_soal    = $soalClass->getNumberbyQuiz($_GET['paket']);
}

if(!isset($_SESSION["start_time"])){
    header( "Location: create-quiz.php?modul=$idModul");
}

if(isset($_GET['submit'])){
    unset($_SESSION["start_time"]);
    unset($_SESSION["end_time"]);
    unset($_SESSION["duration"]);

    $nilaiQuiz      = $quizClass->hitungNilaiQuiz($_SESSION['lms_id'], $_GET['id'], $jumlah_soal);
    $quizClass->submitQuiz((string)$_SESSION['lms_id'], $_GET['id'], $nilaiQuiz);

    header( "Location: create-quiz.php?modul=$idModul");
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
												<p class="title"><?=$infoQuiz['nama']?></p>
												<p>Sisa Waktu <span id="timer"></span></p>
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
                <?php
                    $no_soal = 1;
                    foreach ($list_soal as $soal) {
                        $jawaban_user = $soalClass->getOpsiJawabanUser($_SESSION['lms_id'], $_GET['id'], $soal['_id']);
                ?>
                    <section class="card card-default">
                        <div class="card-block">
                            <h5 class="with-border">Nomor <?=$no_soal?><span class="pull-right"><?=$no_soal?> / <?=$jumlah_soal?></span></h5>
                            <p id="soal"><?php echo $soal["soal"];?></p>
                            <?php
                                $list_opsi_soal = $soalClass->getListOpsiSoal($soal['_id']);
                                foreach ($list_opsi_soal as $opsi_soal) {
                            ?>
                            <div class="radio">
                                <input type="radio" name="<?=$soal['_id']?>" id="<?=$opsi_soal['_id']?>" value="<?=$opsi_soal['_id']?>" onclick="save_answer('<?=$_GET['id']?>', '<?=$soal['_id']?>', '<?=$opsi_soal['_id']?>');"
                                <?php if($opsi_soal['_id'] == $jawaban_user['id_opsi_soal']){echo "checked";} ?>
                                >
                                <label for="<?=$opsi_soal['_id']?>"><?=$opsi_soal['text']?></label>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </section>
                <?php
                        $no_soal++;
                    }
                ?>
                <div class="form-group pull-right">
                    <button id="submit" type class="btn btn-rounded btn-primary">Kumpulkan</button>
                </div>
				</div>
			</div><!--.row-->

		</div><!--.container-fluid-->
	</div><!--.page-content-->

<?php
	require('includes/footer-top.php');
?>

	<script>
        window.onbeforeunload = function() {
            return "Leaving this page will reset the wizard";
        };

		$(document).ready(function() {
			$('.note-statusbar').hide();
		});

        setInterval(function(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "response.php", false);
            xmlhttp.send(null);
            document.getElementById("timer").innerHTML   = xmlhttp.responseText;
            if(xmlhttp.responseText == "00:00:00"){
                swal({
                    title: "Maaf",
                    text: "Waktu Anda Sudah Habis!",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonText: "Ya",
                    confirmButtonClass: "btn-primary",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    allowEscapeKey: false
                }, function () {
                    window.onbeforeunload = null;
                    document.location.href="quiz.php?id=<?php echo $_GET['id']; ?>&submit=1";
                });
            }
        }, 1000);

        function save_answer(id_quiz, id_soal, id_opsi_soal){

            $.ajax({
                url: "url-API/Kelas/Modul/Quiz/",
                type: 'POST',
                data: {"action": "saveAnswer", "id_quiz": id_quiz, "id_soal": id_soal, "id_opsi_soal": id_opsi_soal},
                success: function (data) {
                }
            });
        }

        $('#submit').on('click', function() {
            swal({
                title: "Apakah anda yakin?",
                text: "Akan Mengumpulkan Sekarang!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Tidak",
                confirmButtonText: "Ya",
                confirmButtonClass: "btn-primary",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                window.onbeforeunload = null;
                document.location.href="quiz.php?id=<?php echo $_GET['id']; ?>&paket=<?php echo $_GET['paket']; ?>&submit=1";
            });
        });

        $('#next-soal').on('click', function() {
            // $('#block-soal').block({
            //     message: '<div class="blockui-default-message"><i class="fa fa-circle-o-notch fa-spin"></i><h6>Mohon Tunggu</h6></div>',
            //     overlayCSS:  {
            //         background: 'rgba(24, 44, 68, 0.8)',
            //         opacity: 1,
            //         cursor: 'wait'
            //     },
            //     css: {
            //         width: '50%'
            //     },
            //     blockMsgClass: 'block-msg-default'
            // });

            $.ajax({
                type: 'POST',
                url: 'url-API/Kelas/Modul/Quiz/',
                data: {"action": "showSoal", "ID": $("#id-soal").text()},
                success: function(res) {
                    alert("Soalnya: "+res);
                    $("#block-soal").load("quiz.php #block-soal");
                },
                error: function () {
                    alert("gagal");
                }
            });
        });

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
    <script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-MML-AM_CHTML">
    </script>
    <script type="text/javascript" src="./assets/js/lib/blockUI/jquery.blockUI.js"></script>

<?php
	require('includes/footer-bottom.php');
?>
