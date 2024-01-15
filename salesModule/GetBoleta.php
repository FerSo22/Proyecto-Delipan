<?php
    require_once("../include/config.php");
    @session_start();

    if(isset($_GET["idReceipt"])) {
        if(!session_status() == PHP_SESSION_NONE && !empty($_SESSION)) {
            $id = $_GET["idReceipt"];

            include_once("./ControlBoleta.php");
            $OBJControlBoleta = new ControlBoleta;
            $OBJControlBoleta -> renderReceipt($id);
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