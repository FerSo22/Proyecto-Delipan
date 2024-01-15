<?php
    class DetailReportCashEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerDetailReport($idReport, $amountsDenominations) {
            $conn = $this -> connect();

            $inserted = false;

            $query = "INSERT INTO detalle_reporte_caja (id_reporte, id_denominacion, cantidad, monto_parcial) "
                     ."VALUES (?, ?, ?, ?);";

            foreach($amountsDenominations as $amount) {
                $inserted = false;

                if($stmt = $conn -> prepare($query)) {
                    $stmt -> bind_param("iiid", $idReport, $amount["idDenomination"], $amount["quantity"], $amount["subtotal"]);

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

            $query = "SELECT d.denominacion, drc.cantidad, drc.monto_parcial FROM "         
                     ."detalle_reporte_caja AS drc "
                     ."JOIN denominacion AS d ON d.id = drc.id_denominacion WHERE "
                     ."id_reporte = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $idReport);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $rows = array();

                    while($row = $result -> fetch_assoc()) {
                        $rows[] = array(
                            "denomination" => $row["denominacion"],
                            "quantity" => $row["cantidad"],
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