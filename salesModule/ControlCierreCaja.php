<?php
    date_default_timezone_set('America/Lima');

    class ControlCierreCaja {
        public function insertReceiptsReport() {
            @session_start();

            include_once("../entities/ReceiptEntity.php");
            $OBJReceipt = new ReceiptEntity;
            $receipts = $OBJReceipt -> getReceiptsToReport();

            if(empty($receipts)) {
                return $receipts;
            }

            foreach($receipts as &$receipt) {
                $realSubtotal = $receipt["totalAmount"];

                if($receipt["refund"] != NULL) {
                    $realSubtotal -= $receipt["refund"];
                }

                $receipt["subtotal"] = number_format($realSubtotal, 2);
            }

            include_once("../entities/ReportReceiptsEntity.php");
            $OBJReportReceipts = new ReportReceiptsEntity;

            $employee = $_SESSION["fullName"];
            $totalAmount = $this -> getTotalSales($receipts);

            $reportInserted = $OBJReportReceipts -> registerReport($totalAmount, $employee);

            include_once("../entities/DetailReportReceiptsEntity.php");
            $OBJDetailReportReceipts = new DetailReportReceiptsEntity;

            $idReport = $OBJReportReceipts -> getCurrentDayReport();

            $detailsReportInserted = $OBJDetailReportReceipts -> registerDetailReport($idReport, $receipts);

            return $reportInserted && $detailsReportInserted;
        }

        public function insertCashReportData($amountsDenominations, $totalAmount) {
            @session_start();

            include_once("../entities/ReportCashEntity.php");
            $OBJReportCash = new ReportCashEntity;

            $employee = $_SESSION["fullName"];

            $reportInserted = $OBJReportCash -> registerReport($totalAmount, $employee);

            include_once("../entities/DetailReportCashEntity.php");
            $OBJDetailReportCash = new DetailReportCashEntity;

            $idReport = $OBJReportCash -> getCurrentDayReport();

            include_once("../entities/DenominationEntity.php");
            $OBJDenomination = new DenominationEntity;

            foreach($amountsDenominations as &$amount) {
                $subtotal = $amount["denomination"] * $amount["quantity"];

                $amount["idDenomination"] = $OBJDenomination -> getDenominationID(floatval($amount["denomination"]));

                $amount["subtotal"] = $subtotal;
            }

            $detailsReportInserted = $OBJDetailReportCash -> registerDetailReport($idReport, $amountsDenominations);

            return $reportInserted && $detailsReportInserted;
        }

        public function insertCashTallyData($reason) {
            @session_start();

            include_once("../entities/ReportTallyCashEntity.php");
            $OBJReportTallyCash = new ReportTallyCashEntity;

            $employee = $_SESSION["fullName"];

            include_once("../entities/ReportReceiptsEntity.php");
            $OBJReportReceipts = new ReportReceiptsEntity;
            $receiptsReportData = $OBJReportReceipts -> getReportAmount();

            include_once("../entities/ReportCashEntity.php");
            $OBJReportCash = new ReportCashEntity;
            $cashReportData = $OBJReportCash -> getReportAmount();

            $discrepancy = $receiptsReportData["totalAmount"] - $cashReportData["totalAmount"];
            
            if($discrepancy < 0) {
                $discrepancy *= (-1);
            }

            $reportsID = array(
                "receipts" => $receiptsReportData["id"],
                "cash" => $cashReportData["id"]
            );

            $response = $OBJReportTallyCash -> registerReport($employee, $reportsID, $discrepancy, $reason);

            return $response;
        }

        public function searchExistingCashReport() {
            include_once("../entities/ReportCashEntity.php");
            $OBJReportCash = new ReportCashEntity;

            $response = $OBJReportCash -> getCurrentDayReport();

            return $response;
        }

        public function searchExistingReceiptsReport() {
            include_once("../entities/ReportReceiptsEntity.php");
            $OBJReportReceipts = new ReportReceiptsEntity;

            $response = $OBJReportReceipts -> getCurrentDayReport();

            return $response;
        }

        // INVOCAR FORMULARIOS
        public function renderFormReceiptsReport() {
            include_once("../entities/ReceiptEntity.php");
            $OBJReceipt = new ReceiptEntity;
            $receipts = $OBJReceipt -> getAllCurrentDayReceipts();
            
            $tableReceipts = $this -> layoutTableReceipts($receipts);
            $currentDate = date("d/m/Y");

            $totalSales = $this -> getTotalSales($receipts);
            $numberOfReceipts = count($receipts);

            include_once("./FormReceiptsReport.php");
            $OBJFormReceiptsReport = new FormReceiptsReport;
            $OBJFormReceiptsReport -> showFormReceiptsReport($tableReceipts, $currentDate, $numberOfReceipts, $totalSales);
        }

        public function renderFormCashReport() {
            $currentDate = date("d/m/Y");

            include_once("./FormCashReport.php");
            $OBJFormCashReport = new FormCashReport;
            $OBJFormCashReport -> showFormCashReport($currentDate);
        }

        public function renderFormCashtTally() {
            $currentDate = date("d/m/Y");

            include_once("../entities/ReportReceiptsEntity.php");
            $OBJReportReceipts = new ReportReceiptsEntity;
            $receiptsAmount = $OBJReportReceipts -> getReceiptsAmount();

            include_once("../entities/ReportCashEntity.php");
            $OBJReportCash = new ReportCashEntity;
            $cashAmount = $OBJReportCash -> getCashAmount();

            $discrepancy = $receiptsAmount - $cashAmount;

            if($discrepancy < 0) {
                $discrepancy *= (-1);
            }

            $discrepancy = number_format($discrepancy, 2);

            $reportsData = array(
                "receiptsAmount" => $receiptsAmount,
                "cashAmount" => $cashAmount,
                "discrepancy" => $discrepancy
            );

            $button = $this -> getButton($currentDate);

            include_once("./FormCashTally.php");
            $OBJFormCashTally = new FormCashTally;
            $OBJFormCashTally -> showFormCashTally($reportsData, $currentDate, $button);
        }

        private function layoutTableReceipts($receipts) {
            $html = "";

            foreach($receipts as $receipt) {
                $observation = "<td>-</td>";
                $newTotalAmount = $receipt["totalAmount"];

                if($receipt["existingComplaint"] != NULL) {
                    $observation = "<td>"
                                        ."<button class='btn-view-complaint'>"
                                            ."<i class='fa-solid fa-file-circle-exclamation'></i>"
                                        ."</button>"
                                    ."</td>";
                }

                if($receipt["refund"] != NULL) {
                    $newTotalAmount = $receipt["totalAmount"] - $receipt["refund"]; 
                }

                $newTotalAmount = number_format($newTotalAmount, 2);

                $html .= "<tr>"
                            ."<td>" . $receipt["code"] . "</td>"
                            ."<td>" . $receipt["time"] . "</td>"
                            ."<td>" . $receipt["employee"] . "</td>"
                            ."<td>" . $newTotalAmount . "</td>"
                            ."<td>"
                                ."<input type='hidden' value=" . $receipt["code"] . ">"
                                ."<button class='btn-view-receipt'>"
                                    ."<i class='fa-solid fa-eye'></i>"
                                ."</button>"
                            ."</td>"
                            .$observation
                         ."</tr>";
            }

            return $html;
        }

        private function getTotalSales($receipts) {
            $total = 0;

            foreach($receipts as $receipt) {
                $receiptAmount = $receipt["totalAmount"];

                if($receipt["refund"] != NULL) {
                    $receiptAmount -= $receipt["refund"];
                } 

                $total += $receiptAmount;
            }
            
            return number_format($total, 2);
        }

        private function getButton() {
            $html = "";

            include_once("../entities/ReportTallyCashEntity.php");
            $OBJReportTallyCash = new ReportTallyCashEntity;

            $existingReport = $OBJReportTallyCash -> getCurrentDayReport();

            if($existingReport == false) {
                $html .= "<button type='submit' id='btnRegisterCashTally' class='btn-report-tally register'>"
                            ."Registrar"
                        ."</button>";
            } else {
                $html .= "<button type='submit' id='btnViewReport' class='btn-report-tally view'>"
                            ."Ver Reporte de Cierre de Caja"
                         ."</button>";
            }

            return $html;
        }
    }


?>