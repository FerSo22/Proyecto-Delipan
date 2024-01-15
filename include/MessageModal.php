<?php
    require_once("config.php");

    class MessageModal {
        public function messageModal() {
?>

            <div id="container-modal__message" class="container-modal">
                <div id="modal-message" class="modal">
                    <div class="container-img">
                        <img src="<?php echo ICON_PATH."information-icon.png"?>" class="img-modal">
                    </div>
                    <h2 id="message-info"></h2>
                    <button id="btnClose" class="btn-close">Cerrar</button>
                </div>
            </div>

<?php
        }
    
        public function confirmationModal() {
?>

            <div id="container-modal__confirmation" class="container-modal">
                <div id="modal-confirmation" class="modal">
                    <div class="container-img">
                        <img src="<?php echo ICON_PATH."information-icon.png"?>" class="img-modal">
                    </div>
                    <h2 id="message-confirmation"></h2>
                    <div class="container-buttons">
                        <button id="btnYes" class="btn-close yes">Sí</button>
                        <button id="btnNo" class="btn-close no">No</button>
                    </div>
                </div>
            </div>

<?php
        }
    }
?>