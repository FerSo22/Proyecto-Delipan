<?php
    class FormAtenderBoleta {
        public function showFormAtenderBoleta() {
            require_once("../include/config.php");
?>

                <div class="container">
                    <div class="container-title__attend">
                        <h2>ATENDER BOLETA</h2>
                    </div>
                    <div class="container-search__receipt">
                        <form action="<?php echo SALES_MODULE_PATH."GetAtenderBoleta.php"?>" method="POST" class="form-search__receipt">
                            <div class="container-data">
                                <label for="receipt">Número de boleta:</label>
                                <input type="text" name="receipt" id="receipt" placeholder="Número de boleta de venta" class="txt-receipt">
                            </div>
                            <button type="submit" name="btnSearchReceipt" id="btnSearchReceipt">Buscar</button>
                        </form>
                    </div>
                    <div class="container-content">
                        <button type="submit" name="btnShowAll" id="btnShowAll" class="btn-show">Mostrar todo</button>
                        <div class="container-table__receipts">
                            <table id="tblReceipts" class="table-receipts">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Fecha de Emisión</th>
                                        <th>Hora de Emisión</th>
                                        <th>Monto</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <td>000001</td>
                                        <td>18/11/2023</td>
                                        <td>10:00:56</td>
                                        <td>25.00</td>
                                        <td>
                                            <button class="btn-view">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button class="btn-check">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </button>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

<?php
        }
    }

?>