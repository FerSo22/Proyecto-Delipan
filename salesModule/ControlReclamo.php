<?php
    class ControlReclamo {
        public function renderComplaint($idReceipt) {
            include_once("../entities/ComplaintEntity.php");
            $OBJComplaint = new ComplaintEntity;
            $arrayComplaintInfo = $OBJComplaint -> getComplaintInfo($idReceipt);

            include_once("../entities/DetailComplaintEntity.php");
            $OBJDetailComplaint = new DetailComplaintEntity;
            $arrayDetails = $OBJDetailComplaint -> getDetailComplaint($arrayComplaintInfo["id"]);

            $arrayDate = explode("-", $arrayComplaintInfo["date"]);
            
            $date = array(
                "day" => $arrayDate[2],
                "month" => $arrayDate[1],
                "year" => $arrayDate[0]
            );
            
            $receiptCode = $this -> getFormattedReceiptNumber($idReceipt);
            $complaintCode = $this -> getFormattedComplaintNumber($arrayComplaintInfo["id"]);
            $listProducts = $this -> layoutTableDetailComplaint($arrayDetails);

            $refund = $arrayComplaintInfo["refund"];

            if($refund == 0) {
                $refund = "";
            } else {
                $refund = "<td colspan='2'>Monto devuelto:</td>"
                          ."<td>S/ " . $arrayComplaintInfo["refund"] . "</td>";
            }

            include_once("./TemplateReclamo.php");
            $OBJReclamo = new TemplateReclamo;
            $OBJReclamo -> showReclamo($receiptCode, $complaintCode, $arrayComplaintInfo, $listProducts, $date, $refund);
        }

        private function layoutTableDetailComplaint($products) {
            $html = "";

            foreach($products as $product) {
                $html .= "<tr>"
                            ."<td>" . $product["code"] . "</td>"
                            ."<td>" . $product["name"] . "</td>"
                            ."<td>" . $product["quantity"] . "</td>"
                         ."<tr>";
            }

            return $html;
        }

        private function getFormattedReceiptNumber($id) {
            $receiptCode = "";

            $tal = ceil($id/ 200);
            $num = str_pad($id % 1000000, 6, "0", STR_PAD_LEFT);

            $receiptCode = sprintf("%03d - %06d", $tal, $num);

            return $receiptCode;
        }

        private function getFormattedComplaintNumber($id) {
            $code = str_pad($id % 1000000, 6, "0", STR_PAD_LEFT);

            return $code;
        }
    }
?>