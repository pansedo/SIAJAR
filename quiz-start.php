<?php
    session_start();

    include 'setting/connection.php';
    spl_autoload_register(function ($class) {
      include 'setting/controller/' .$class . '.php';
    });

    $quizClass 	= new Quiz();
    $soalClass 	= new Soal();

    $infoQuiz	= $quizClass->getInfoQuiz($_GET['id']);
    $duration   = $infoQuiz['durasi'];

    $_SESSION["duration"]       = $duration;
    $_SESSION["start_time"]     = date("Y-m-d H:i:s");

    $end_time   = date("Y-m-d H:i:s", strtotime('+'.$_SESSION["duration"].'minutes', strtotime($_SESSION["start_time"])));

    $_SESSION["end_time"]   = $end_time;
?>
<script type="text/javascript">
    window.location = "quiz.php?id=<?php echo $_GET['id']; ?>";
</script>
