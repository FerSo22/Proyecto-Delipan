<?php 

    class UserPrivilegeEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerUserPrivilege($login, $arrayUserPrivileges) {
            $conn = $this -> connect();

            $inserted = false;

            $query = "INSERT INTO usuario_privilegio (login, id_privilegio)"
                     ."VALUES (?, ?);";

            foreach($arrayUserPrivileges as $userPrivilege) {
                $inserted = false;

                if($stmt = $conn -> prepare($query)) {
                    $stmt -> bind_param("si", $login, $userPrivilege);

                    $stmt -> execute();

                    $inserted = true;

                    $stmt -> close();
                } 
            }

            $this -> OBJConnection -> closeConnection();   
            
            return $inserted;
        }

        public function deleteUserPrivilege($login, $arrayUserPrivileges) {
            $conn = $this -> connect();

            $query = "DELETE FROM usuario_privilegio WHERE "
                     ."login = ? AND "
                     ."id_privilegio = ?;";

            foreach($arrayUserPrivileges as $userPrivilege) {
                if($stmt = $conn -> prepare($query)) {
                    $stmt -> bind_param("si", $login, $userPrivilege);

                    $stmt -> execute();

                    $stmt -> close();
                } 
            }

            $this -> OBJConnection -> closeConnection();   
        }

        public function getUserPrivileges($login) {
            $conn = $this -> connect();

            $arrayPrivileges = array();

            $query = "SELECT p.id, p.id_grupo, p.nombre FROM usuario_privilegio AS up "
                     ."JOIN privilegio AS p ON p.id = up.id_privilegio WHERE "
                     ."up.login = ? "
                     ."ORDER BY p.id;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $login);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    while($row = $result -> fetch_assoc()) {
                        $arrayPrivileges[] = array(
                            "id" => $row["id"],
                            "id_grupo" => $row["id_grupo"],
                            "privilege" => $row["nombre"]
                        );
                    }
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $arrayPrivileges;
        }

        public function getUserIdPrivileges($login) {
            $conn = $this -> connect();

            $privileges = array();

            $query = "SELECT p.id FROM usuario_privilegio AS up "
                     ."JOIN privilegio AS p ON p.id = up.id_privilegio WHERE "
                     ."up.login = ? "
                     ."ORDER BY p.id;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $login);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    while($row = $result -> fetch_assoc()) {
                        $privileges[] += $row["id"];
                    }
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $privileges;
        }

        public function getFirstPrivilegePath($firstPrivilegeID) {
            $conn = $this -> connect();

            $path = "";

            $query = "SELECT ruta FROM privilegio WHERE "
                     ."id = ? ";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $firstPrivilegeID);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                while($row = $result -> fetch_assoc()) {
                    $path = $row["ruta"];
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $path;
        }
    }

?>