<?php 
    class ControlEmitirBoleta {
        public function insertSaleData($products, $paymentMethod, $totalAmount) {
            include_once("../entities/ReceiptEntity.php");
            $OBJReceipt = new ReceiptEntity;

            $id = $OBJReceipt -> getReceiptNumber();

            $resultReceipt = $this -> insertReceipt($paymentMethod, $totalAmount);
            $resultDetailReceipts = $this -> insertDetailReceipts($products, $id);

            include_once("./ControlProduct.php");
            $OBJProduct = new ControlProduct;
            $OBJProduct -> updateStockProduct($products);

            setcookie("idReceipt", $id, time() + (30 * 30), "/");

            return $resultReceipt && $resultDetailReceipts;
        }

        private function insertReceipt($paymentMethod, $totalAmount) {
            @session_start();

            include_once("../entities/ReceiptEntity.php");
            $OBJReceipt = new ReceiptEntity;
            
            $employee = $_SESSION["fullName"];
            
            $inserted = $OBJReceipt -> registerReceipt($totalAmount, $employee, $paymentMethod);

            return $inserted;
        }

        private function insertDetailReceipts($products, $id) {
            include_once("../entities/DetailReceiptEntity.php");
            $OBJDetailReceipt = new DetailReceiptEntity;
            $inserted = $OBJDetailReceipt -> registerDetailReceipt($products, $id);

            return $inserted;
        }
    }
?>