<?php
    class FormAtencionReclamo {
        public function showFormAtencionReclamo() {
            require_once("../include/config.php");
?>

                <div class="container">
                    <div class="container-title__attend">
                        <h2>ATENCIÓN AL RECLAMO</h2>
                    </div>
                    <div class="container-search__receipt">
                        <form action="<?php echo SALES_MODULE_PATH."GetAtencionReclamo.php"?>" method="POST" class="form-search__receipt">
                            <div class="container-data">
                                <label for="receipt">Número de boleta:</label>
                                <input type="text" name="receipt" id="receipt" placeholder="Número de boleta de venta" class="txt-receipt">
                            </div>
                            <button type="submit" name="btnSearchReceipt" id="btnSearchReceipt">Buscar</button>
                        </form>
                    </div>
                    <div class="container-content">
                        <div class="container-table__receipt">
                            <table id="tblReceipt" class="table-receipt">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Fecha de Emisión</th>
                                        <th>Emitida por</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

<?php
        }
    }

?>