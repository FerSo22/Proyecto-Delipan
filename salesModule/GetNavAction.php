<?php 

    if(isset($_POST["user-profile"])) {
        if(isset($_COOKIE["idReceipt"])) {
            setcookie("idReceipt", "", time() - (30 * 30), "/");
        }

        destroySession(true);       
    }

    if(isset($_GET["idPrivilege"])) {
        @session_start();

        if(session_status() == PHP_SESSION_NONE || empty($_SESSION)) {
            denyAccess();
            destroySession(false);
        } else {
            $idPrivilege = $_GET["idPrivilege"];

            include_once("./ControlNavAction.php");
            $OBJControlNavAciton = new ControlNavAction;
            $OBJControlNavAciton -> setPanelContent($idPrivilege);
        }
        
    }
    
    function denyAccess() {
        include_once("../include/systemMessage.php");
        $OBJSystemMessage = new SystemMessage;
        $OBJSystemMessage -> showSystemMessage();
    }

    function destroySession($redirection) {
        $_SESSION = array();
        setcookie('PHPSESSID', '', time() - 3600, '/');
        session_destroy();

        if($redirection) {
            header("Location: ../index.php");
        }

        exit();
    }
?>