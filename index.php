<?php
	@session_start();
	if(session_status() == PHP_SESSION_NONE || empty($_SESSION)) {
		setcookie('PHPSESSID', '', time() - 3600, '/');
		session_destroy();

		include_once("./securityModule/FormLogin.php");
		$OBJLogin = new FormLogin;
		$OBJLogin -> showFormLogin();
	} else if(isset($_SESSION["user"])) {
		$url = "./salesModule/GetNavAction.php?idPrivilege=" . $_SESSION["firstPrivilege"];
		header("Location: " . $url);
	}
?>