<?php

    class UserQuestionAnswerEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }
        
        public function registerUserQuestionAnswer($dni, $arrayQuestionsAnswers) {
            $conn = $this -> connect();

            $inserted = false;

            $query = "INSERT INTO usuario_pregunta_respuesta (dni, id_pregunta, respuesta)"
                     ."VALUES (?, ?, ?);";

            foreach($arrayQuestionsAnswers as $questionAnswer) {
                $inserted = false;

                if($stmt = $conn -> prepare($query)) {
                    $stmt -> bind_param("sis", $dni, $questionAnswer["question"], $questionAnswer["answer"]);

                    $stmt -> execute();

                    $inserted = true;
                } 
            }

            $stmt -> close();

            $this -> OBJConnection -> closeConnection();   
            
            return $inserted;
        }

        public function getUserQuestionsAnswers($dni) {
            $conn = $this -> connect();

            $userQuestionsAnswers = array();

            $query = "SELECT ps.pregunta, upr.respuesta FROM usuario_pregunta_respuesta AS upr "
                     ."JOIN pregunta_seguridad AS ps ON ps.id = upr.id_pregunta WHERE " 
                     ."upr.dni = ?";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $dni);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "question" => $row["pregunta"],
                            "answer" => $row["respuesta"]
                        );
                    }

                    $userQuestionsAnswers = $rows;
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $userQuestionsAnswers;
        }

        public function verifySecurityAnswer($id_pregunta, $dni, $answer) {
            $conn = $this -> connect();
            $correctAnswer = false;

            $query = "SELECT respuesta FROM usuario_pregunta_respuesta WHERE " 
                     ."id_pregunta = ? AND "
                     ."dni = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("is", $id_pregunta, $dni);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $answer = strtoupper($answer);

                    $row = $result -> fetch_assoc();
                    $BD_answer = strtoupper($row["respuesta"]);

                    if($BD_answer == $answer) {
                        $correctAnswer = true;
                    }
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $correctAnswer;
        }
    }

?>