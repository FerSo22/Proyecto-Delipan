<?php
    class ViewMainPanel {
        public function showMainPanel($navPrivileges, $path, $ajaxFile, $cssFile) {
            require_once("../include/config.php");
?>

            <!DOCTYPE html>
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <title>Delipan | Panel de Administrador</title>
                <link rel="stylesheet" href="<?php echo CSS_PATH."styles_mainPanelNav.css"?>">
                <link rel="stylesheet" href="<?php echo CSS_PATH."styles_salesModule.css"?>">
                <link rel="stylesheet" href="<?php echo CSS_PATH."styles_modal.css"?>">
                <link rel="stylesheet" href="<?php echo CSS_PATH.$cssFile?>">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
                <script src="<?php echo JQUERY_FILE ?>"></script>
            </head>

            <body>
<?php
                include_once("../include/MessageModal.php");
                $OBJModal = new MessageModal;
                $OBJModal -> messageModal();
                $OBJModal -> confirmationModal();

                include_once("../include/MainPanelNav.php");
                $OBJMainPanelNav = new MainPanelNav;
                $OBJMainPanelNav -> showMainPanelNav($navPrivileges);
?>
                <div class="container-panel">
                    <div class="empty"></div>
                    <main class="main">
                        <div class="container-main" id="mainContainer">                      
<?php
                include_once($path);
?>
                        </div>
                    </main>
                </div>
                <script src="<?php echo JS_PATH."dropDownAnimation.js"?>"></script>
                <script src="<?php echo AJAX_PATH.$ajaxFile?>"></script>
            </body>

<?php
        }
    }
?>