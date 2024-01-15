<?php
    class TemplateReporte {
        public function showReporte($reportData, $reportType, $table, $date, $reportCode) {
            require_once("../include/config.php");
?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <title>Reporte de <?php echo $reportType ?></title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
                <link rel="stylesheet" href="<?php echo CSS_PATH."styles_secondaryReports.css"?>">
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
                                <p><strong>Tipo de Reporte: </strong><?php echo $reportType ?></p>
                            </div>
                        </div>
                        <div class="container-report__info">
                            <div class="report-info">
                                <h2>REPORTE DE <?php echo strtoupper($reportType) ?></h2>
                                <p>N° <?php echo $reportCode ?></p>
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
                                        <?php echo $table["header"] ?> 
                                    </thead>
                                    <tbody>
                                        <?php echo $table["body"] ?>
                                    </tbody>
                                    <tfoot>
                                        <?php echo $table["footer"] ?>
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