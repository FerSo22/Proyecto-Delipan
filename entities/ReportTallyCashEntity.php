<?php
    date_default_timezone_set('America/Lima');

    class ReportTallyCashEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerReport($employee, $reportsID, $discrepancy, $reason) {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");
            $currenTime = date("H:i:s");

            $inserted = false;

            $query = "INSERT INTO reporte_cierre_caja (fecha_registro, hora_registro, empleado, "   
                     ."reporte_boletas, reporte_caja, descuadre, razon) "
                     ."VALUES (?, ?, ?, ?, ?, ?, ?);";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("sssiids", $currentDate, 
                                               $currenTime, 
                                               $employee, 
                                               $reportsID["receipts"],
                                               $reportsID["cash"],
                                               $discrepancy,
                                               $reason);
                $stmt -> execute();

                $inserted = true;

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $inserted;
        }

        public function getCurrentDayReport() {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");

            $existingReport = false;

            $query = "SELECT id FROM reporte_cierre_caja WHERE "
                     ."fecha_registro = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $currentDate);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $existingReport = $row["id"];
                }

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $existingReport;
        }

        public function getReportData($date) {
            $conn = $this -> connect();

            $reportData = array();

            $query = "SELECT rcc.id, rcc.hora_registro, rcc.empleado, rcc.reporte_boletas, "
                     ."rcc.reporte_caja, rcc.descuadre, rcc.razon, "
                     ."rb.monto_total AS monto_total_boletas, rc.monto_total AS monto_total_caja " 
                     ."FROM reporte_cierre_caja AS rcc "
                     ."JOIN reporte_boletas AS rb ON rb.id = rcc.reporte_boletas "
                     ."JOIN reporte_caja AS rc ON rc.id = rcc.reporte_caja WHERE "
                     ."rcc.fecha_registro = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $date);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $reportData = array(
                        "code" => $row["id"],
                        "time" => $row["hora_registro"],
                        "employee" => $row["empleado"],
                        "codeReceiptsReport" => $row["reporte_boletas"],
                        "totalReceipts" => $row["monto_total_boletas"],
                        "codeCashReport" => $row["reporte_caja"],
                        "totalCash" => $row["monto_total_caja"],
                        "discrepancy" => $row["descuadre"],
                        "reason" => $row["razon"]
                    );
                }

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $reportData;
        }
    }
?>