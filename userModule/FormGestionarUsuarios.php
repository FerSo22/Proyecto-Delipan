<?php
    class FormGestionarUsuarios {
        public function showFormGestionarUsuarios() {
            require_once("../include/config.php");
?>

                <div class="container">
                    <div class="container-title__manage">
                        <h2>GESTIONAR USUARIOS</h2>
                    </div>
                    <div class="container-content">
                        <button type="submit" id="btnToRegisterForm" class="btn-register">Registrar usuario</button>
                        <div class="container-table__users">
                            <table id="tblUsers" class="table-users">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>N° de DNI</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <td>Jetmayer</td>
                                        <td>jquispe7272</td>
                                        <td>72510472</td>
                                        <td>
                                            <input type="hidden" value=2>
                                            <button class="btn-modifiy">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <div class="container-switch">
                                                <div class="switch-update">
                                                    <input type="checkbox" name="switchState" class="switch-state">
                                                    <label class="switch-state__label" for="switchState">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
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