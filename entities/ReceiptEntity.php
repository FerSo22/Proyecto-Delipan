<?php
    date_default_timezone_set('America/Lima');

    class ReceiptEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerReceipt($totalAmount, $employee, $paymentMethod) {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");
            $currenTime = date("H:i:s");

            $inserted = false;

            $query = "INSERT INTO boleta (fecha_emision, hora_emision, metodo_pago, monto_total, "
                     ."empleado, estado) "
                     ."VALUES (?, ?, ?, ?, ?, 0);";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("sssds", $currentDate, $currenTime, $paymentMethod, $totalAmount, $employee);
                $stmt -> execute();

                $inserted = true;

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection(); 

            return $inserted;
        }

        public function getReceiptInfo($id) {
            $conn = $this -> connect();

            $receiptInfo = array();

            $query = "SELECT fecha_emision, hora_emision, metodo_pago, monto_total, empleado " 
                     ."FROM boleta WHERE "
                     ."id = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $receiptInfo[] = array(
                        "date" => $row["fecha_emision"],
                        "time" => $row["hora_emision"],
                        "payment_method" => $row["metodo_pago"],
                        "total_amount" => $row["monto_total"],
                        "employee" => $row["empleado"]
                    ); 
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection();

            return $receiptInfo;
        }

        public function getReceiptNumber() {
            $conn = $this -> connect();

            $num_rows = 0;

            $query = "SELECT COUNT(*) as rows_count FROM boleta";
            
            if($stmt = $conn -> prepare($query)) {
                $stmt -> execute();

                $stmt->bind_result($num_rows);
                $stmt->fetch();

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection();

            return $num_rows + 1;
        }

        public function updateStateReceipt($id) {
            $conn = $this -> connect();

            $stateChanged = false;

            $query = "UPDATE boleta SET " 
                     ."estado = 1 WHERE "
                     ."id = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $id);
                $stmt -> execute();

                $stateChanged = true;

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $stateChanged;
        }

        public function getSingleReceipt($id, $currentDate) {
            $conn = $this -> connect();

            $receipt = array();

            $query = "SELECT id, hora_emision, monto_total FROM boleta WHERE "
                     ."id = ? AND "
                     ."fecha_emision = ? AND "
                     ."estado = 0;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("is", $id, $currentDate);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();
                    $receipt[] = array(
                        "code" => $row["id"],
                        "time" => $row["hora_emision"],
                        "totalAmount" => $row["monto_total"]
                    ); 
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $receipt;
        }

        public function simpleSearchReceipt($id) {
            $conn = $this -> connect();

            $receipt = array();

            $query = "SELECT id, fecha_emision, empleado FROM boleta WHERE "
                     ."id = ? AND "
                     ."estado = 1;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $receipt = array(   
                        "code" => $row["id"],
                        "date" => $row["fecha_emision"],
                        "employee" => $row["empleado"]
                    ); 
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $receipt;
        }   
    
        public function getAllReceipts($currentDate) {
            $conn = $this -> connect();

            $arrayReceipts = array();

            $query = "SELECT id, hora_emision, monto_total FROM boleta WHERE "
                     ."fecha_emision = ? AND "
                     ."estado = 0;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $currentDate);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "code" => $row["id"],
                            "time" => $row["hora_emision"],
                            "totalAmount" => $row["monto_total"]
                        ); 
                    }
                    
                    $arrayReceipts = $rows;
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $arrayReceipts;
        }

        public function verifyExistingComplaint($id) {
            $conn = $this -> connect();

            $existing = false;

            $query = "SELECT id_boleta FROM reclamo WHERE "
                     ."id_boleta = ?;";
        
            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $id);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $existing = true;
                }

                $stmt -> close();
            }

            $this -> OBJConnection -> closeConnection(); 

            return $existing;
        }

        public function getAllCurrentDayReceipts() {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");
            $receipts = array();

            $query = "SELECT b.id, b.hora_emision, b.empleado, b.monto_total, r.id_boleta, r.reembolso "
                     ."FROM boleta AS b "
                     ."LEFT JOIN reclamo AS r ON r.id_boleta = b.id WHERE "
                     ."fecha_emision = ? "
                     ."ORDER BY b.id";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $currentDate);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                $rows = array();

                if($result -> num_rows > 0) {
                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "code" => $row["id"],
                            "time" => $row["hora_emision"],
                            "employee" => $row["empleado"],
                            "totalAmount" => $row["monto_total"],
                            "existingComplaint" => $row["id_boleta"],
                            "refund" => $row["reembolso"]
                        ); 
                    }

                    $receipts = $rows;
                }
            }

            $this -> OBJConnection -> closeConnection(); 

            return $receipts;
        }

        public function getReceiptsToReport() {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");

            $receipts = array();

            $query = "SELECT b.id, b.monto_total, r.reembolso FROM boleta AS b "
                     ."LEFT JOIN reclamo AS r ON r.id_boleta = b.id WHERE "
                     ."b.fecha_emision = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $currentDate);
                $stmt -> execute();

                $result = $stmt -> get_result();

                $rows = array();

                if($result -> num_rows > 0) {
                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "code" => $row["id"],
                            "totalAmount" => $row["monto_total"],
                            "refund" => $row["reembolso"]
                        ); 
                    }

                    $receipts = $rows;
                }

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $receipts;
        }
    }

?>