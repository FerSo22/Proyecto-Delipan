<?php
	class FormSecurityQuestion {
		public function showFormSecurityQuestion($dni, $questions) {
			require_once("../include/config.php");
?>

			<!DOCTYPE html>
			<html lang="en">

				<head>
					<meta charset="UTF-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport"
						content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
					<title>Delipan | Preguntas de Seguridad</title>
					<link rel="stylesheet" href="<?php echo CSS_PATH."styles_securityModule.css"?>">
					<link rel="stylesheet" href="<?php echo CSS_PATH."styles_securityQuestion.css"?>">
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
					<div class="container-overlay">
						<div class="container-main" id="formSecurityQuestion">
							<div class="container-logo">
								<a href="<?php echo ROOT_PATH."index.php"?>">
									<img src="<?php echo IMG_PATH."logo-login.png"?>">
								</a>
							</div>
							<div class="container-title">
								<h2>Preguntas de Seguridad</h2>
							</div>
							<div class="container-form">
								<form name="form-question_answer" id="form-question_answer" method="POST" action="<?php echo SECURITY_MODULE_PATH."GetPassRecoveryData.php"?>" class="form-question_answer security-module__form">
									<div class="container-data">
										<select id="securityQuestion" class="select-form">
											<option value="" class="option-question empty-option" selected></option>
<?php
											echo $questions;
?>
										</select>
										<label for="securityQuestion" id="lblSecurityQuestion" class="label-form">Pregunta de Seguridad</label>
									</div>
									<div class="container-data">
										<input type="text" name="securityAnswer" id="securityAnswer" placeholder=" " class="input-form"/>
										<label for="securityAnswer" class="label-form">Respuesta</label>
									</div>
									<input type="hidden" name="hiddenDNI" id="hiddenDNI" value="<?php echo $dni ?>"/>
									<button name="btnContinue" id="btnContinue" type="submit" class="btn-accept">Continuar</button>
								</form>
							</div>
						</div>
					</div>

					<script src="<?php echo JS_PATH."selectFormEffect.js"?>"></script>
					<script src="<?php echo AJAX_PATH."GetPassRecoveryData.js"?>"></script>
				</body>
				
			</html>

<?php
		}
	}
?>