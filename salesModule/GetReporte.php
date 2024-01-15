<?php   
    require_once("../include/config.php");
    @session_start();

    if(isset($_GET["dateReport"]) && isset($_GET["typeReport"])) {
        if(isset($_SESSION["user"])) {
            include_once("./ControlReporte.php");
            $OBJControlReporte = new ControlReporte;

            $typeReport = $_GET["typeReport"];
            $dateReport = $_GET["dateReport"];

            switch($typeReport) {
                case 1:
                    $OBJControlReporte -> renderReceiptsReport($dateReport);
                    break;
                case 2:
                    $OBJControlReporte -> renderCashReport($dateReport);
                    break;
                case 3:
                    $OBJControlReporte -> renderTallyCashReport($dateReport);
                    break;
            }
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