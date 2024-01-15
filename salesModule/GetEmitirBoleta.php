<?php
    require_once("../include/config.php");
    @session_start();

    if(isset($_POST["action"])) {
        verifyListProducts();
    }

    function sendResponse($res) {
        $json = array($res);
        $jsonString = json_encode($json);
    
        echo $jsonString;

        exit();
    }

    function denyAccess() {
        if(!isset($_POST["btnConfirmSale"])) {
            include_once("../include/systemMessage.php");
            $OBJSystemMessage = new SystemMessage;
            $OBJSystemMessage -> showSystemMessage();
        }
    }

    function verifyListProducts() {
        $response = "";

        if(isset($_POST["paymentMethod"])) {
            $paymentMethod = $_POST["paymentMethod"];

            if($paymentMethod == "empty") {
                $response = "No se seleccionó el método de pago";

                sendResponse($response);
            } else {
                if(isset($_POST["quantities"])) {
                    $quantities = $_POST["quantities"];
                    $totalAmount = $_POST["totalAmount"];
                    $products = $_POST["products"];
                    $aux = 0;
        
                    foreach($quantities as $quantity) {
                        $productStock = $products[$aux]["stock"];

                        if(strlen($quantity) == 0) {
                            $response = "Complete todos los campos de cantidad";
                
                            sendResponse($response);
                        } else if(!preg_match(VALID_NUMBERS, $quantity)) {
                            $response = "Se detectaron caracteres no válidos";
                
                            sendResponse($response);
                        } else if($quantity < 1) {
                            $response = "Las cantidades ingresadas deben ser mayores a cero";
                
                            sendResponse($response);
                        } else if($productStock < $quantity) {
                            $response = "Las cantidades ingresadas no deben exceder al stock";

                            sendResponse($response);
                        }
                           
                        $products[$aux]["quantity"] = $quantity;
                        $products[$aux]["subtotal"] = floatval($products[$aux]["quantity"]) * floatval($products[$aux]["price"]);

                        $aux++;
                    }

                    include_once("./ControlEmitirBoleta.php");
                    $OBJControlBoleta = new ControlEmitirBoleta;
                    $response = $OBJControlBoleta -> insertSaleData($products, $paymentMethod, $totalAmount);

                    if($response) {
                        $response = "successful";
                    } else {
                        $response = "Ocurrió un error al registrar los datos";
                    }

                    sendResponse($response);
                }
            }
        }
    }
?>