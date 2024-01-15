<?php
    class DetailReportReceiptsEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerDetailReport($idReport, $receipts) {
            $conn = $this -> connect();

            $inserted = false;

            $query = "INSERT INTO detalle_reporte_boletas (id_reporte, id_boleta, monto_parcial) "
                     ."VALUES (?, ?, ?);";

            foreach($receipts as $receipt) {
                $inserted = false;

                if($stmt = $conn -> prepare($query)) {
                    $stmt -> bind_param("iid", $idReport, $receipt["code"], $receipt["subtotal"]);

                    $stmt -> execute();

                    $inserted = true;
                } 
            }

            $stmt -> close();

            $this -> OBJConnection -> closeConnection();    

            return $inserted;
        }

        public function getReportDetails($idReport) {
            $conn = $this -> connect();

            $reportDetails = array();

            $query = "SELECT id_boleta, monto_parcial FROM detalle_reporte_boletas WHERE "
                     ."id_reporte = ? "
                     ."ORDER BY id_boleta;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $idReport);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "idReceipt" => $row["id_boleta"],
                            "subtotal" => $row["monto_parcial"]
                        );
                    }

                    $reportDetails = $rows;
                }

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $reportDetails;
        }
    }

?>