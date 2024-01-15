<?php
    class FormChangePass {
        public function showFormChangePass($dni) {
            require_once("../include/config.php");
?>

            <!DOCTYPE html>
            <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport"
                        content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <title>Delipan | Cambiar Contraseña</title>
                    <link rel="stylesheet" href="<?php echo CSS_PATH."styles_securityModule.css" ?>">
                    <link rel="stylesheet" href="<?php echo CSS_PATH."styles_changePass.css" ?>">
                    <link rel="stylesheet" href="<?php echo CSS_PATH."styles_modal.css"?>">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
                    <script src="<?php echo JQUERY_FILE ?>"></script>
                </head>

                <body>
<?php
                    include_once("../include/MessageModal.php");
                    $OBJModal = new MessageModal;
                    $OBJModal -> messageModal();
?>
                    <div class="container-overlay">
                        <div class="container-main">
                            <div class="container-logo">
                                <a href="<?php echo ROOT_PATH."index.php"?>">
                                    <img src="<?php echo IMG_PATH."logo-login.png"?>">
                                </a>
                            </div>
                            <div class="container-title">
                                <h2>Cambiar Contraseña</h2>
                            </div>
                            <div class="container-form">
                                <form name="form-change_pass" id="form-change_pass" method="POST" action="<?php echo SECURITY_MODULE_PATH."GetPassRecoveryData.php"?>" class="form-change_pass security-module__form">
                                    <div class="container-data user">
                                        <input type="password" name="newPass" id="newPass" placeholder=" " class="input-form"/>	
                                        <label for="newPass" class="label-form">Nueva contraseña</label>
                                    </div>
                                    <div class="container-data pass">
                                        <input type="password" name="reNewPass" id="reNewPass" placeholder=" " class="input-form">
                                        <label for="reNewPass" class="label-form">Confirmar nueva contraseña</label>
                                    </div>
                                    <input type="hidden" name="hiddenDNI" id="hiddenDNI" value="<?php echo $dni ?>"/>						
                                    <button type="submit" name="btnConfirm" id="btnConfirm" class="btn-accept">Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script src="<?php echo AJAX_PATH."GetPassRecoveryData.js"?>"></script>
                </body>

            </html>

<?php
        }
    }
?>