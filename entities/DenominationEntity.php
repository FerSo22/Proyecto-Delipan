<?php
    class DenominationEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function getDenominationID($denomination) {
            $conn = $this -> connect();

            $idDenomination = "";

            $query = "SELECT id FROM denominacion WHERE "
                     ."denominacion = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("d", $denomination);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $idDenomination = $row["id"];
                }

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $idDenomination;
        }
    }
 
?>