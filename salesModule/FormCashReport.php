<?php
    class FormCashReport {
        public function showFormCashReport($currentDate) {
            require_once("../include/config.php");
?>

                <div class="container-btn__back">
                    <button title="Volver" type="submit" id="btnBack" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
                <div class="container">
                    <div class="container-title__cash-report">
                        <h2>REPORTE DE CAJA: <?php echo $currentDate ?></h2>
                    </div>
                    <div class="container-content">
                        <div class="container-form__cash">
                            <form method="POST" action="<?php echo SALES_MODULE_PATH."GetCierreCaja.php"?>" class="form-report__cash">
                                <div class="container-data__column first-column">
                                    <div class="container-data">
                                        <label for="denomination_200" class="label-form">
                                            S/. 200:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_200" id="denomination_200" class="input-form count-denomination">
                                        <input type="hidden" value="200" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_100" class="label-form">
                                            S/. 100:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_100" id="denomination_100" class="input-form count-denomination">
                                        <input type="hidden" value="100" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_50" class="label-form">
                                            S/. 50:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_50" id="denomination_50" class="input-form count-denomination">
                                        <input type="hidden" value="50" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_20" class="label-form">
                                            S/. 20:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_20" id="denomination_20" class="input-form count-denomination">
                                        <input type="hidden" value="20" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_10" class="label-form">
                                            S/. 10:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_10" id="denomination_10" class="input-form count-denomination">
                                        <input type="hidden" value="10" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_5" class="label-form">
                                            S/. 5:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_5" id="denomination_5" class="input-form count-denomination">
                                        <input type="hidden" value="5" class="denomination">
                                    </div>
                                </div>
                                <div class="container-data__column second-column">
                                    <div class="container-data">
                                        <label for="denomination_2" class="label-form">
                                            S/. 2:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_2" id="denomination_2" class="input-form count-denomination">
                                        <input type="hidden" value="2" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_1" class="label-form">
                                            S/. 1:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_1" id="denomination_1" class="input-form count-denomination">
                                        <input type="hidden" value="1" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_0_50" class="label-form">
                                            S/. 0.50:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_0_50" id="denomination_0_50" class="input-form count-denomination">
                                        <input type="hidden" value="0.5" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_0_20" class="label-form">
                                            S/. 0.20:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_0_20" id="denomination_0_20" class="input-form count-denomination">
                                        <input type="hidden" value="0.2" class="denomination">
                                    </div>
                                    <div class="container-data">
                                        <label for="denomination_0_10" class="label-form">
                                            S/. 0.10:
                                        </label>
                                        <input type="text" value=0 min=0 name="denomination_0_10" id="denomination_0_10" class="input-form count-denomination">
                                        <input type="hidden" value="0.1" class="denomination">
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    <div class="container-total__receipts">
                        <p>TOTAL: S/</p>
                        <input type="text" value="0.00" id="totalAmount" class="input-amount" readonly>
                    </div>
                    <div class="container-button">
                        <button type="submit" id="btnGenerateCashReport" class="btn-report-cash">
                            Generar Reporte
                        </button>
                    </div>
                </div>

<?php
        }
    }

?>