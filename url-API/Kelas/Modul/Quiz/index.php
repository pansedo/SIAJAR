<?php
session_start();
require("../../../../setting/connection.php");

$method	= $_REQUEST;

if(isset($method['action'])){

    if($method['action'] == 'saveAnswer'){

        $opsi_soal  = $db->opsi_soal->findOne(array("_id" => new MongoId($_POST['id_opsi_soal'])));
        $status     = $opsi_soal['status'];

        $update     = array('$set' => array("id_opsi_soal" => $_POST['id_opsi_soal'], "status" => $status, "date_modified"=>date('Y-m-d H:i:s')));

        try {

            $db->jawaban_user->update(array("id_user" => (string)$_SESSION['lms_id'], "id_quiz" => $_POST['id_quiz'], "id_soal" => $_POST['id_soal']), $update, array("upsert" => true));
            $status     = "Success";
        } catch(MongoCursorException $e) {

            $status     = "Failed";
        }

        echo $status;
	}
}

?>
