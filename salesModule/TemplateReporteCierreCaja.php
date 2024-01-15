<?php
    class TemplateReporteCierreCaja {
        public function showReporteCierreCaja($reportData, $date, $table) {
            require_once("../include/config.php");
?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <title>Reporte de Cierre de Caja</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
                <link rel="stylesheet" href="<?php echo CSS_PATH."styles_cashTallyReport.css"?>">
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
                                <p><strong>Empleado: </strong><?php echo $reportData["employee"] ?></p>
                                <p><strong>Hora de Registro: </strong><?php echo $reportData["time"] ?></p>
                            </div>
                        </div>
                        <div class="container-report__info">
                            <div class="report-info">
                                <h2>REPORTE DE CIERRE DE CAJA</h2>
                                <p>N° <?php echo $reportData["code"] ?></p>
                            </div>
                            <div class="report-date">
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
                        <div class="container-report__main">
                            <div class="container-report__table">
                                <table class="table-report">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Código de Reporte</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $table["body"] ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan=2>Descuadre:</td>
                                            <td>S/ <?php echo $reportData["discrepancy"] ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="container-report__reason">
                                <label for="reason">Razón:</label>
                                <div class="container-text">
                                    <textarea name="reason" id="reason" readonly><?php echo $reportData["reason"] ?></textarea>
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