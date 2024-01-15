<?php

    class ControlNavAction {
        public function setPanelContent($idPrivilege) {
            include_once("../entities/PrivilegeEntity.php");
            $OBJPrivilegeEntity = new PrivilegeEntity;

            if($idPrivilege > 0 && $idPrivilege < $OBJPrivilegeEntity -> getCountPrivileges() + 1) {
                @session_start();

                include_once("../entities/UserPrivilegeEntity.php");
                $OBJUserPrivilegeEntity = new UserPrivilegeEntity;

                $_SESSION["privileges"] = $OBJUserPrivilegeEntity -> getUserIdPrivileges($_SESSION["user"]);

                if(in_array($idPrivilege, $_SESSION["privileges"])) {
                    $path = $OBJPrivilegeEntity -> getPrivilegePath($idPrivilege);
                    $arrayFiles = $OBJPrivilegeEntity -> getFiles($idPrivilege);
                    $this -> layoutNav();

                    include_once("../userModule/ViewMainPanel.php");
                    $OBJMainPanel = new ViewMainPanel;
                    $OBJMainPanel -> showMainPanel($_SESSION["navPrivileges"], $path, $arrayFiles["ajaxFile"], $arrayFiles["cssFile"]);
                } else {
                    $this -> denyAccess();
                }
            } else {
                $this -> denyAccess();
            }
            
        }

        private function layoutNav() {
            include_once("../entities/GroupPrivilegeEntity.php");
            $OBJGroupPrivilege = new GroupPrivilegeEntity;
            $groups = $OBJGroupPrivilege -> getGroupPrivilege($_SESSION["user"]);


            include_once("../entities/UserPrivilegeEntity.php");
            $OBJUserPrivilege = new UserPrivilegeEntity;
            $privileges = $OBJUserPrivilege -> getUserPrivileges($_SESSION["user"]);

            $navPrivileges = "";

            foreach($groups as $group) {
                $navPrivileges .= '<li class="list-nav__item">
                                        <div class="link-list__main dropdown">'
                                            . $group["icon"] .
                                            '<p>' . $group["id"] . ". " . $group["group"] . '</p>' .
                                            '<i class="fa-solid fa-chevron-right arrow"></i>
                                        </div>
                                        
                                            <ul class="list__show">';
                foreach($privileges as $privilege) {
                    if($privilege["id_grupo"] == $group["id"]) {
                        $navPrivileges .= '<li class="list__inside">
                                                <form method="GET" action="../salesModule/GetNavAction.php">
                                                    <input type="hidden" value=' . $privilege["id"] . ' name="idPrivilege">
                                                    <button type="submit" class="button-list__inside" id="btn-privilege_'
                                                    . $privilege["id"] . '">'
                                                        . $privilege["privilege"] .
                                                    '</button>
                                                </form>
                                            </li>';
                    }
                }
                $navPrivileges .= '</ul>
                                </li>';
            }

            $_SESSION["navPrivileges"] = $navPrivileges;
        }

        private function denyAccess() {
            include_once("../include/systemMessage.php");
            $OBJSystemMessage = new SystemMessage;
            $OBJSystemMessage -> showSystemMessage();

            $this -> destroySession();
        }
    
        private function destroySession() {
            $_SESSION = array();
            setcookie('PHPSESSID', '', time() - 3600, '/');

            if(isset($_SESSION)) {
                session_destroy();
            }

            if(isset($_COOKIE["idReceipt"])) {
                setcookie("idReceipt", "", time() - (30 * 30), "/");
            }
        }
    }

?>