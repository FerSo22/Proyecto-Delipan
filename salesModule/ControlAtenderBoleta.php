<?php
    date_default_timezone_set('America/Lima');

    class ControlAtenderBoleta {
        public function searchReceipt($id, $option) {
            $currentDate = date("Y-m-d");

            include_once("../entities/ReceiptEntity.php");
            $OBJReceipt = new ReceiptEntity;

            $results = array();

            if($option == 1) {
                $results = $OBJReceipt -> getSingleReceipt($id, $currentDate);
            } else {
                $results = $OBJReceipt -> getAllReceipts($currentDate);
            }

            if(empty($results)) {
                $results = false;
            } else {
                $results = $this -> layoutTableReceipts($results);
            }

            return $results;
        }

        public function updateStateReceipt($id) {
            include_once("../entities/ReceiptEntity.php");
            $OBJReceipt = new ReceiptEntity;

            $result = $OBJReceipt -> updateStateReceipt($id);

            return $result;
        }

        private function layoutTableReceipts($receipts) {
            $html = "";

            foreach($receipts as $receipt) {
                $html .= "<tr>"
                            ."<td>" . $receipt["code"] . "</td>"
                            ."<td>" . date("d/m/Y") . "</td>"
                            ."<td>" . $receipt["time"] . "</td>"
                            ."<td>S./ " . $receipt["totalAmount"] . "</td>"
                            ."<td>"
                                ."<input type='hidden' value=" . $receipt["code"] . ">"
                                ."<button class='btn-view'>"
                                    ."<i class='fa-solid fa-eye'></i>"
                                ."</button>"
                                ."<button class='btn-check'>"
                                    ."<i class='fa-solid fa-circle-check'></i>"
                                ."</button>"
                            ."</td>"
                         ."</tr>";
            }

            return $html;
        }
    }

?>