<?php
    class FormReceiptsReport {
        public function showFormReceiptsReport($receiptsRows, $currentDate, $numberOfReceipts, $totalSales) {
            require_once("../include/config.php");
?>

                <div class="container-btn__back">
                    <button title="Volver" type="submit" id="btnBack" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
                <div class="container">
                    <div class="container-title__receipts">
                        <h2>VENTAS DEL DÍA: <?php echo $currentDate ?></h2>
                    </div>
                    <div class="container-content">
                        <div class="container-table__receipts">
                            <table id="tblReceipts" class="table-receipts">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Hora de Emisión</th>
                                        <th>Emitida por</th>
                                        <th>Monto Final</th>
                                        <th>Detalle</th>
                                        <th>Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $receiptsRows ?>
                                </tbody>
                            </table>
                            
                        </div>
                        <div class="container-sales__info">
                            <div class="container-info">
                                <div class="container-receipts__number">
                                    Total de Boletas: <?php echo $numberOfReceipts ?> 
                                </div>
                                <div class="container-total__sales">
                                    Total Final: S/ <?php echo $totalSales ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-button">
                        <button type="submit" id="btnGenerateReceiptsReport" class="btn-report-receipts">
                            Generar Reporte
                        </button>
                    </div>
                </div>

<?php
        }
    }


?>