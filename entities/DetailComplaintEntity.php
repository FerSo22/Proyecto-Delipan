<?php
    class DetailComplaintEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerDetailComplaint($products, $id) {
            $conn = $this -> connect();

            $query = "INSERT INTO detalle_reclamo (id_reclamo, codigo_producto, cantidad)"
                     ."VALUES (?, ?, ?);";

            foreach($products as $product) {
                if($stmt = $conn -> prepare($query)) {
                    $stmt -> bind_param("isi", $id, $product["code"], $product["quantity"]);

                    $stmt -> execute();
                } 
            }

            $stmt -> close();

            $this -> OBJConnection -> closeConnection();
        }

        public function getDetailComplaint($id) {
            $conn = $this -> connect();

            $arrayDetails = array();

            $query = "SELECT p.codigo, p.nombre, dr.cantidad FROM detalle_reclamo as dr "
                     ."JOIN producto AS p ON p.codigo = dr.codigo_producto WHERE "
                     ."dr.id_reclamo = ?";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "code" => $row["codigo"],
                            "name" => $row["nombre"],
                            "quantity" => $row["cantidad"]
                        ); 
                    }

                    $arrayDetails = $rows;
                }

                $stmt -> close();

            }

            $this -> OBJConnection -> closeConnection();

            return $arrayDetails;
        }
    }

?>