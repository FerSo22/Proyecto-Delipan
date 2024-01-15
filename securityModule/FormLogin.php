<?php
    class FormLogin {
        public function showFormLogin() {
            require_once("./include/config.php");
?>

            <!DOCTYPE html>
            <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <title>Delipan</title>
                    <link rel="stylesheet" href="<?php echo CSS_PATH."styles_securityModule.css" ?>">
                    <link rel="stylesheet" href="<?php echo CSS_PATH."styles_index.css" ?>">
                    <link rel="stylesheet" href="<?php echo CSS_PATH."styles_modal.css"?>">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
                    <script src="<?php echo JQUERY_FILE ?>"></script>
                </head>

                <body>
<?php
                    include_once("./include/MessageModal.php");
                    $OBJModal = new MessageModal;
                    $OBJModal -> messageModal();
?>
                    <div class="container-overlay">
                        <div class="container-main">
                            <div class="container-logo">
                                <a href="">
                                    <img src="<?php echo IMG_PATH."logo-login.png"?>">
                                </a>
                            </div>
                            <div class="container-title">
                                <h2>Iniciar Sesión</h2>
                            </div>
                            <div class="container-form">
                                <form class="form-login security-module__form" id="form-login" name="form-login" method="POST" action="<?php echo SECURITY_MODULE_PATH."GetLogin.php" ?>">
                                    <div class="container-data user">
                                        <input type="text" name="user" id="user" placeholder=" " class="input-form"/>	
                                        <label for="user" class="label-form">Usuario</label>
                                    </div>
                                    <div class="container-data pass">
                                        <input type="password" name="pass" id="pass" placeholder=" " class="input-form">
                                        <label for="pass" class="label-form">Contraseña</label>
                                    </div>						
                                    <button type="submit" name="btnLogin" id="btnLogin" class="btn-login">Ingresar</button>
                                </form>
                            </div>
                            <div class="container-link">
                                <a href="<?php echo SECURITY_MODULE_PATH."FormPassRecovery.php"?>">¿Olvidaste tu contraseña?</a>
                            </div>
                        </div>
                    </div>

                    <script src="<?php echo AJAX_PATH."GetLoginData.js" ?>"></script>
                </body>

            </html>

<?php
        }
    }
?>