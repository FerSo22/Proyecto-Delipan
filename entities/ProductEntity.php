<?php

    class ProductEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function verifyProduct($product) {
            $conn = $this -> connect();

            $results = array(
                            false,
                            array());

            if($this -> searchProductCode($product, $conn)[0]) {
                $results = $this -> searchProductCode($product, $conn);

                $this -> OBJConnection -> closeConnection(); 
                return $results;
            }

            if($this -> searchProductName($product, $conn)[0]) {
                $results = $this -> searchProductName($product, $conn);

                $this -> OBJConnection -> closeConnection(); 
                return $results;
            }

            $this -> OBJConnection -> closeConnection(); 

            return $results;
        }

        public function searchProductCode($code, $conn) {
            $results = array(
                false,
                array());

            $code = strtoupper($code);

            $query = "SELECT codigo, nombre, stock, precio, id_categoria FROM producto WHERE "
                     ."codigo = ? AND "
                     ."estado = 1;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $code);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $results[0] = true;
                    $rows = array();

                    $row = $result -> fetch_assoc();
                    $rows[] = array(
                        "code" => $row["codigo"],
                        "name" => $row["nombre"],
                        "stock" => $row["stock"],
                        "price" => $row["precio"],
                        "id_category" => $row["id_categoria"]
                    ); 

                    $results[1] = $rows;
                }

                $stmt -> close();
            }

            return $results;
        }

        public function searchProductName($name, $conn) {
            $results = array(
                        false,
                        array());

            $name = "%" . $name . "%";

            $query = "SELECT codigo, nombre, stock, precio, id_categoria FROM producto WHERE "
                     ."nombre LIKE ? AND "
                     ."estado = 1 "
                     ."ORDER BY codigo;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $name);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $results[0] = true;
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "code" => $row["codigo"],
                            "name" => $row["nombre"],
                            "stock" => $row["stock"],
                            "price" => $row["precio"],
                            "id_category" => $row["id_categoria"]
                        ); 
                    }

                    $results[1] = $rows;
                }

                $stmt -> close();
            }

            return $results;
        }

        public function getListProducts($products) {
            $conn = $this -> connect();

            $arrayProducts = array();

            $query = "SELECT p.nombre, p.stock, cp.categoria "
                     ."FROM producto AS p "
                     ."JOIN categoria_producto AS cp ON cp.id = p.id_categoria WHERE "
                     ."p.codigo = ?";

            foreach($products as $product) {
                if($stmt = $conn -> prepare($query)) {
                    $stmt -> bind_param("s", $product["code"]);
                    $stmt -> execute();
    
                    $result = $stmt -> get_result();
                    
                    if($result -> num_rows > 0) {
                        $row = $result -> fetch_assoc();
    
                        $arrayProducts[] = array(
                            "code" => $product["code"],
                            "name" => $row["nombre"],
                            "stock" => $row["stock"],
                            "category" => $row["categoria"],
                            "quantity" => $product["quantity"]
                        );
                    }
    
                    $stmt -> close();
                }
            }
            
            $this -> OBJConnection -> closeConnection(); 

            return $arrayProducts;
        }

        public function getStockProduct($id) {
            $conn = $this -> connect();

            $stock = 0;

            $query = "SELECT stock FROM producto WHERE "
                     ."codigo = ?";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $stock = $row["stock"];
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $stock;
        }

        public function getPriceProduct($id) {
            $conn = $this -> connect();

            $price = 0;

            $query = "SELECT precio FROM producto WHERE "
                     ."codigo = ?";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $price = $row["precio"];
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $price;
        }

        public function updateStockProduct($id, $newStock) {
            $conn = $this -> connect();

            $query = "UPDATE producto SET " 
                     ."stock = ? WHERE "
                     ."codigo = ?";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("is", $newStock, $id);
                $stmt -> execute();

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 
        }
    }

?>