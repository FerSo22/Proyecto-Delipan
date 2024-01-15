<?php
    class ControlReporte {
        public function renderReceiptsReport($date) {
            include_once("../entities/ReportReceiptsEntity.php");
            $OBJReportReceipts = new ReportReceiptsEntity;

            $reportReceiptsData = $OBJReportReceipts -> getReportData($date);

            include_once("../entities/DetailReportReceiptsEntity.php");
            $OBJDetailReportReceipts = new DetailReportReceiptsEntity;

            $reportDetails = $OBJDetailReportReceipts -> getReportDetails($reportReceiptsData["code"]);

            include_once("./TemplateReporte.php");
            $OBJReporte = new TemplateReporte;

            $tableHeader = $this -> getTableHeader(1);
            $tableBody = $this -> layoutTableReceiptsReport($reportDetails);
            $tableFooter = $this -> getTableFooter(1, $reportReceiptsData["totalAmount"]);

            $tableContent = array(
                "header" => $tableHeader,
                "body" => $tableBody,
                "footer" => $tableFooter
            );

            $arrayDate = explode("-", $date);

            $formattedDate = array(
                "day" => $arrayDate[2],
                "month" => $arrayDate[1],
                "year" => $arrayDate[0]
            );

            $type = "Boletas";
            $code = $this -> getFormattedCode($reportReceiptsData["code"]);

            $OBJReporte -> showReporte($reportReceiptsData, $type, $tableContent, $formattedDate, $code);
        }

        public function renderCashReport($date) {
            include_once("../entities/ReportCashEntity.php");
            $OBJReportCash = new ReportCashEntity;

            $reportCashData = $OBJReportCash -> getReportData($date);

            include_once("../entities/DetailReportCashEntity.php");
            $OBJDetailReportCash = new DetailReportCashEntity;

            $reportDetails = $OBJDetailReportCash -> getReportDetails($reportCashData["code"]);

            include_once("./TemplateReporte.php");
            $OBJReporte = new TemplateReporte;

            $tableHeader = $this -> getTableHeader(2);
            $tableBody = $this -> layoutTableCashReport($reportDetails);
            $tableFooter = $this -> getTableFooter(2, $reportCashData["totalAmount"]);

            $tableContent = array(
                "header" => $tableHeader,
                "body" => $tableBody,
                "footer" => $tableFooter
            );

            $arrayDate = explode("-", $date);

            $formattedDate = array(
                "day" => $arrayDate[2],
                "month" => $arrayDate[1],
                "year" => $arrayDate[0]
            );

            $type = "Caja";
            $code = $this -> getFormattedCode($reportCashData["code"]);

            $OBJReporte -> showReporte($reportCashData, $type, $tableContent, $formattedDate, $code);
        }


        public function renderTallyCashReport($date) {
            include_once("../entities/ReportTallyCashEntity.php");
            $OBJReportTallyCash = new ReportTallyCashEntity;

            $reportCashTallyData = $OBJReportTallyCash -> getReportData($date);

            $reportCashTallyData["code"] = $this -> getFormattedCode($reportCashTallyData["code"]);
            $reportCashTallyData["codeReceiptsReport"] = $this -> getFormattedCode($reportCashTallyData["codeReceiptsReport"]);
            $reportCashTallyData["codeCashReport"] = $this -> getFormattedCode($reportCashTallyData["codeCashReport"]);

            $arrayDate = explode("-", $date);

            $formattedDate = array(
                "day" => $arrayDate[2],
                "month" => $arrayDate[1],
                "year" => $arrayDate[0]
            );

            $tableContent["body"] = $this -> layoutTableCashTally($reportCashTallyData);

            include_once("./TemplateReporteCierreCaja.php");
            $OBJReporteCierreCaja = new TemplateReporteCierreCaja;
            $OBJReporteCierreCaja -> showReporteCierreCaja($reportCashTallyData, $formattedDate, $tableContent);
        }

        private function layoutTableReceiptsReport($details) {
            $html = "";

            foreach($details as $detail) {
                $html .= "<tr>"
                            ."<td>" . $detail["idReceipt"] . "</td>"
                            ."<td>" . $detail["subtotal"] . "</td>"
                         ."</tr>";
            }

            return $html;
        }

        private function layoutTableCashReport($details) {
            $html = "";

            foreach($details as $detail) {
                $html .= "<tr>"
                            ."<td>" . $detail["denomination"] . "</td>"
                            ."<td>" . $detail["quantity"] . "</td>"
                            ."<td>" . $detail["subtotal"] . "</td>"
                         ."</tr>";
            }

            return $html;
        }

        private function layoutTableCashTally($reportData) {
            $html = "<tr>"
                        ."<td>Reporte de Boletas</td>"
                        ."<td>" . $reportData["codeReceiptsReport"] . "</td>"
                        ."<td>" . $reportData["totalReceipts"] . "</td>"
                     ."</tr>"
                     ."<tr>"
                        ."<td>Reporte de Caja</td>"
                        ."<td>" . $reportData["codeCashReport"] . "</td>"
                        ."<td>" . $reportData["totalCash"] . "</td>"
                     ."</tr>";

            return $html;
        }

        private function getTableHeader($typeReport) {
            $html = "";

            if($typeReport == 1) {
                $html .= "<tr>"
                            ."<th>Código de Boleta</th>"
                            ."<th>Subtotal</th>"
                         ."</tr>";
            } else if($typeReport == 2) {
                $html .= "<tr>"
                            ."<th>Denominación</th>"
                            ."<th>Cantidad</th>"
                            ."<th>Subtotal</th>"
                         ."</tr>";
            }

            return $html;
        }

        private function getTableFooter($typeReport, $totalAmount) {
            $html = "";

            if($typeReport == 1) {
                $html .= "<tr>"
                            ."<td>Total:</td>"
                            ."<td>S/ " . $totalAmount . "</td>"
                         ."</tr>";
            } else if($typeReport == 2) {
                $html .= "<tr>"
                            ."<td colspan=2>Total:</td>"
                            ."<td>S/ " . $totalAmount . "</td>"
                         ."</tr>";
            }

            return $html;
        }

        private function getFormattedCode($id) {
            $code = str_pad($id % 1000000, 6, "0", STR_PAD_LEFT);

            return $code;
        }
    }

?>