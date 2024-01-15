<?php 
    class TemplateBoleta {
        public function showBoleta($products, $employee, $paymentMethod, $time, $date, $receiptCode, $totalAmount) {
            require_once("../include/config.php");
?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <title>Boleta de Venta</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
                <link rel="stylesheet" href="<?php echo CSS_PATH."styles_receipt.css"?>">
            </head>
            <body>
                <header class="header-main">
                    <div class="container-header">
                        <div class="business-info">
                            <div class="container-logo">
                                <div class="logo">
                                    <img src="<?php echo IMG_PATH."logo-login.png"?>" alt="">
                                </div>
                                <div class="container-title">
                                    <p>Panadería</p>
                                    <h2>DELIPAN</h2>
                                </div>
                            </div>
                            <div class="container-info">
                                <p><strong>Encargado: </strong><?php echo $employee?></p>
                                <p><strong>Moneda: </strong>Nuevo Sol</p>
                                <p><strong>Método de pago: </strong><?php echo $paymentMethod ?></p>
                                <p><strong>Hora de transacción: </strong><?php echo $time ?></p>
                            </div>
                        </div>
                        <div class="container-receipt__info">
                            <div class="receipt-info">
                                <h3>RUC N° 10107507944</h3>
                                <h2>BOLETA DE VENTA</h2>
                                <p><?php echo $receiptCode ?></p>
                            </div>
                            <div class="receipt-date">
                                <table class="table-date">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Fecha de Emisión</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Día</td>
                                            <td>Mes</td>
                                            <td>Año</td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $date["day"] ?></td>
                                            <td><?php echo $date["month"] ?></td>
                                            <td><?php echo $date["year"] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </header>

                <main>
                    <div class="container-main">
                        <div class="container-receipt__main">
                            <div class="container-receipt__table">
                                <table class="table-receipt">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Descripción</th>
                                            <th>Precio (U)</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $products ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Total</td>
                                            <td>S/ <?php echo $totalAmount ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </body>
            </html>

<?php
        }
    }

?>