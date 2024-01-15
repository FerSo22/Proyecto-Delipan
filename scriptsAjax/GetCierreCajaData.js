$(document).ready(function() { 
    $(document).on("click", "#btnReceiptsReport", function(e) {
        e.preventDefault();
        loadFormReceiptsReport();
    });

    $(document).on("click", "#btnGenerateReceiptsReport", function(e) {
        e.preventDefault();

        if(verifyExistingReceiptsReport()) {
            showMessageModal("Ya se ha generado un Reporte de Boletas para el día de hoy");
        } else {
            showConfirmationModal("El Reporte de Boletas se genera solo una vez por día, ¿está seguro de continuar?");

            $("#btnYes").off().click(function() {
                verifyNewReceiptsReport();
                hiddenConfirmationModal();
            });

            $("#btnNo").off().click(function() {
                hiddenConfirmationModal();
            });
        }
    });

    $(document).on("click", ".btn-view-receipt", function() {
        let row = $(this)[0].closest("tr");
        let idReceipt = $(row).find("input").val();

        let url = "../salesModule/GetBoleta.php?idReceipt=" + idReceipt;

        window.open(url, "_blank");
    });

    $(document).on("click", ".btn-view-complaint", function() {
        let row = $(this)[0].closest("tr");
        let idReceipt = $(row).find("input").val();

        let url = "../salesModule/GetReclamo.php?idReceipt=" + idReceipt;

        window.open(url, "_blank");
    });

    $(document).on("click", "#btnCashReport", function(e) {
        e.preventDefault();
        // loadFormCashReport();
        if(verifyExistingCashReport()) {
            showMessageModal("Ya se ha generado un Reporte de Caja para el día de hoy");
        } else {
            loadFormCashReport();
        }
    });

    $(document).on("click", "#btnGenerateCashReport", function(e) {
        e.preventDefault();

        showConfirmationModal("El Reporte de Caja se genera solo una vez por día, ¿está seguro de continuar?");

        $("#btnYes").off().click(function() {
            arrayAmountDenominations = getAmountDenominations();
            verifyCashReportData(arrayAmountDenominations);
            hiddenConfirmationModal();
        });

        $("#btnNo").off().click(function() {
            hiddenConfirmationModal();
        });

        // console.log(arrayAmountDenominations);
    });

    $(document).on("keyup", ".count-denomination", function() {
        var totalAmount = 0;

        $(".count-denomination").each(function() {
            const div = $(this)[0].closest("div");
            
            const amount = parseInt($(this).val(), 10);
            const denomination = parseFloat($(div).find(".denomination").val());

            if (!isNaN(amount) && amount >= 0 && !isNaN(denomination)) {
                totalAmount += amount * denomination;
            }
        });

        $("#totalAmount").val(totalAmount.toFixed(2));
    });

    $(document).on("click", "#btnCashTally", function(e) {
        e.preventDefault()

        if(!verifyExistingReceiptsReport() || !verifyExistingCashReport()) {
            showMessageModal("Se deben registrar los 2 reportes anteriores antes de continuar");
        } else {
            loadFormCashTally();
        }
    });

    $(document).on("click", "#btnRegisterCashTally", function(e) {
        e.preventDefault();

        verifyCashTallyData();
    });

    $(document).on("click", "#btnBack", function() {
        location.reload();
    });

    $(document).on("click", ".btn-view-report", function(e) {
        e.preventDefault();

        const div = $(this)[0].closest("div");
        const typeReport = $(div).find(".type-report").val();

        const dateReport = getCurrentDate();

        let url = "../salesModule/GetReporte.php?dateReport=" + dateReport + "&typeReport=" + typeReport;

        window.open(url, "_blank");
    });

    $(document).on("click", "#btnViewReport", function(e) {
        e.preventDefault();

        const dateReport = getCurrentDate();

        let url = "../salesModule/GetReporte.php?dateReport=" + dateReport + "&typeReport=3";
        window.open(url, "_blank");
    });

    function loadFormReceiptsReport() {
        const action = "loadFormReceiptsReport";

        $.ajax({
            async: false,
            url: "../salesModule/GetCierreCaja.php",
            type: "POST",
            data: {action},
            success: function(response) {
                $("#mainContainer").html(response);
            }
        });
    }

    function loadFormCashReport() {
        const action = "loadFormCashReport";
        
        $.ajax({
            async: false,
            url: "../salesModule/GetCierreCaja.php",
            type: "POST",
            data: {action},
            success: function(response) {
                $("#mainContainer").html(response);
            }
        });
    }

    function loadFormCashTally() {
        const action = "loadFormCashTally";

        $.ajax({
            async: false,
            url: "../salesModule/GetCierreCaja.php",
            type: "POST",
            data: {action},
            success: function(response) {
                $("#mainContainer").html(response);
            }
        });
    }

    function verifyNewReceiptsReport() {
        const action = "verifyNewReceiptsReport";

        $.ajax({
            async: false,
            url: "../salesModule/GetCierreCaja.php",
            type: "POST",
            data: {action},
            success: function(response) {
                res = JSON.parse(response);
                
                if(res[0] === "successful") {
                    const dateReport = getCurrentDate();

                    let url = "../salesModule/GetReporte.php?dateReport=" + dateReport + "&typeReport=1";
                    location.reload();
                    window.open(url, "_blank");
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
    }

    function verifyCashReportData(amountsDenominations) {
        let totalAmount = $("#totalAmount").val();
        const action = "verifyCashReportData";

        $.ajax({
            async: false,
            url: "../salesModule/GetCierreCaja.php",
            type: "POST",
            data: {action, amountsDenominations, totalAmount},
            success: function(response) {
                res = JSON.parse(response);
                
                if(res[0] === "successful") {
                    const dateReport = getCurrentDate();

                    let url = "../salesModule/GetReporte.php?dateReport=" + dateReport + "&typeReport=2";
                    location.reload();
                    window.open(url, "_blank");
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
    }

    function verifyCashTallyData() {
        let reason = $("#reason").val(); 

        const action = "verifyCashTallyData";

        $.ajax({
            async: false,
            url: "../salesModule/GetCierreCaja.php",
            type: "POST",
            data: {action, reason},
            success: function(response) {
                res = JSON.parse(response);

                if(res[0] === "successful") {
                    loadFormCashTally();
                    showMessageModal("Reporte de Cierre de Caja generado con éxito");
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
    }

    function verifyExistingCashReport() {
        const action = "verifyExistingCashReport";
        let band = false;

        $.ajax({
            async: false,
            url: "../salesModule/GetCierreCaja.php",
            type: "POST",
            data: {action},
            success: function(response) {
                res = JSON.parse(response);
                
                if(res[0]) {
                    band = true;
                }
            }
        });

        return band;
    }

    function verifyExistingReceiptsReport() {
        const action = "verifyExistingReceiptsReport";
        let band = false;

        $.ajax({
            async: false,
            url: "../salesModule/GetCierreCaja.php",
            type: "POST",
            data: {action},
            success: function(response) {
                res = JSON.parse(response);
                
                if(res[0]) {
                    band = true;
                }
            }
        });

        return band;
    }

    function getAmountDenominations() {
        var amounts = [];

        $(".count-denomination").each(function() {
            const div = $(this)[0].closest("div");
            
            const amount = $(this).val();
            const denomination = parseFloat($(div).find(".denomination").val());

            amounts.push({
                "quantity": amount,
                "denomination": denomination
            });
        });

        return amounts;
    }

    function getCurrentDate() {
        let currentDate = new Date();

        let year = currentDate.getFullYear();
        let month = currentDate.getMonth() + 1;
        let day = currentDate.getDate();

        const formattedCurrentDate = year + "-" + (month < 10 ? "0" : "") + month + "-" + (day < 10 ? "0" : "") + day;

        return formattedCurrentDate
    }

    function showMessageModal(message) {
        var h2 = $("#message-info")
        h2.html(message);

        var divModal = $("#container-modal__message")
        divModal.addClass("show");

        var modal = $("#modal-message")
        modal.addClass("show-modal");
    }

    $(document).on("click", "#btnClose", function() {
        $("#container-modal__message").removeClass("show");
        $("#modal-message").removeClass("show-modal");
    });

    function showConfirmationModal(message) {
        var h2 = $("#message-confirmation")
        h2.html(message);
    
        var divModal = $("#container-modal__confirmation")
        divModal.addClass("show");
    
        var modal = $("#modal-confirmation")
        modal.addClass("show-modal");
    }

    function hiddenConfirmationModal() {
        $("#container-modal__confirmation").removeClass("show");
        $("#modal-confirmation").removeClass("show-modal");
    }
});