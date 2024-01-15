<?php

    require_once("../include/config.php");
    
    if(isset($_POST["dni"])) {
        $dni = $_POST["dni"];
    } else if(isset($_POST["hiddenDNI"])) {
        $dni = $_POST["hiddenDNI"];
    }

    if(isset($_POST["action"])) {
        $action = $_POST["action"];

        switch($action) {
            case "verifyDNI":
                verifyDNI();
                break;
            case "verifySecurityQuestion":
                verifySecurityQuestion();
                break;
            case "verifyPasswordChange":
                verifyPasswordChange();
                break;
        }
    }

    function sendResponse($res) {
        $json = array($res);
        $jsonString = json_encode($json);
    
        echo $jsonString;

        return;
    }

    function denyAccess() {
        if(!isset($_POST["btnAccept"]) || !isset($_POST["btnContinue"]) || !isset($_POST["btnConfirm"])) {
            include_once("../include/systemMessage.php");
            $OBJSystemMessage = new SystemMessage;
            $OBJSystemMessage -> showSystemMessage();
        }
    }

    function verifyDNI() {
        $response = "";

        if(isset($_POST["dni"])) {
            $dni = trim($_POST["dni"]);
    
            if(preg_match(INVALID_CHARS, $dni) || preg_match(KEYWORDS, $dni)) {
                $response = "Se detectaron caracteres no válidos";
    
                sendResponse($response);
            } else if(strlen($dni) != 8) {
                $response = "N° de DNI no válido";
    
                sendResponse($response);
            } else {
                include_once("./ControlPassRecovery.php");
                $OBJControlPassRecovery = new ControlPassRecovery;
                $response = $OBJControlPassRecovery -> validateDNI($dni);
    
                if ($response) {
                    $response = "";
                    echo $response;
                } else {
                    $response = "Usuario no encontrado o inhabilitado";
    
                    sendResponse($response);
                }
            }
        } 
    }
    
    function verifySecurityQuestion() {
        $response = "";

        if(isset($_POST["value"]) && isset($_POST["hiddenDNI"]) && isset($_POST["answer"])) {
            $value = trim($_POST["value"]);
            $dni = trim($_POST["hiddenDNI"]);
            $answer = trim($_POST["answer"]);
    
            if($value == "") {
                $response = "No se seleccionó una pregunta de seguridad";
    
                sendResponse($response);
            } else if(preg_match(INVALID_CHARS, $answer) || preg_match(KEYWORDS, $answer)) {
                $response = "Se detectaron caracteres no válidos";
    
                sendResponse($response);
            } else if(strlen($answer) == 0) {
                $response = "El campo de respuesta está vacío";
    
                sendResponse($response);
            } else {
                include_once("./ControlPassRecovery.php");

                $OBJControlPassRecovery = new ControlPassRecovery;
                $response = $OBJControlPassRecovery -> validateSecurityAnswer($value, $dni, $answer);
    
                if ($response) {
                    $response = "";
                    echo $response;
                } else {
                    $response = "Respuesta incorrecta";
    
                    sendResponse($response);
                }
            }
        }
    }

    function verifyPasswordChange() {
        $response = "";

        if(isset($_POST["newPass"]) && isset($_POST["reNewPass"]) && isset($_POST["hiddenDNI"])) {
            $newPass = trim($_POST["newPass"]);
            $reNewPass = trim($_POST["reNewPass"]);
            $dni = trim($_POST["hiddenDNI"]);
            
            if(preg_match(INVALID_CHARS, $newPass) || preg_match(KEYWORDS, $newPass) || preg_match(INVALID_CHARS, $reNewPass) || preg_match(KEYWORDS, $reNewPass)) {
                $response = "Se detectaron caracteres no válidos";
    
                sendResponse($response);
            } else if(strlen($newPass) == 0 || strlen($reNewPass) == 0) {
                $response = "Uno o ambos campos están vacíos";
    
                sendResponse($response);
            } else if(strlen($newPass) < 6) {
                $response = "La contraseña es muy corta";
    
                sendResponse($response);
            } else if($newPass != $reNewPass) {
                $response = "Las contraseñas no coinciden";
    
                sendResponse($response);
            } else {
                include_once("./ControlPassRecovery.php");
                $OBJControlPassRecovery = new ControlPassRecovery;
                $response = $OBJControlPassRecovery -> validatePasswordChange($newPass, $dni);
    
                if ($response) {
                    $response = "";
                    echo $response;
                } else {
                    $response = "La nueva contraseña no puede ser la misma que la antigua";
    
                    sendResponse($response);
                }
            }
        }
    }

    if(isset($_POST["btnAccept"])) {
        include_once("./ControlPassRecovery.php");

        $OBJControlPassRecovery = new ControlPassRecovery;
        $OBJControlPassRecovery -> renderFormSecurityQuestion($dni);
    } else if(isset($_POST["btnContinue"])) {
        include_once("./ControlPassRecovery.php");

        $OBJControlPassRecovery = new ControlPassRecovery;
        $OBJControlPassRecovery -> renderFormChangePass($dni);
    } else if(isset($_POST["btnConfirm"])) {
        header("Location: ../index.php");
        
        exit;
    } else if(!isset($_POST["action"])){
        denyAccess();
    }
?>