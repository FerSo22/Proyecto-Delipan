<?php
    class FormRegisterUser {
        public function showFormRegisterUser($rowsPrivileges) {
            require_once("../include/config.php");
?>

                <div class="container">
                    <div class="container-btn__back">
                        <button title="Volver" type="submit" id="btnBack" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>
                    <div class="container-title__register">
                        <h2>REGISTRAR USUARIO</h2>
                    </div>
                    <div class="container-content">
                        <div class="container-form__user">
                            <form method="POST" action="<?php echo USER_MODULE_PATH."GetGestionarUsuariosData.php" ?>" class="form-edit__user">
                                <div class="container-data__column first-column">
                                    <div class="container-data">
                                        <label for="name">Nombre</label>
                                        <input type="text" name="name" id="name" class="input-form"/>	
                                    </div>
                                    <div class="container-data">
                                        <label for="lastName">Apellidos</label>
                                        <input type="text" name="lastName" id="lastName" class="input-form"/>	
                                    </div>
                                    <div class="container-data">
                                        <label for="dni">N° de DNI</label>
                                        <input type="text" name="dni" id="dni" class="input-form"/>	
                                    </div>
                                    <div class="container-data">
                                        <label for="pass">Contraseña</label>
                                        <input type="password" name="pass" id="pass" class="input-form"/>	
                                    </div>
                                    <div class="container-data">
                                        <label for="rePass">Confirmar contraseña</label>
                                        <input type="password" name="rePass" id="rePass" class="input-form"/>	
                                    </div>
                                    <div class="container-data">
                                        <label for="countQuestions">Cantidad de Preguntas</label>
                                        <select id="countQuestions" class="select-form">
                                            <option value="" class="option-form empty-option" selected></option>
                                            <option value=1 class="option-form">1</option>
                                            <option value=2 class="option-form">2</option>
                                            <option value=3 class="option-form">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="container-data__column second-column" id="secondColumn">
                                </div>
                            </form>
                            <div class="container-table__privileges">
                                <div class="container-data">
                                    <table id="tblPrivileges" class="table-privileges">
                                        <thead>
                                            <tr>
                                                <th>Selección</th>
                                                <th>Privilegio de Sistema</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $rowsPrivileges ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="container-button">
                                <button type="submit" id="btnRegister" class="btn-save">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>

<?php
        }
    }

?>