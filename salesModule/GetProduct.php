<?php 

    require_once("../include/config.php");

    if(isset($_POST["action"])) {
        verifyProduct();
    }

    function sendResponse($res) {
        $json = array($res);
        $jsonString = json_encode($json);
    
        echo $jsonString;

        return;
    }

    function denyAccess() {
        if(!isset($_POST["btnSearchProduct"])) {
            include_once("../include/systemMessage.php");
            $OBJSystemMessage = new SystemMessage;
            $OBJSystemMessage -> showSystemMessage();
        }
    }

    function verifyProduct() {
        $response = "";

        if(isset($_POST["product"])) {
            $product = trim($_POST["product"]);

            if(preg_match(INVALID_CHARS, $product) || preg_match(KEYWORDS, $product)) {
                $response = "Se detectaron caracteres no válidos";
    
                sendResponse($response);
            } else if(strlen($product) < 3) {
                $response = "Ingrese un nombre o código de producto válido";
    
                sendResponse($response);
            } else {
                include_once("./ControlProduct.php");

                $OBJControlProduct = new ControlProduct;
                $response = $OBJControlProduct -> searchProduct($product);
                
                if ($response[0]) {
                    sendResponse($response);
                } else {
                    $response = "Producto no encontrado o se encuentra inhabilitado";
    
                    sendResponse($response);
                }
            }
        }
    }

?>