<?php

    class ControlGestionarUsuarios {
        public function registerNewUser($personalData, $userData) {
            $userName = substr($personalData["name"], 0, 1) . explode(" ", $personalData["lastName"])[0] . substr($personalData["dni"], 0, 2) . substr($personalData["dni"], 6, 2);
            $userName = strtolower($userName);

            // REGISTRO DE DATOS EN LA TABLA USUARIO
            include_once("../entities/UserEntity.php");
            $OBJUser = new UserEntity;
            
            $newUserData = array(
                "login" => $userName,
                "name" => $personalData["name"],
                "lastName" => $personalData["lastName"],
                "dni" => $personalData["dni"],
                "pass" => $userData["pass"]
            );

            $OBJUser -> registerUser($newUserData);

            // REGISTRO DE DATOS EN LA TABLA USUARIO_PREGUNTA_RESPUESTA 
            include_once("../entities/UserQuestionAnswerEntity.php");
            $OBJUserQuestionAnswer = new UserQuestionAnswerEntity;

            $userQuestionsAnswers = $userData["questionsAnswers"];

            $OBJUserQuestionAnswer -> registerUserQuestionAnswer($personalData["dni"], $userQuestionsAnswers);

            // REGISTRO DE DATOS EN LA TABLA USUARIO_PRIVILEGIO
            include_once("../entities/UserPrivilegeEntity.php");
            $OBJUserPrivilege = new UserPrivilegeEntity;

            $userPrivileges = $userData["privileges"];

            $OBJUserPrivilege -> registerUserPrivilege($userName, $userPrivileges);
        }

        public function updateUserPass($login, $newPass) {
            include_once("../entities/UserEntity.php");
            $OBJUser = new UserEntity;

            $OBJUser -> changePassWithLogin($newPass, $login);
        }

        public function updateUserPrivileges($login, $newPrivileges) {
            include_once("../entities/UserPrivilegeEntity.php");
            $OBJUserPrivilege = new UserPrivilegeEntity;

            $actualPrivileges = $OBJUserPrivilege -> getUserIdPrivileges($login);

            $privilegesToDelete = array_diff($actualPrivileges, $newPrivileges);
            $privilegesToInsert = array_diff($newPrivileges, $actualPrivileges);

            $OBJUserPrivilege -> deleteUserPrivilege($login, $privilegesToDelete);
            $OBJUserPrivilege -> registerUserPrivilege($login, $privilegesToInsert);
        }

        public function getAllUsersReference() {
            include_once("../entities/UserEntity.php");
            $OBJUser = new UserEntity;
            $users = $OBJUser -> getAllUsersReferentialData();
            
            $html = "";

            foreach($users as $user) {
                $checked = "";

                if($user["state"]) {
                    $checked = "checked";
                }

                $html .= "<tr>"
                            ."<td>" . $user["name"] . "</td>"
                            ."<td>" . $user["userName"] . "</td>"
                            ."<td>" . $user["dni"] . "</td>"
                            ."<td>"
                                ."<input type='hidden' value='" . $user["userName"] . "'>"
                                ."<button class='btn-modifiy'>"
                                    ."<i class='fa-solid fa-pen-to-square'></i>"
                                ."</button>"
                                ."<div class='container-switch'>"
                                    ."<div class='switch-update'>"
                                        ."<input type='checkbox' name='switchState' class='switch-state'" . $checked . ">"
                                        ."<label class='switch-state__label'>"
                                            ."<span class='onoffswitch-inner'></span>"
                                            ."<span class='onoffswitch-switch'></span>"
                                        ."</label>"
                                    ."</div>"
                                ."</div>"
                            ."</td>"
                         ."</tr>";
            }

            return $html;
        }

        public function switchUserState($state, $login) {
            include_once("../entities/UserEntity.php");
            $OBJUser = new UserEntity;

            if($state) {
                $state = 1;
            } else {
                $state = 0;
            }
            
            $OBJUser -> switchUserState($state, $login);
        }

        public function getSecurityQuestions() {
            include_once("../entities/SecurityQuestionEntity.php");
            $OBJSecurityQuestion = new SecurityQuestionEntity;
            $arrayQuestions = $OBJSecurityQuestion -> getSecurityQuestions();

            return $arrayQuestions;
        }

        public function verifyDNI($dni) {
            include_once("../entities/UserEntity.php");
            $OBJUser = new UserEntity;
            
            return $OBJUser -> verifyDNI($dni);
        }

        // INVOCAR FORMULARIOS
        public function renderFormRegisterUser() {
            include_once("../entities/PrivilegeEntity.php");
            $OBJPrivilege = new PrivilegeEntity;
            $arrayPrivileges = $OBJPrivilege -> getPrivileges();

            $html = "";

            foreach($arrayPrivileges as $privilege) {
                $html .= "<tr>"
                            ."<td>"
                                ."<label for='privilege_" . $privilege["id"] . "' class='label-privilege'>"
                                    ."<input type='checkbox' name='privilege_" . $privilege["id"] . "'"
                                    ."id='privilege_" . $privilege["id"] . "' value=" . $privilege["id"]
                                    ." class='cb-privilege'>"
                                ."</label>"
                            ."</td>"
                            ."<td>"
                                .$privilege["name"]
                            ."</td>"
                         ."</tr>";
            }

            include_once("./FormRegisterUser.php");
            $OBJFormRegisterUser = new FormRegisterUser;
            $OBJFormRegisterUser -> showFormRegisterUser($html);
        }

        public function renderFormEditUser($login) {
            include_once("../entities/UserEntity.php");
            $OBJUser = new UserEntity;

            $userData = $OBJUser -> getUserData($login);

            include_once("../entities/UserQuestionAnswerEntity.php");
            $OBJUserQuestionAnswer = new UserQuestionAnswerEntity;

            $userQuestionsAnswers = $OBJUserQuestionAnswer -> getUserQuestionsAnswers($userData["dni"]);

            include_once("../entities/UserPrivilegeEntity.php");
            $OBJUserPrivilege = new UserPrivilegeEntity;

            $userPrivileges = $OBJUserPrivilege -> getUserIdPrivileges($login);

            include_once("../entities/PrivilegeEntity.php");
            $OBJPrivilege = new PrivilegeEntity;
            
            $arrayPrivileges = $OBJPrivilege -> getPrivileges();

            $fieldsQuestionAnswer = "";
            $tablePrivileges = "";

            $aux = 1;

            foreach($userQuestionsAnswers as $questionAnswer) {
                $fieldsQuestionAnswer .= "<div class='container-data'>"
                                            ."<label>Pregunta " . $aux . "</label>"
                                            ."<input type='text' value='" . $questionAnswer["question"] ."' class='input-form no-edit' readonly/>"
                                         ."</div>"
                                         ."<div class='container-data'>"
                                            ."<label>Respuesta " . $aux . "</label>"
                                            ."<input type='text' value='" . $questionAnswer["answer"] ."' class='input-form no-edit' readonly/>"
                                         ."</div>";
                
                $aux++;
            }

            foreach($arrayPrivileges as $privilege) {
                $checked = "";

                if(in_array($privilege["id"], $userPrivileges)) {
                    $checked = "checked";
                }

                $tablePrivileges .= "<tr>"
                                        ."<td>"
                                            ."<label for='privilege_" . $privilege["id"] . "' class='label-privilege'>"
                                                ."<input type='checkbox' name='privilege_" . $privilege["id"] . "'"
                                                ."id='privilege_" . $privilege["id"] . "' value=" . $privilege["id"]
                                                ." class='cb-privilege'" . $checked . ">"
                                            ."</label>"
                                        ."</td>"
                                        ."<td>"
                                            .$privilege["name"]
                                        ."</td>"
                                    ."</tr>";
            }

            include_once("./FormEditUser.php");
            $OBJFormEditUser = new FormEditUser;
            $OBJFormEditUser -> showFormEditUser($login, $userData, $fieldsQuestionAnswer, $tablePrivileges);
        }
    }

?>