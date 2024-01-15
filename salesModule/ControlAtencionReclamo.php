<?php
    class ControlAtencionReclamo {
        public function searchReceipt($id) {
            include_once("../entities/ReceiptEntity.php");
            $OBJReceipt = new ReceiptEntity;
            $result = $OBJReceipt -> simpleSearchReceipt($id);

            $existing = $OBJReceipt -> verifyExistingComplaint($id);

            if(empty($result)) {
                $result = false;
            } else {
                $result = $this -> layoutRowReceipt($result, $existing);
            }

            return $result;
        }

        public function getReceiptDetails($id) {
            include_once("../entities/DetailReceiptEntity.php");
            $OBJDetailReceipt = new DetailReceiptEntity;

            $purchasedProducts = $OBJDetailReceipt -> getPurchasedProducts($id);

            include_once("../entities/ProductEntity.php");
            $OBJProduct = new ProductEntity;

            $listProducts = $OBJProduct -> getListProducts($purchasedProducts);

            // $receiptData = array(
            //     "purchasedProducts" => $purchasedProducts, 
            //     "listProducts" => $listProducts);

            return $listProducts;
        }

        public function insertComplaint($details, $complaintType, $products, $idReceipt) {
            @session_start();

            $employee = $_SESSION["fullName"];

            include_once("../entities/ComplaintEntity.php");
            $OBJComplaint = new ComplaintEntity;

            $complaintData = array();
            $productsComplaint = array();
            $refund = 0;

            foreach($products as $product) {
                $productsComplaint[] = array(
                    "code" => $product["code"],
                    "quantity" => $product["quantity"],
                    "category" => $product["category"]
                );
            }

            if($complaintType == "refund") {
                $refund = $this -> getRefund($productsComplaint);
            }

            $complaintData = array(
                "details" => $details,
                "idReceipt" => $idReceipt,
                "employee" => $employee,
                "refund" => $refund
            );

            $OBJComplaint -> registerComplaint($complaintData, $complaintType);

            include_once("../entities/DetailComplaintEntity.php");
            $OBJDetailComplaint = new DetailComplaintEntity;

            $id = $OBJComplaint -> getComplaintNumber();

            $OBJDetailComplaint -> registerDetailComplaint($productsComplaint, $id);

            $this -> updateStockProducts($productsComplaint, $complaintType);
        }

        private function updateStockProducts($products, $type) {
            include_once("../entities/ProductEntity.php");
            $OBJProduct = new ProductEntity;
            
            if($type == "refund") {
                foreach($products as $product) {
                    if($product["category"] == "panes") {
                        $actualStock = $OBJProduct -> getStockProduct($product["code"]);
                        $newStock = $actualStock + $product["quantity"];

                        $OBJProduct -> updateStockProduct($product["code"], $newStock);
                    }
                }
            } else {
                foreach($products as $product) {
                    $actualStock = $OBJProduct -> getStockProduct($product["code"]);
                    $newStock = $actualStock - $product["quantity"];

                    $OBJProduct -> updateStockProduct($product["code"], $newStock);
                }
            }
            
        }

        private function getRefund($products) {
            include_once("../entities/ProductEntity.php");
            $OBJProduct = new ProductEntity;

            $totalRefunded = 0;

            foreach($products as $product) {
                $price = $OBJProduct -> getPriceProduct($product["code"]);

                $totalRefunded += $product["quantity"] * $price;
            }

            $totalRefunded = round($totalRefunded, 1);

            return $totalRefunded;
        }

        // INVOCAR FORMULARIOS
        public function renderFormSubmitComplaint($id) {
            $formattedCode = $this -> getFormattedReceiptNumber($id);

            include_once("./FormSubmitComplaint.php");
            $OBJFormSubmitComplaint = new FormSubmitComplaint;
            $OBJFormSubmitComplaint -> showFormSubmitComplaint($id, $formattedCode);
        }

        private function layoutRowReceipt($receipt, $existing) {
            $expired = "";
            $classComplaint = "";
            $formattedDate = date("d/m/Y", strtotime($receipt["date"]));

            
            if($formattedDate != date("d/m/Y")) {
                $expired = "class='expired' title='Fuera de fecha'";
            }

            if($existing) {
                $classComplaint = "view-complaint";
            } else {
                $classComplaint = "btn-complaint";
            }

            $html = "<tr>"
                        ."<td>" . $receipt["code"] . "</td>"
                        ."<td " . $expired . ">" . $formattedDate . "</td>"
                        ."<td>" . $receipt["employee"] . "</td>"
                        ."<td>"
                            ."<input type='hidden' value=" . $receipt["code"] . ">"
                            ."<button class='btn-view'>"
                                ."<i class='fa-solid fa-eye'></i>"
                            ."</button>"
                            ."<button class='" . $classComplaint ."'>"
                                ."<i class='fa-solid fa-file-circle-exclamation'></i>"
                            ."</button>"
                        ."</td>"
                    ."</tr>";

            return $html;
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