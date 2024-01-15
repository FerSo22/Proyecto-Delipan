<?php
    class ControlBoleta {
        public function renderReceipt($id) {
            if(isset($_COOKIE["idReceipt"])) {
                unset($_COOKIE["idReceipt"]);
            }

            include_once("../entities/ReceiptEntity.php");
            $OBJReceipt = new ReceiptEntity;
            $arrayReceiptInfo = $OBJReceipt -> getReceiptInfo($id);

            include_once("../entities/DetailReceiptEntity.php");
            $OBJDetailReceipt = new DetailReceiptEntity;
            $arrayDetails = $OBJDetailReceipt -> getDetailReceipt($id);

            $arrayDate = array();

            foreach($arrayReceiptInfo as $receiptInfo) {
                $arrayDate = explode("-", $receiptInfo["date"]);
                $time = $receiptInfo["time"];
                $method = $receiptInfo["payment_method"];
                $total = $receiptInfo["total_amount"];
                $employee = $receiptInfo["employee"];
            }
            
            $date = array(
                "day" => $arrayDate[2],
                "month" => $arrayDate[1],
                "year" => $arrayDate[0]
            );
            
            $code = $this -> getFormattedReceiptNumber($id);

            $listProducts = "";

            foreach($arrayDetails as $detail) {
                $listProducts .= "<tr>"
                                    ."<td>" . $detail["code"] . "</td>"
                                    ."<td>" . $detail["name"] . "</td>"
                                    ."<td>" . $detail["price"] . "</td>"
                                    ."<td>" . $detail["quantity"] . "</td>"
                                    ."<td>" . $detail["subtotal"] . "</td>"
                                 ."<tr>";
            }

            include_once("./TemplateBoleta.php");
            $OBJBoleta = new TemplateBoleta;
            $OBJBoleta -> showBoleta($listProducts, $employee, $method, $time, $date, $code, $total);
        }

        private function getFormattedReceiptNumber($id) {
            $receiptCode = "";

            $tal = ceil($id/ 200);
            $num = str_pad($id % 1000000, 6, "0", STR_PAD_LEFT);

            $receiptCode = sprintf("%03d - %06d", $tal, $num);

            return $receiptCode;
        }

    }
?>