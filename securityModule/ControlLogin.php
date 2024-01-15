<?php

    class ControlLogin {
        public function validateUser($login, $password) {
            include_once("../entities/UserEntity.php");

            $OBJUser = new UserEntity;
            $validation = $OBJUser -> verifyUser($login, $password);

            return $validation;
        }

        public function renderViewMainPanel($login) {
            $band = false;
            $firstPrivilege = "";

            include_once("../entities/GroupPrivilegeEntity.php");
            $OBJGroupPrivilege = new GroupPrivilegeEntity;
            $groups = $OBJGroupPrivilege -> getGroupPrivilege($login);

            include_once("../entities/UserPrivilegeEntity.php");
            $OBJUserPrivilege = new UserPrivilegeEntity;
            $privileges = $OBJUserPrivilege -> getUserPrivileges($login);

            $navPrivileges = "";
            $arrayPrivileges = array();

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
                        $arrayPrivileges[] += $privilege["id"];
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
                    if(!$band) {
                        $firstPrivilege = $privilege["id"];
                        $band = true;
                    }
                }
                $navPrivileges .= '</ul>
                                </li>';
            }

            //$firstPrivilegePath = $OBJUserPrivilege -> getFirstPrivilegePath($firstPrivilege);

            session_start();
            $_SESSION["user"] = $login;
            $_SESSION["firstPrivilege"] = $firstPrivilege;
            $_SESSION["actualPrivilege"] = $_SESSION["firstPrivilege"];
            $_SESSION["privileges"] = $arrayPrivileges;
            $_SESSION["navPrivileges"] = $navPrivileges;

            include_once("../entities/UserEntity.php");
            $OBJUser = new UserEntity;
            $_SESSION["fullName"] = $OBJUser -> getUserFullName($_SESSION["user"]);
            /*
            include_once("../userModule/ViewMainPanel.php");
            $OBJMainPanel = new ViewMainPanel;
            $OBJMainPanel -> showMainPanel($_SESSION["navPrivileges"], $firstPrivilegePath);
            */
            $url = "../salesModule/GetNavAction.php?idPrivilege=" . $_SESSION["firstPrivilege"];

            header("Location: " . $url);
            exit();
        }
    }

?>