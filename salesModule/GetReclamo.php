<?php
    require_once("../include/config.php");
    @session_start();

    if(isset($_GET["idReceipt"])) {
        if(isset($_SESSION["user"])) {
            $idReceipt = $_GET["idReceipt"];

            include_once("./ControlReclamo.php");
            $OBJControlReclamo = new ControlReclamo;
            $OBJControlReclamo -> renderComplaint($idReceipt);
        } else {
            denyAccess();
        }
    }

    function denyAccess() {
        include_once("../include/systemMessage.php");
        $OBJSystemMessage = new SystemMessage;
        $OBJSystemMessage -> showSystemMessage();
    }

?>