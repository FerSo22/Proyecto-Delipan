<?php

    class PrivilegeEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function getPrivileges() {
            $conn = $this -> connect();

            $arrayPrivileges = array();

            $query = "SELECT id, nombre FROM privilegio;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "id" => $row["id"],
                            "name" => $row["nombre"]
                        );
                    }
                    
                    $arrayPrivileges = $rows;
                }

                $stmt -> close();
            }

            return $arrayPrivileges;
        }

        public function getPrivilegePath($id) {
            $conn = $this -> connect();

            $path = "";

            $query = "SELECT ruta FROM privilegio WHERE "
                     ."id = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $path = $row["ruta"];
                }

                $stmt -> close();
            }

            return $path;
        }

        public function getFiles($id) {
            $conn = $this -> connect();

            $files = array();

            $query = "SELECT archivo_ajax, archivo_css FROM privilegio WHERE "
                     ."id = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $files = array(
                        "ajaxFile" => $row["archivo_ajax"],
                        "cssFile" => $row["archivo_css"]
                    );
                }

                $stmt -> close();
            }

            return $files;
        }

        public function getCountPrivileges() {
            $conn = $this -> connect();

            $count = 0;

            $query = "SELECT COUNT(*) as rows_count FROM privilegio";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> execute();

                $stmt->bind_result($count);
                $stmt->fetch();

                $stmt -> close();
            }

            return $count;
        }
    }

?>