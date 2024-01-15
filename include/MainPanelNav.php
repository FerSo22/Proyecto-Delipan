<?php

    class MainPanelNav {
        public function showMainPanelNav($navPrivileges) {
            require_once("../include/config.php");
?>

                <div class="container-nav"> 
                    <div class="container-nav__header">
                        <img src="<?php echo IMG_PATH."logo-login.png"?>">
                    </div>
                    <nav class="nav-main">
                        <div class="container-nav__title">
                            <p>MENU DEL SISTEMA</p>
                        </div>
                        <div class="container-nav__list">
                            <ul class="list-nav">   
                                <?php echo $navPrivileges; ?>
                            </ul>
                        </div>
                    </nav>
                    <div class="container-profile">
                        <form action="<?php echo SALES_MODULE_PATH."GetNavAction.php"?>" method="POST">
                            <button type="submit" name="user-profile" id="user-profile">
                                <i class="fa-solid fa-circle-user"></i>
                                <p><?php echo $_SESSION["user"] ?></p>
                            </button>
                        </form>
                    </div>
                </div>

<?php
        }
    }

?>