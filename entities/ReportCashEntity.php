<?php
    date_default_timezone_set('America/Lima');

    class ReportCashEntity {
        private $OBJConnection;

        private function connect() {
            include_once("Connection.php");
            $this -> OBJConnection = new Connection;

            return $this -> OBJConnection -> getConnection();
        }

        public function registerReport($totalAmount, $employee) {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");
            $currenTime = date("H:i:s");

            $inserted = false;

            $query = "INSERT INTO reporte_caja (fecha_registro, hora_registro, empleado, monto_total) "
                     ."VALUES (?, ?, ?, ?);";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("sssd", $currentDate, $currenTime, $employee, $totalAmount);
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

            $query = "SELECT id FROM reporte_caja WHERE "
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

            $query = "SELECT id, hora_registro, empleado, monto_total FROM reporte_caja WHERE "
                     ."fecha_registro = ?;";

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
                        "totalAmount" => $row["monto_total"]
                    );
                }

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $reportData;
        }

        public function getCashAmount() {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");

            $totalAmount = 0;

            $query = "SELECT monto_total FROM reporte_caja WHERE "
                     ."fecha_registro = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $currentDate);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $totalAmount = $row["monto_total"];
                }

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $totalAmount;
        }

        public function getReportAmount() {
            $conn = $this -> connect();

            $currentDate = date("Y-m-d");

            $reportData = array();

            $query = "SELECT id, monto_total FROM reporte_caja WHERE "
                     ."fecha_registro = ?;";

            if($stmt = $conn -> prepare($query)) {
                $stmt -> bind_param("s", $currentDate);
                $stmt -> execute();

                $result = $stmt -> get_result();

                if($result -> num_rows > 0) {
                    $row = $result -> fetch_assoc();

                    $reportData = array(
                        "id" => $row["id"],
                        "totalAmount" => $row["monto_total"]
                    );
                }

                $stmt -> close();
            } 

            $this -> OBJConnection -> closeConnection();

            return $reportData;
        }
    }


?>