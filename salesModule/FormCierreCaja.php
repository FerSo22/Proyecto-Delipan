<?php
    class FormCierreCaja {
        public function showFormCierreCaja() {
            require_once("../include/config.php");
?>

                <div class="container">
                    <div class="container-title__cash">
                        <h2>CIERRE DE CAJA</h2>
                    </div>
                    <div class="container-options">
                        <form action="<?php echo SALES_MODULE_PATH."GetCierreCaja.php"?>" method="POST" class="form-options">
                            <div class="container-button__option">
                                <button type="submit" name="btnReceiptsReport" id="btnReceiptsReport">
                                    <p>Generar Reporte de Boletas</p>
                                    <div class="container-icon__button">
                                        <img src="<?php echo ICON_PATH."receipts-report-icon.png" ?>">
                                    </div>
                                </button>
                            </div>
                            <div class="container-button__option">
                                <button type="submit" name="btnCashReport" id="btnCashReport">
                                    <p>Generar Reporte de Caja</p>
                                    <div class="container-icon__button">
                                        <img src="<?php echo ICON_PATH."cash-report-icon.png" ?>">
                                    </div>
                                </button>
                            </div>
                            <div class="container-button__option">
                                <button type="submit" name="btnCashTally" id="btnCashTally">
                                    <p>Generar Reporte de Cierre de Caja</p>
                                    <div class="container-icon__button">
                                        <img src="<?php echo ICON_PATH."view-receipts-icon.png" ?>">
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

<?php
        }
    }

?>