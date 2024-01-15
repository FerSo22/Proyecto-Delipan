<?php

    class SecurityQuestionEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function getUserSecurityQuestions($dni) {
            $conn = $this -> connect();
            
            $arrayUserQuestions = array();

            $query = "SELECT upr.id_pregunta, ps.pregunta FROM usuario AS u " 
                     ."JOIN usuario_pregunta_respuesta AS upr ON u.dni = upr.dni "
                     ."JOIN pregunta_seguridad AS ps ON upr.id_pregunta = ps.id WHERE "
                     ."u.dni = ? "
                     ."ORDER BY upr.id_pregunta;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $dni);
                $stmt -> execute();

                $result = $stmt -> get_result();

                while($row = $result -> fetch_assoc()) {
                    $arrayUserQuestions[] = array(
                        "id" => $row["id_pregunta"],
                        "question" => $row["pregunta"]
                    );
                }
                
                $stmt -> close();
            }

            return $arrayUserQuestions;
        }

        public function getSecurityQuestions() {
            $conn = $this -> connect();

            $arrayQuestions = array();

            $query = "SELECT id, pregunta FROM pregunta_seguridad;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "id" => $row["id"],
                            "question" => $row["pregunta"]
                        );
                    }
                    
                    $arrayQuestions = $rows;
                }

                $stmt -> close();
            }

            return $arrayQuestions;
        }
    }

?>