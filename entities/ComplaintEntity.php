<?php
    date_default_timezone_set('America/Lima');

    class ComplaintEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerComplaint($complaintData, $complaintType) {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");
            $currenTime = date("H:i:s");

            $query = "";

            if($complaintType == "change") {
                $complaintType = 1;
            } else if($complaintType == "refund") {
                $complaintType = 2;
            }

            $query = "INSERT INTO reclamo (fecha_registro, hora_registro, detalles, id_boleta, empleado, reembolso, tipo_reclamo) "
            ."VALUES (?, ?, ?, ?, ?, ?, ?)";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("sssisdi", $currentDate, $currenTime, $complaintData["details"], $complaintData["idReceipt"], $complaintData["employee"], $complaintData["refund"], $complaintType);
                
                $stmt -> execute();

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();
        }

        public function getComplaintInfo($idReceipt) {
            $conn = $this -> connect();

            $complaintInfo = array();

            $query = "SELECT r.id, r.fecha_registro, r.hora_registro, r.detalles, r.empleado, r.reembolso, tr.tipo FROM reclamo AS r "
                     ."JOIN tipo_reclamo AS tr ON tr.id = r.tipo_reclamo WHERE "
                     ."r.id_boleta = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("i", $idReceipt);
                $stmt -> execute();

                $result = $stmt -> get_result();
                
                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $complaintInfo = array(
                        "id" => $row["id"],
                        "date" => $row["fecha_registro"],
                        "time" => $row["hora_registro"],
                        "details" => $row["detalles"],
                        "employee" => $row["empleado"],
                        "refund" => $row["reembolso"],
                        "solution" => $row["tipo"]
                    ); 
                }

                $stmt -> close();
            }

            return $complaintInfo;
        }

        public function getComplaintNumber() {
            $conn = $this -> connect();

            $num_rows = 0;

            $query = "SELECT COUNT(*) as rows_count FROM reclamo";
            
            if($stmt = $conn -> prepare($query)) {
                $stmt -> execute();

                $stmt->bind_result($num_rows);
                $stmt->fetch();

                $stmt -> close();
            }

            return $num_rows;
        }
    }
?>