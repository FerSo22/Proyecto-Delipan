<?php

    class UserEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerUser($newUserData) {
            $conn = $this -> connect();

            $user = $newUserData["login"];
            $name = $newUserData["name"];
            $lastName = $newUserData["lastName"];
            $dni = $newUserData["dni"];
            $password = md5($newUserData["pass"]);

            $inserted = false;

            $query = "INSERT INTO usuario (login, nombre, apellidos, dni, contraseña, estado)"
                     ."VALUES (?, ?, ?, ?, ?, 1);";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("sssss", $user, $name, $lastName, $dni, $password);
                $stmt -> execute();

                $inserted = true;

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection(); 

            return $inserted;
        }

        public function verifyUser($login, $password) {
            $conn = $this -> connect();

            $password = md5($password);
            $userFound = false;

            $query = "SELECT * FROM usuario WHERE " 
                     ."login = ? AND "
                     ."contraseña = ? AND "
                     ."estado = 1;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("ss", $login, $password);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $userFound = true;
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $userFound;
        }

        public function verifyDNI($dni) {
            $conn = $this -> connect();

            $dniFound = false;

            $query = "SELECT dni FROM usuario WHERE " 
                     ."dni = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $dni);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $dniFound = true;
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $dniFound;
        }

        public function verifyNewPass($newPass, $dni, $conn) {
            $samePass = false;
            
            $query = "SELECT contraseña FROM usuario WHERE " 
                     ."dni = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $dni);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();
                    $oldPass = $row["contraseña"];

                    if($oldPass == $newPass) {
                        $samePass = true;
                    }
                }

                $stmt -> close();
            }

            return $samePass;
        }

        public function changePassWithLogin($newPass, $login) {
            $conn = $this -> connect();

            $newPass = md5($newPass);
            $changed = false;

            $query = "UPDATE usuario SET " 
                     ."contraseña = ? WHERE "
                     ."login = ?;";
            
            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("ss", $newPass, $login);
                $stmt -> execute();

                $changed = true;

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $changed;
        }

        public function changePassWithDNI($newPass, $dni) {
            $conn = $this -> connect();

            $newPass = md5($newPass);
            $changed = false;
            
            if($this -> verifyNewPass($newPass, $dni, $conn)) {
                $this -> OBJConnection -> closeConnection(); 

                return $changed;
            }

            $query = "UPDATE usuario SET " 
                     ."contraseña = ? WHERE "
                     ."dni = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("ss", $newPass, $dni);
                $stmt -> execute();

                $changed = true;

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $changed;
        }

        public function getUserFullName($login) {
            $conn = $this -> connect();

            $fullName = "";
            $name = "";
            $lastName = "";

            $query = "SELECT nombre, apellidos FROM usuario WHERE " 
                     ."login = ? ;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $login);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $name = $row["nombre"];
                    $lastName = $row["apellidos"];
                }

                $stmt -> close();
            }

            $fullName = $name . " " . $lastName;

            $this -> OBJConnection -> closeConnection(); 

            return $fullName;
        }

        public function switchUserState($state, $login) {
            $conn = $this -> connect();

            $query = "UPDATE usuario SET "
                     ."estado = ? WHERE "
                     ."login = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("is", $state, $login);
                $stmt -> execute();

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 
        }

        public function getAllUsersReferentialData() {
            $conn = $this -> connect();

            $arrayUsers = array();

            $query = "SELECT nombre, login, dni, estado FROM usuario;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> execute();

                $result = $stmt -> get_result();

                
                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "name" => $row["nombre"],
                            "userName" => $row["login"],
                            "dni" => $row["dni"],
                            "state" => $row["estado"]
                        );
                    }

                    $arrayUsers = $rows;
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $arrayUsers;
        }

        public function getUserData($login) {
            $conn = $this -> connect();

            $userData = array();

            $query = "SELECT nombre, apellidos, dni FROM usuario WHERE "
                     ."login = ?";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $login);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $userData = array(
                        "name" => $row["nombre"],
                        "lastName" => $row["apellidos"],
                        "dni" => $row["dni"]
                    );
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $userData;
        }
    }

?>