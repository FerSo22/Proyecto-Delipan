<?php
    require_once("../include/config.php");

    if(isset($_POST["action"])) {
        $action = $_POST["action"];

        switch($action) {
            case "verifyReceipText":
                verifyReceipText();
                break;
            case "loadFormSubmitComplaint":
                loadFormSubmitComplaint();
                break;
            case "getReceiptDetails":
                getReceiptDetails();
                break;
            case "verifyComplaintData":
                verifyComplaintData();
                break;
        }
    }
    
    function sendResponse($res) {
        $json = array($res);
        $jsonString = json_encode($json);
    
        echo $jsonString;

        exit();
    }

    function loadFormSubmitComplaint() {
        $id = $_POST["id"];

        include_once("./ControlAtencionReclamo.php");
        $OBJControlAtencionReclamo = new ControlAtencionReclamo;
        $OBJControlAtencionReclamo -> renderFormSubmitComplaint($id);
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
                include_once("./ControlAtencionReclamo.php");
                $OBJControlAtencionReclamo = new ControlAtencionReclamo;
                $response[0] = false;
                $response[1] = $OBJControlAtencionReclamo -> searchReceipt($id);

                if($response[0] == $response[1]) {
                    $response = "Boleta no encontrada o no ha sido atendida";
                } else {
                    $response[0] = true;
                }

                sendResponse($response);
            }
        }
    }

    function getReceiptDetails() {
        if(isset($_POST["id"])) {
            $id = $_POST["id"];

            include_once("./ControlAtencionReclamo.php");
            $OBJControlAtencionReclamo = new ControlAtencionReclamo;
            
            $receiptData = $OBJControlAtencionReclamo -> getReceiptDetails($id);

            $jsonString = json_encode($receiptData);
        
            print_r($jsonString);
        }
    }

    function verifyComplaintData() {
        $response = "";

        if(isset($_POST["details"]) && isset($_POST["complaintType"])) {
            $details = trim($_POST["details"]);
            $complaintType = $_POST["complaintType"];

            if($complaintType == "") {
                $response = "No se seleccionó el tipo de reclamo";

                sendResponse($response);
            } else if(strlen($details) == 0) {
                $response = "No se ingresaron los detalles del reclamo";

                sendResponse($response);
            } else if(preg_match(INVALID_CHARS, $details) || preg_match(KEYWORDS, $details)) {
                $response = "Se detectaron caracteres no válidos en el campo de detalles";

                sendResponse($response);
            } else if(strlen($details) > 500) {
                $response = "Los detalles del reclamo no deben exceder los 500 caracteres";

                sendResponse($response);
            } else {
                if(!isset($_POST["selectedProducts"])) {
                    $response = "Debe seleccionar al menos un producto";

                    sendResponse($response);
                }

                $selectedProducts = $_POST["selectedProducts"];
                
                $validationProducts = verifyProductsQuantities($selectedProducts,$complaintType); 

                if(!$validationProducts[0]) {
                    $response = $validationProducts[1];

                    sendResponse($response);
                } else {
                    $idReceipt = $_POST["idReceipt"];

                    include_once("./ControlAtencionReclamo.php");
                    $OBJControlAtencionReclamo = new ControlAtencionReclamo;

                    $OBJControlAtencionReclamo -> insertComplaint($details, $complaintType, $selectedProducts, $idReceipt);
                }
            }
        }
    }

    function verifyProductsQuantities($products, $type) {
        $response = "";
        $validation = true;

        foreach($products as $product) {
            if ($product["quantity"] == "") {
                $validation = false;
                $response = "Uno o más campos de cantidad se encuentran vacíos";
                break;
            } else if(!preg_match(VALID_NUMBERS, $product["quantity"])) {
                $validation = false;
                $response = "Se detectaron caracteres no válidos en uno o más campos de cantidad";
                break;
            } else if($product["quantity"] < 1) {
                $validation = false;
                $response = "Las cantidades ingresadas deben ser mayores a 0";
                break;
            } else if($product["quantity"] > $product["purchasedQuantity"]) {
                $validation = false;
                $response = "La cantidad ingresada no debe ser mayor a la de la compra realizada";
                break;
            } else if($product["quantity"] > $product["stock"] && $type == "change") {
                $validation = false;
                $response = "La cantidad ingresada no debe exceder al stock";
                break;
            }
        }

        return array($validation, $response);
    }

?>