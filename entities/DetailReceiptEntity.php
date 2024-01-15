<?php

    class DetailReceiptEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerDetailReceipt($products, $id) {
            $conn = $this -> connect();

            $inserted = false;

            $query = "INSERT INTO detalle_boleta (id_boleta, codigo_producto, cantidad, monto_parcial)"
                     ."VALUES (?, ?, ?, ?);";

            foreach($products as $product) {
                $inserted = false;

                if($stmt = $conn -> prepare($query)) {
                    $stmt -> bind_param("isid", $id, $product["code"], $product["quantity"], $product["subtotal"]);

                    $stmt -> execute();

                    $inserted = true;
                } 
            }

            $stmt -> close();

            $this -> OBJConnection -> closeConnection();    
            
            return $inserted;
        }

        public function getDetailReceipt($id) {
            $conn = $this -> connect();

            $arrayDetails = array();

            $query = "SELECT p.codigo, p.nombre, p.precio, db.cantidad, db.monto_parcial " 
                     ."FROM detalle_boleta as db "
                     ."JOIN producto AS p ON p.codigo = db.codigo_producto WHERE "
                     ."db.id_boleta = ?";

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
                            "price" => $row["precio"],
                            "quantity" => $row["cantidad"],
                            "subtotal" => $row["monto_parcial"]
                        ); 
                    }

                    $arrayDetails = $rows;
                }

                $stmt -> close();

            }

            $this -> OBJConnection -> closeConnection();

            return $arrayDetails;
        }

        public function getPurchasedProducts($id) {
            $conn = $this -> connect();

            $arrayProducts = array();

            $query = "SELECT codigo_producto, cantidad FROM detalle_boleta WHERE "
                     ."id_boleta = ?";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "code" => $row["codigo_producto"],
                            "quantity" => $row["cantidad"]
                        ); 
                    }

                    $arrayProducts = $rows;
                }

                $stmt -> close();

            }

            $this -> OBJConnection -> closeConnection();

            return $arrayProducts;
        }
    }

?>