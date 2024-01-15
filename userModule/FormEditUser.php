<?php
    class FormEditUser {
        public function showFormEditUser($user, $userData, $fieldsQuestionAnswer, $userPrivileges) {
            require_once("../include/config.php");
?>

                <div class="container">
                    <div class="container-btn__back">
                        <button title="Volver" type="submit" id="btnBack" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>
                    <div class="container-title__edit">
                        <h2>EDITAR USUARIO: <?php echo strtoupper($user) ?></h2>
                    </div>
                    <div class="container-content">
                        <div class="container-form__user">
                            <form method="POST" action="<?php echo USER_MODULE_PATH."GetGestionarUsuariosData.php" ?>" class="form-edit__user">
                                <input type="hidden" id="user" value="<?php echo $user ?>">
                                <div class="container-data__column first-column">
                                    <div class="container-data">
                                        <label>Nombre</label>
                                        <input type="text" value="<?php echo $userData["name"] ?>" class="input-form no-edit" readonly/>	
                                    </div>
                                    <div class="container-data">
                                        <label>Apellidos</label>
                                        <input type="text" value="<?php echo $userData["lastName"] ?>" class="input-form no-edit" readonly/>	
                                    </div>
                                    <div class="container-data">
                                        <label>N° de DNI</label>
                                        <input type="text" value="<?php echo $userData["dni"] ?>" class="input-form no-edit" readonly/>	
                                    </div>
                                    <div class="container-clarification">
                                        <p>Llenar solo si desea cambiar la contraseña</p>
                                    </div>
                                    <div class="container-data">
                                        <label for="newPass">Nueva contraseña</label>
                                        <input type="password" name="newPass" id="newPass" class="input-form"/>	
                                    </div>
                                    <div class="container-data">
                                        <label for="reNewPass">Confirmar nueva contraseña</label>
                                        <input type="password" name="reNewPass" id="reNewPass" class="input-form"/>	
                                    </div>
                                </div>
                                <div class="container-data__column second-column">
                                    <?php echo $fieldsQuestionAnswer ?>
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
                                            <?php echo $userPrivileges ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="container-button">
                                <button type="submit" id="btnSave" class="btn-save">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>

<?php
        }
    }
?>