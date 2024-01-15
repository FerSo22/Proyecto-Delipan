<?php
    require_once("../include/config.php");

    if(isset($_POST["action"])) {
        $action = $_POST["action"];

        switch($action) {
            case "searchSingleReceipt":
                verifyReceipText();
                break;
            case "getAllReceipts":
                requestAllReceipts();
                break;
            case "updateStateReceipt":
                updateStateReceipt();
                break;
        }
    }

    function sendResponse($res) {
        $json = array($res);
        $jsonString = json_encode($json);
    
        echo $jsonString;

        exit();
    }

    function verifyReceipText() {
        if(isset($_POST["id"])) {
            $id = $_POST["id"];

            if(strlen($id) == 0) {
                $response = "Ingrese el número de boleta";
                
                sendResponse($response);
            } else if(!preg_match(VALID_NUMBERS, $id)) {
                $response = "Se detectaron caracteres no válidos";
                
                sendResponse($response);
            } else {
                include_once("./ControlAtenderBoleta.php");
                $OBJControlAtenderBoleta = new ControlAtenderBoleta;
                $response[0] = false;
                $response[1] = $OBJControlAtenderBoleta -> searchReceipt($id, 1);

                if($response[0] == $response[1]) {
                    $response = "Boleta no encontrada o ya se encuentra atendida";
                } else {
                    $response[0] = true;
                }

                sendResponse($response);
            }
        }
    }

    function requestAllReceipts() {
        include_once("./ControlAtenderBoleta.php");
        $OBJControlAtenderBoleta = new ControlAtenderBoleta;
        $response = $OBJControlAtenderBoleta -> searchReceipt(null, 2);

        sendResponse($response);
    }

    function updateStateReceipt() {
        $id = $_POST["id"]; 

        include_once("./ControlAtenderBoleta.php");
        $OBJControlAtenderBoleta = new ControlAtenderBoleta;
        $response = $OBJControlAtenderBoleta -> updateStateReceipt($id);

        if(!$response) {
            $response = "Ocurrió un error al atender la boleta";
        }

        sendResponse($response);
    }

?>