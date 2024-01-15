<?php

    class ControlPassRecovery {
        public function validateDNI($dni) {
            include_once("../entities/UserEntity.php");

            $OBJUser = new UserEntity;
            $validation = $OBJUser -> verifyDNI($dni);

            return $validation;
        }

        public function validatePasswordChange($newPass, $dni) {
            include_once("../entities/UserEntity.php");

            $OBJUser = new UserEntity;
            $validation = $OBJUser -> changePassWithDNI($newPass, $dni);

            return $validation;
        }

        public function validateSecurityAnswer($value, $dni, $answer) {
            include_once("../entities/UserQuestionAnswerEntity.php");

            $OBJUserQuestionAnswer = new UserQuestionAnswerEntity;
            $validation = $OBJUserQuestionAnswer -> verifySecurityAnswer($value, $dni, $answer);

            return $validation;
        }

        // Invocar los formularios 
        public function renderFormSecurityQuestion($dni) {
            include_once("../entities/SecurityQuestionEntity.php");

            $OBJSecurityQuestion = new SecurityQuestionEntity;
            $arrayQuestions = $OBJSecurityQuestion -> getUserSecurityQuestions($dni);
            $stringQuestions = '';
            
            foreach ($arrayQuestions as $question) {
                $stringQuestions .= '<option value="' . $question["id"] . '" class="option-question">' . $question["question"] . '</option>';
            }

            include_once("./FormSecurityQuestion.php");

            $OBJSecurityQuestion = new FormSecurityQuestion;
            $OBJSecurityQuestion -> showFormSecurityQuestion($dni, $stringQuestions);

            echo "<script> history.replaceState(null, null, 'redirecciona.php'); </script>";
        }

        public function renderFormChangePass($dni) {
            include_once("./FormChangePass.php");
            
            $OBJChangePass = new FormChangePass;
            $OBJChangePass -> showFormChangePass($dni);

            echo "<script> history.replaceState(null, null, 'redirecciona.php'); </script>";
        }
    }

?>