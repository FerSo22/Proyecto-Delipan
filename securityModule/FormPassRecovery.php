<?php
	require_once("../include/config.php");
?>
<!DOCTYPE html>
<html lang="en">

    <head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"
			content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>Delipan | Contraseña olvidada</title>
		<link rel="stylesheet" href="<?php echo CSS_PATH."styles_securityModule.css"?>">
		<link rel="stylesheet" href="<?php echo CSS_PATH."styles_passRecovery.css"?>">
		<link rel="stylesheet" href="<?php echo CSS_PATH."styles_modal.css"?>">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	</head>

    <body>
<?php
		include_once("../include/MessageModal.php");
		$OBJModal = new MessageModal;
		$OBJModal -> messageModal();
?>
        <div class="container-overlay" id="formPassRecovery">
			<div class="container-main" >
                <span class="form-header">
                    <a href="<?php echo ROOT_PATH."index.php"?>">
                        <i class="fa-solid fa-arrow-left return-icon"></i>
                    </a>
                    <div class="container-logo">
                        <a href="<?php echo ROOT_PATH."index.php"?>">
                            <img src="<?php echo IMG_PATH."logo-login.png"?>">
                        </a>
                    </div>
                </span>
				<div class="container-title">
					<h2>Restablecer Contraseña</h2>
				</div>
				<div class="container-form">
					<form name="form-dni" id="form-dni" method="POST" action="<?php echo SECURITY_MODULE_PATH."GetPassRecoveryData.php"?>" class="form-dni security-module__form">
						<div class="container-data">
							<input type="text" name="dni" id="dni" placeholder=" " class="input-form"/>
							<label for="dni" class="label-form">N° de DNI</label>
						</div>
						<button name="btnAccept" id="btnAccept" type="submit" class="btn-accept">Aceptar</button>
					</form>
				</div>
			</div>
		</div>

		<script src="<?php echo AJAX_PATH."GetPassRecoveryData.js"?>"></script>
    </body>
	
</html>