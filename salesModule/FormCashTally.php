<?php
    class FormCashTally {
        public function showFormCashTally($reportsData, $currentDate, $button) {
            require_once("../include/config.php");
?>

                <div class="container-btn__back">
                    <button title="Volver" type="submit" id="btnBack" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
                <div class="container">
                    <div class="container-title__tally">
                        <h2>REPORTE DE CIERRE DE CAJA: <?php echo $currentDate ?></h2>
                    </div>
                    <div class="container-content">
                        <div class="container-form__tally">
                            <form method="POST" action="<?php echo SALES_MODULE_PATH."GetCierreCaja.php"?>" class="form-report__tally">
                                <div class="container-data__column">
                                    <div class="container-data">
                                        <label for="receipts-report__total" class="label-form">
                                            Reporte de Boletas:
                                        </label>
                                        <div class="container-report__info">
                                            <input type="text" value="S/ <?php echo $reportsData["receiptsAmount"] ?>" name="receipts-report__total" id="receipts-report__total" class="input-form" readonly>
                                            <button class="btn-view-report">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <input type="hidden" value=1 class="type-report">
                                        </div>
                                        <!-- <input type="hidden" value="200" class="denomination"> -->
                                    </div>
                                    <div class="container-data">
                                        <label for="cash-report__total" class="label-form">
                                            Reporte de Caja:
                                        </label>
                                        <div class="container-report__info">
                                            <input type="text" value="S/ <?php echo $reportsData["cashAmount"] ?>" name="cash-report__total" id="cash-report__total" class="input-form" readonly>
                                            <button class="btn-view-report">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <input type="hidden" value=2 class="type-report">
                                        </div>
                                        <!-- <input type="hidden" value="200" class="denomination"> -->
                                    </div>
                                    <div class="container-data">
                                        <label for="discrepancy" class="label-form">
                                            Descuadre:
                                        </label>
                                        <input type="text" value="S/ <?php echo $reportsData["discrepancy"] ?>" name="discrepancy" id="discrepancy" class="input-form" readonly>
                                        <!-- <input type="hidden" value="200" class="denomination"> -->
                                    </div>
                                    <div class="container-data">
                                        <label for="reason" class="label-form">Razón:</label>
                                        <textarea name="reason" id="reason" rows="3" cols="50"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="container-button">
                        <?php echo $button ?>
                    </div>
                </div>

<?php
        }
    }

?>