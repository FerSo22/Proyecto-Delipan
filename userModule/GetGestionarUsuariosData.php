<?php
    require_once("../include/config.php");

    if(isset($_POST["action"])) {
        $action = $_POST["action"];

        switch($action) {
            case "getAllUsers":
                getAllUsers();
                break;
            case "switchUserState":
                switchUserState();
                break;
            case "loadFormRegisterUser":
                loadFormRegisterUser();
                break;
            case "loadFormEditUser":
                loadFormEditUser();
                break;
            case "getSecurityQuestions":
                getSecurityQuestions();
                break;
            case "verifyNewUserData":
                verifyNewUserData();
                break;
            case "verifyModifiedUserData":
                verifyModifiedUserData();
                break;
        }
    }

    function sendResponse($res) {
        $json = array($res);
        $jsonString = json_encode($json);
    
        echo $jsonString;

        exit();
    }

    function getAllUsers() {
        include_once("./ControlGestionarUsuarios.php");
        $OBJControlGestionarUsuarios = new ControlGestionarUsuarios;

        $response = $OBJControlGestionarUsuarios -> getAllUsersReference();

        sendResponse($response);
    }

    function switchUserState() {
        @session_start();
        
        $state = $_POST["value"];
        $user = $_POST["user"];
        $response = "";

        if($user != $_SESSION["user"]) {
            include_once("./ControlGestionarUsuarios.php");
            $OBJControlGestionarUsuarios = new ControlGestionarUsuarios;

            $OBJControlGestionarUsuarios -> switchUserState($state, $user);

            if($state) {
                $response = "Usuario " . $user . " habilitado con éxito";
            } else {
                $response = "Usuario " . $user . " deshabilitado";
            }
        } 

        sendResponse($response);
    }

    function loadFormRegisterUser() {
        include_once("./ControlGestionarUsuarios.php");
        $OBJControlGestionarUsuarios = new ControlGestionarUsuarios;
        $OBJControlGestionarUsuarios -> renderFormRegisterUser();
    }

    function loadFormEditUser() {
        $login = $_POST["login"];

        include_once("./ControlGestionarUsuarios.php");
        $OBJControlGestionarUsuarios = new ControlGestionarUsuarios;
        $OBJControlGestionarUsuarios -> renderFormEditUser($login);
    }

    function getSecurityQuestions() {
        include_once("./ControlGestionarUsuarios.php");
        $OBJControlGestionarUsuarios = new ControlGestionarUsuarios;
        $response = $OBJControlGestionarUsuarios -> getSecurityQuestions();

        sendResponse($response);
    }

    function verifyNewUserData() {
        include_once("./ControlGestionarUsuarios.php");
        $OBJControlGestionarUsuarios = new ControlGestionarUsuarios;

        $response = "";

        if(isset($_POST["personalData"]) && isset($_POST["userData"])) {
            $personalData = $_POST["personalData"];
            $userData = $_POST["userData"];

            $name =  $personalData["name"];
            $lastName = $personalData["lastName"];
            $dni = $personalData["dni"];
            $pass = $userData["pass"];
            $rePass = $userData["rePass"];
            $arrayQuestionsAnswers = array();

            if(empty($userData["privileges"])) {
                $response = "Debe seleccionar al menos un privilegio";

                sendResponse($response);
            } else if(empty($userData["questionsAnswers"])) {
                $response = "Seleccione la cantidad de preguntas de seguridad";

                sendResponse($response);
            } else {
                $arrayQuestionsAnswers = $userData["questionsAnswers"];

                $arrayQuestions = array_column($arrayQuestionsAnswers, "question");

                if(count($arrayQuestions) != count(array_unique($arrayQuestions)) || verifySelectionQuestions($arrayQuestions)) {
                    $response = "No se seleccionó una pregunta de seguridad o alguna selección se repite";
                    
                    sendResponse($response);
                }
            }

            if($name == "" || $lastName == "" || $dni == "" || $pass == "" || $rePass == "" || validateAnswers(array_column($arrayQuestionsAnswers, "answer"))) {
                $response = "Uno o más campos de texto se encuentran vacíos";

                sendResponse($response);
            } else if(validateCharacters($name) || validateCharacters($lastName) || validateCharacters($dni) || validateCharacters($pass) || validateCharacters($rePass) || validateAnswersCharacters(array_column($arrayQuestionsAnswers, "answer"))) {
                $response = "Se detectaron caracteres no válidos en uno o más campos";

                sendResponse($response);
            } else if(strlen($dni) != 8) {
                $response = "Número de DNI no válido";

                sendResponse($response);
            } 
            
            if($OBJControlGestionarUsuarios -> verifyDNI($dni)) {
                $response = "El DNI ya se encuentra registrado";

                sendResponse($response);
            } else if(strlen($pass) < 6) {
                $response = "La contraseña es muy corta (mínimo 6 caracteres)";

                sendResponse($response);
            } else if($pass != $rePass) {
                $response = "Las contraseñas ingresadas no coinciden";

                sendResponse($response);
            } else {
                $OBJControlGestionarUsuarios -> registerNewUser($personalData, $userData);

                sendResponse("");
            }
        }
    }

    function verifyModifiedUserData() {
        $response = "";

        if(isset($_POST["newData"]) && isset($_POST["user"])) {
            $newData = $_POST["newData"];
            $user = $_POST["user"];

            $arrayPrivileges = array();
            $newPass = $newData["newPass"];
            $reNewPass = $newData["reNewPass"];

            $changePass = true;

            if(empty($newData["privileges"])) {
                $response = "Debe seleccionar al menos un privilegio";

                sendResponse($response);
            } else {
                $arrayPrivileges = $newData["privileges"];
            }

            if((strlen($newPass) < 6 && strlen($newPass) > 0) || (strlen($reNewPass) < 6 && strlen($reNewPass) > 0)) {
                $response = "La nueva contraseña es muy corta";

                sendResponse($response);
            } else if (validateCharacters($newPass) || validateCharacters($reNewPass)) {
                $response = "Se detectaron caracteres no válidos en la contraseña";

                sendResponse($response);
            } else if($newPass != $reNewPass){
                $response = "Las contraseñas no coinciden";

                sendResponse($response);
            } else {
                $changePass = false;
            }

            include_once("./ControlGestionarUsuarios.php");
            $OBJControlGestionarUsuarios = new ControlGestionarUsuarios;
            $OBJControlGestionarUsuarios -> updateUserPrivileges($user, $arrayPrivileges);

            if($changePass) {
                $OBJControlGestionarUsuarios -> updateUserPass($user, $newPass);
            }

            sendResponse($response);
        }
    }

    function verifySelectionQuestions($array) {
        foreach($array as $a) {
            if($a == "") {
                return true;
            }
        }

        return false;
    }

    function validateCharacters($string) {
        return preg_match(INVALID_CHARS, $string) || preg_match(KEYWORDS, $string);
    }

    function validateAnswers($array) {
        foreach($array as $a) {
            if($a == "") {
                return true;
            }
        }

        return false;
    }

    function validateAnswersCharacters($array) {
        foreach($array as $a) {
            if(preg_match(INVALID_CHARS, $a) || preg_match(KEYWORDS, $a)) {
                return true;
            }
        }

        return false;
    }

?>