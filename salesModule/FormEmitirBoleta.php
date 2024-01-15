<?php
    class FormEmitirBoleta {
        public function showFormEmitirBoleta() {
            require_once("../include/config.php");
?>

                            <div class="container-search">
                                <div class="container-title__search">
                                    <h2>BÚSQUEDA DE PRODUCTOS</h2>
                                </div>
                                <div class="container-search__product">
                                    <form action="<?php echo SALES_MODULE_PATH."GetProduct.php"?>" method="POST" class="form-search__product">
                                        <div class="container-data">
                                            <label for="product">Producto:</label>
                                            <input type="text" name="product" id="product" placeholder="Código o nombre de producto" class="txt-product">
                                        </div>
                                        <button type="submit" name="btnSearchProduct" id="btnSearchProduct">Buscar</button>
                                    </form>
                                </div>
                                <div class="container-table__products">
                                    <table id="tblProducts" class="table-products">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Categoría</th>
                                                <th>Precio (U)</th>
                                                <th>Stock</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="container-sale">
                                <div class="container-title__sale">
                                    <h2>LISTA DE PRODUCTOS</h2>
                                </div>
                                <div class="container-list__products">
                                    <div class="container-table__list">
                                        <table id="tblListProducts" class="list-products">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Precio (U)</th>
                                                    <th>Cantidad</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <form action="<?php echo SALES_MODULE_PATH."GetEmitirBoleta.php"?>" method="POST" class="form-payment_method">
                                        <div class="container-total">
                                            <label for="total">Monto: S/.</label>
                                            <input type="text" value="0.00" name="total" id="total" readonly >
                                        </div>
                                        <div class="container-data">
                                            <label>
                                                <input type="radio" name="payment-method" value="Efectivo">
                                                <div class="container-method__img">
                                                    <img src="<?php echo ICON_PATH."cash-icon.png" ?>" alt="">
                                                </div>
                                            </label>
                                            <label>
                                                <input type="radio" name="payment-method" value="Yape">
                                                <div class="container-method__img">
                                                    <img src="<?php echo ICON_PATH."yape-icon.png"?>" alt="">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="container-buttons__sale">
                                            <button type="submit" name="btnCancelList" id="btnCancelList" class="btn-cancel">Anular</button>
                                            <button type="submit" name="btnConfirmSale" id="btnConfirmSale" class="btn-confirm">Confirmar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        
<?php
        }   
    }

?>