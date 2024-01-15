<?php
    require_once("../include/config.php");

    if(isset($_POST["action"])) {
        verifyUser();
    }

    function sendResponse($res) {
        $json = array($res);
        $jsonString = json_encode($json);
    
        echo $jsonString;

        return;
    }

    function denyAccess() {
        if(!isset($_POST["btnLogin"])) {
            include_once("../include/systemMessage.php");
            $OBJSystemMessage = new SystemMessage;
            $OBJSystemMessage -> showSystemMessage();
        }
    }

    function verifyUser() {
        $response = "";

        if(isset($_POST["user"]) && isset($_POST["pass"])) {
            $user = trim($_POST["user"]);
            $pass = trim($_POST["pass"]);

            if(preg_match(INVALID_CHARS, $user) || preg_match(KEYWORDS, $user) || preg_match(INVALID_CHARS, $pass) || preg_match(KEYWORDS, $pass)) {
                $response = "Se detectaron caracteres no válidos";
    
                sendResponse($response);
            } else if(strlen($user) == 0 || strlen($pass) == 0) {
                $response = "Uno o ambos campos están vacíos";
    
                sendResponse($response);
            } else {
                include_once("./ControlLogin.php");

                $OBJControlLogin = new ControlLogin;
                $response = $OBJControlLogin -> validateUser($user, $pass);

                if ($response) {
                    $response = "";
                    echo $response;
                } else {
                    $response = "Credenciales incorrectas o usuario inhabilitado";
    
                    sendResponse($response);
                }
            }
        }
    }

    if(isset($_POST["btnLogin"])) {
        include_once("./ControlLogin.php");

        $user = trim($_POST["user"]);

        $OBJControlLogin = new ControlLogin;
        $OBJControlLogin -> renderViewMainPanel($user);
    } else if(!isset($_POST["action"])){
        denyAccess();
    }

?>