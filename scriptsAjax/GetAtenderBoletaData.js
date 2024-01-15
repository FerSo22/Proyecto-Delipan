$(document).ready(function() {
    $(document).on("click", "#btnClose", function() {
        $("#container-modal__message").removeClass("show");
        $("#modal-message").removeClass("show-modal");
    });

    $(document).on("click", "#btnSearchReceipt", function(e) {
        e.preventDefault();
        verifyReceiptText();
    });

    $(document).on("click", "#btnShowAll", function(e) {
        e.preventDefault();
        $("#receipt").val("");
        requestAllReceipts();   
    });

    $(document).on("click", ".btn-view", function() {
        let row = $(this)[0].closest("tr");
        let idReceipt = $(row).find("input").val();

        let url = "../salesModule/GetBoleta.php?idReceipt=" + idReceipt;

        window.open(url, "_blank");
    });

    $(document).on("click", ".btn-check", function() {
        let row = $(this)[0].closest("tr");
        let id = $(row).find("input").val();

        updateStateReceipt(row, id);
    });

    function verifyReceiptText() {
        let id = $("#receipt").val();
        const action = "searchSingleReceipt";

        $.ajax({
            url: "../salesModule/GetAtenderBoleta.php",
            type: "POST",
            data: {action, id},
            success: function(response) {
                res = JSON.parse(response);

                if(res[0][0] === true) {
                    renderTableReceipts(res[0][1]);
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
    }

    function requestAllReceipts() {
        const action = "getAllReceipts";

        $.ajax({
            url: "../salesModule/GetAtenderBoleta.php",
            type: "POST",
            data: {action},
            success: function(response) {
                res = JSON.parse(response);
                
                if(!res[0]) {
                    showMessageModal("No se encontraron boletas por atender");
                } else {
                    renderTableReceipts(res[0]);
                }
            }
        });
    }

    function updateStateReceipt(row, id) {
        const action = "updateStateReceipt";

        $.ajax({
            url: "../salesModule/GetAtenderBoleta.php",
            type: "POST",
            data: {action, id},
            success: function(response) {
                res = JSON.parse(response);

                if(res[0]) {
                    row.remove();
                    res[0] = "Boleta atendida con éxito";
                }

                showMessageModal(res[0]);
            }
        });
    }

    function showMessageModal(message) {
        var h2 = $("#message-info")
        h2.html(message);

        var divModal = $("#container-modal__message")
        divModal.addClass("show");

        var modal = $("#modal-message")
        modal.addClass("show-modal");
    }

    function renderTableReceipts(res) {
        $("#tblReceipts tbody").empty().html(res);
    }
});