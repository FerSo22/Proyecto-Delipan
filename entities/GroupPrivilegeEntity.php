<?php 

    class GroupPrivilegeEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function getGroupPrivilege($login) {
            $conn = $this -> connect();

            $arrayGroups = array();

            $query = "SELECT DISTINCT gp.id, gp.grupo, gp.icono FROM privilegio AS p "
                     ."JOIN grupo_privilegio AS gp ON p.id_grupo = gp.id "
                     ."JOIN usuario_privilegio AS up ON p.id = up.id_privilegio WHERE "
                     ."up.login = ? "
                     ."ORDER BY gp.id;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $login);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                while($row = $result -> fetch_assoc()) {
                    $arrayGroups[] = array(
                        "id" => $row["id"],
                        "group" => strtoupper($row["grupo"]),
                        "icon" => $row["icono"]
                    );
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $arrayGroups;
        }
    }

?>