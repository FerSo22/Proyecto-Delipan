<?php 
    class TemplateReclamo {
        public function showReclamo($receiptCode, $complaintCode, $complaintData, $listProducts, $date, $refund) {
            require_once("../include/config.php");
?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <title>Reporte de Reclamo</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
                <link rel="stylesheet" href="<?php echo CSS_PATH."styles_complaint.css"?>">
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
                                <p><strong>Boleta: </strong><?php echo $receiptCode ?></p>
                                <p><strong>Empleado: </strong><?php echo $complaintData["employee"] ?></p>
                                <p><strong>Hora de Registro: </strong><?php echo $complaintData["time"] ?></p>
                                <p><strong>Solución: </strong><?php echo $complaintData["solution"] ?></p>
                            </div>
                        </div>
                        <div class="container-complaint__info">
                            <div class="complaint-info">
                                <h2>REPORTE DE RECLAMO</h2>
                                <p>N° <?php echo $complaintCode ?></p>
                            </div>
                            <div class="complaint-date">
                                <table class="table-date">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Fecha de Registro</th>
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
                        <div class="container-complaint__main">
                            <div class="container-complaint__table">
                                <table class="table-complaint">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Descripción</th>
                                            <th>Devolución</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $listProducts ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <?php echo $refund ?>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="container-complaint__details">
                                <label for="details">Detalles:</label>
                                <div class="container-text">
                                    <textarea name="details" id="details" readonly><?php echo $complaintData["details"] ?></textarea>
                                </div>
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