<?php   
    require_once("../include/config.php");

    if(isset($_POST["action"])) {
        $action = $_POST["action"];

        switch($action) {
            case "loadFormReceiptsReport":
                loadFormReceiptsReport();
                break;
            case "loadFormCashReport":
                loadFormCashReport();
                break;
            case "loadFormCashTally":
                loadFormCashTally();
                break;
            case "verifyNewReceiptsReport";
                verifyNewReceiptsReport();
                break;
            case "verifyCashReportData":
                verifyCashReportData();
                break;
            case "verifyCashTallyData":
                verifyCashTallyData();
                break;
            case "verifyExistingCashReport":
                verifyExistingCashReport();
                break;
            case "verifyExistingReceiptsReport";
                verifyExistingReceiptsReport();
                break;
        }
    }

    function sendResponse($res) {
        $json = array($res);
        $jsonString = json_encode($json);
    
        echo $jsonString;

        exit();
    }

    function loadFormReceiptsReport() {
        include_once("./ControlCierreCaja.php");
        $OBJControlCierreCaja = new ControlCierreCaja;
        $OBJControlCierreCaja -> renderFormReceiptsReport();
    }

    function loadFormCashReport() {
        include_once("./ControlCierreCaja.php");
        $OBJControlCierreCaja = new ControlCierreCaja;
        $OBJControlCierreCaja -> renderFormCashReport();
    }

    function loadFormCashTally() {
        include_once("./ControlCierreCaja.php");
        $OBJControlCierreCaja = new ControlCierreCaja;
        $OBJControlCierreCaja -> renderFormCashtTally();
    }

    function verifyNewReceiptsReport() {
        include_once("./ControlCierreCaja.php");
        $OBJControlCierreCaja = new ControlCierreCaja;
        $response = $OBJControlCierreCaja -> insertReceiptsReport();

        if(empty($response)) {
            $response = "No es posible generar el reporte si no hay boletas";
        } else if(!$response) {
            $response = "Ocurrió un error al registrar los datos";
        } else {
            $response = "successful";
        }

        sendResponse($response);
    }

    function verifyCashReportData() {
        $response = "";

        if(isset($_POST["amountsDenominations"]) && isset($_POST["totalAmount"])) {
            $amountsDenominations = $_POST["amountsDenominations"];
            $totalAmount = $_POST["totalAmount"];

            // print_r($amountsDenominations);
            foreach($amountsDenominations as $amount) {
                if(strlen($amount["quantity"]) == 0) {
                    $response = "Uno o más campos se encuentran vacíos";

                    sendResponse($response);
                } else if(!preg_match(VALID_NUMBERS, $amount["quantity"])) {
                    $response = "Se encontraron caracteres no válidos en uno o más campos";

                    sendResponse($response);
                }
            }

            if($totalAmount == 0) {
                $response = "El total debe ser mayor a cero";

                sendResponse($response);
            } else {
                include_once("./ControlCierreCaja.php");
                $OBJControlCierreCaja = new ControlCierreCaja;
                $response = $OBJControlCierreCaja -> insertCashReportData($amountsDenominations, $totalAmount);

                if($response) {
                    $response = "successful";
                } else {
                    $response = "Ocurrió un error al registrar los datos";
                }

                sendResponse($response);
            }
        }
    }

    function verifyCashTallyData() {
        $response = "";

        if(isset($_POST["reason"])) {
            $reason = trim($_POST["reason"]);

            if(preg_match(INVALID_CHARS, $reason) || preg_match(KEYWORDS, $reason)) {
                $response = "Se detectaron caracteres no válidos";

                sendResponse($response);
            } else if(strlen($reason) > 500) {
                $response = "El texto ingresado no debe superar los 500 caracteres";

                sendResponse($response);
            } else {
                include_once("./ControlCierreCaja.php");
                $OBJControlCierreCaja = new ControlCierreCaja;

                $response = $OBJControlCierreCaja -> insertCashTallyData($reason);

                if($response) {
                    $response = "successful";
                } else {
                    $response = "Ocurrió un error al registrar los datos";
                }
                
                sendResponse($response);
            }
        }
    }

    function verifyExistingCashReport() {
        include_once("./ControlCierreCaja.php");
        $OBJControlCierreCaja = new ControlCierreCaja;
        $response = $OBJControlCierreCaja -> searchExistingCashReport();

        if($response != false) {
            $response = true;
        }

        sendResponse($response);
    }

    function verifyExistingReceiptsReport() {
        include_once("./ControlCierreCaja.php");
        $OBJControlCierreCaja = new ControlCierreCaja;
        $response = $OBJControlCierreCaja -> searchExistingReceiptsReport();

        if($response != false) {
            $response = true;
        }

        sendResponse($response);
    }
?>