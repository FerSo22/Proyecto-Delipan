<?php

    class SystemMessage {
        public function showSystemMessage() {
            require_once("config.php");
?>

            <!DOCTYPE html>
            <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport"
                        content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <title>Delipan | Acceso denegado</title>
                    <link rel="stylesheet" href="<?php echo CSS_PATH."styles_systemMessage.css"?>">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
                </head>

                <body>
                    <div class="container-main">
                        <header class="header-main">    
                            <div class="container-header__img">
                                <img src="<?php echo IMG_PATH."logo-login.png"?>">
                            </div>
                            <div class="container-header__title">
                                <h1>ACCESO DENEGADO</h1>
                            </div>
                        </header>
                        <main class="main">
                            <div class="container">
                                <div class="system-message">
                                    <div class="container-img">
                                        <img src="<?php echo ICON_PATH."warning-icon.png"?>">
                                    </div>
                                    <p>SE HA DETECTADO UN INTENTO DE VULNERACIÓN AL SISTEMA</p>
                                </div>
                                <div class="container-link">
                                    <a href="<?php echo ROOT_PATH."index.php"?>" class="link-index">Volver al inicio</a>
                                </div>
                            </div>
                        </main>
                    </div>
                </body>

            </html>

<?php
        }
    }
?>