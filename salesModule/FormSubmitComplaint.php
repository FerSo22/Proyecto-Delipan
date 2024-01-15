<?php
    class FormSubmitComplaint {
        public function showFormSubmitComplaint($idReceipt, $formattedIdReceipt) {
            require_once("../include/config.php");
?>

                <div class="container-btn__back">
                    <button title="Volver" type="submit" id="btnBack" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
                <div class="container-details">
                    <div class="container-title__details">
                        <h2>DETALLES DEL RECLAMO</h2>
                    </div>
                    <div class="container-receipt">
                        <h3>Boleta N° <?php echo $formattedIdReceipt ?></h3>
                    </div>
                    <div class="container-complaint__details">
                        <form action="<?php echo SALES_MODULE_PATH."GetAtencionReclamo.php"?>" method="POST" class="form-complaint__details">
                            <input type="hidden" value=<?php echo $idReceipt ?> id="idReceipt">
                            <div class="container-data">
                                <label for="details">Detalles:</label>
                                <textarea name="details" id="details" rows="3" cols="50"></textarea>
                            </div>
                            <div class="container-data">
                                <label for="complaintType">Tipo de reclamo</label>
                                <select id="complaintType" class="select-form">
                                    <option value="" class="option-form empty-option" selected></option>
                                    <option value="change" class="option-form">Cambio</option>
                                    <option value="refund" class="option-form">Reembolso</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="container-products">
                    <div class="container-title__products">
                        <h2>LISTA DE PRODUCTOS</h2>
                    </div>
                    <div class="container-list__products">
                        <div class="container-table__list">
                            <table id="tblListProducts" class="list-products">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Stock</th>
                                        <th>Cantidad</th>
                                        <th>Selección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <td>P001</td>
                                        <td>Pan Francés</td>
                                        <td>
                                            <input type="text">
                                        </td>
                                        <td>
                                            <input type="hidden" value="P001">
                                            <input type="checkbox" class="cb-selection">
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>    
                <div class="container-button">
                    <button type="submit" id="btnRegister" class="btn-register">Registrar</button>
                </div>            

<?php
        }
    }
?>