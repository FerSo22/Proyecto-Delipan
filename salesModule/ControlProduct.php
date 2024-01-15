<?php 

    class ControlProduct {
        public function searchProduct($product) {
            include_once("../entities/ProductEntity.php");
            $OBJProduct = new ProductEntity;
            $results = $OBJProduct -> verifyProduct($product);
            
            $responseHTML = "";

            foreach($results[1] as $row) {
                $category = "";

                if($row["id_category"] == 1) {
                    $category = "Panes";
                } else {
                    $category = "Abarrotes";
                }

                $responseHTML .= "<tr>"
                                    . "<td>" . $row["code"] . "<input type='hidden' value='" . $row["code"] . "' class='code'></td>"
                                    . "<td>" . $row["name"] . "<input type='hidden' value='" . $row["name"] . "' class='name'></td>"
                                    ."<td>" . $category . "</td>"
                                    ."<td>" . $row["price"] . "<input type='hidden' value=" . $row["price"] ." class='price'></td>"
                                    ."<td>" . $row["stock"] . "<input type='hidden' value=" . $row["stock"] ." class='stock'></td>"
                                    ."<td> <button class='btn-add'> <i class='fa-solid fa-circle-plus'></i> </button> </td>"
                                . "</tr>";
            }

            
            $results[1] = $responseHTML;

            return $results;
        }

        public function updateStockProduct($products) {
            include_once("../entities/ProductEntity.php");
            $OBJProduct = new ProductEntity;

            $newStock = 0;

            foreach($products as $product) {
                $id = $product["code"];
                $currentStock = $OBJProduct -> getStockProduct($id);
                $purchasedAmount = $product["quantity"];
                
                $newStock =  $currentStock - $purchasedAmount;

                $OBJProduct ->  updateStockProduct($id, $newStock);
            }
        }
    }

?>