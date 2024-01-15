$(document).ready(function() {
    let complaintType = "";
    let arrayProducts = [];

    $(document).on("click", "#btnClose", function() {
        $("#container-modal__message").removeClass("show");
        $("#modal-message").removeClass("show-modal");
    });

    $(document).on("click", "#btnSearchReceipt", function(e) {
        e.preventDefault();
        verifyReceiptText();
    });

    $(document).on("click", ".btn-view", function() {
        let row = $(this)[0].closest("tr");
        let idReceipt = $(row).find("input").val();

        let url = "../salesModule/GetBoleta.php?idReceipt=" + idReceipt;

        window.open(url, "_blank");
    });

    $(document).on("click", ".view-complaint", function() {
        let row = $(this)[0].closest("tr");
        let idReceipt = $(row).find("input").val();

        let url = "../salesModule/GetReclamo.php?idReceipt=" + idReceipt;

        window.open(url, "_blank");
    });

    $(document).on("click", ".btn-complaint", function() {
        let row = $(this)[0].closest("tr");
        let idReceipt = $(row).find("input").val();

        arrayProducts = [];

        arrayProducts = getReceiptDetails(idReceipt);
        loadFormSubmitComplaint(idReceipt);
    });

    $(document).on("click", "#btnBack", function() {
        // let idReceipt = $("#idReceipt").val();
        location.reload();
        arrayProducts = [];
        
    });

    $(document).on("change", "#complaintType", function() {
        complaintType = $(this).val();

        layoutTablePurchasedProducts();
    });

    $(document).on("click", "#btnRegister", function(e) {
        e.preventDefault();
        verifyComplaintData();
    });

    $(document).on("change", ".cb-selection", function() {
        let row = $(this)[0].closest("tr");
        let cell = $(row).find(".quantity")[0];
        let category = $(row).find(".category").val();
        let max = $(row).find(".purchased-quantity").val();

        if($(this).is(":checked")) {
            if(complaintType === "change") {
                if(category === "abarrotes") {
                    insertInputQuantity(cell, max, "readwrite");
                }
            } else {
                if(category === "abarrotes") {
                    insertInputQuantity(cell, max, "readwrite");
                } else {
                    insertInputQuantity(cell, max, "readonly");
                }
            }
        } else {
            removeInputQuantity(cell);
        }
    });

    function verifyReceiptText() {
        let id = $("#receipt").val();
        const action = "verifyReceipText";

        $.ajax({
            url: "../salesModule/GetAtencionReclamo.php",
            type: "POST",
            data: {action, id},
            success: function(response) {
                res = JSON.parse(response);

                if(res[0][0] === true) {
                    renderTableReceipt(res[0][1]);
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
    }

    function verifyComplaintData() {
        let details = $("#details").val();
        let selectedProducts = getSelectedProducts();

        let idReceipt = $("#idReceipt").val();

        const action = "verifyComplaintData";

        $.ajax({
            async: false,
            url: "../salesModule/GetAtencionReclamo.php",
            type: "POST",
            data: {action, details, selectedProducts, complaintType, idReceipt},
            success: function(response) {
                if(response === "") {
                    // showMessageModal("Reclamo registrado con éxito");
                    // loadFormSubmitComplaint(idReceipt);
                    let url = "../salesModule/GetReclamo.php?idReceipt=" + idReceipt;
                    location.reload();
                    window.open(url, "_blank");
                } else {
                    res = JSON.parse(response);
                    showMessageModal(res[0]);
                }
            }
        });
    }

    function loadFormSubmitComplaint(id) {
        const action = "loadFormSubmitComplaint";

        $.ajax({
            async: false,
            url: "../salesModule/GetAtencionReclamo.php",
            type: "POST",
            data: {action, id},  
            success: function(response) {
                $("#mainContainer").html(response);
            }
        });
    }

    function getReceiptDetails(id) {
        const action = "getReceiptDetails";
        let listProducts = [];

        $.ajax({
            async: false,
            url: "../salesModule/GetAtencionReclamo.php",
            type: "POST",
            data: {action, id},
            success: function(response) {
                res = JSON.parse(response);

                listProducts = res;
            }
        });

        return listProducts;
    }

    function getSelectedProducts() {
        let checkbox = $(".cb-selection");
        let selectedCheckbox = checkbox.filter(":checked");

        let array = [];

        selectedCheckbox.each(function() {
            const row = $(this)[0].closest("tr");
            const code = $(this).attr("id");
            const name = $(row).find(".name").val();
            const stock = $(row).find(".stock").val();
            const category = $(row).find(".category").val();
            const quantity = $(row).find(".quantity-change").val();
            const purchasedQuantity = $(row).find(".purchased-quantity").val();

            array.push({
                "code": code,
                "name": name,
                "stock": stock,
                "category": category,
                "quantity": quantity,
                "purchasedQuantity": purchasedQuantity
            });
        });
        
        return array;
    }

    function insertInputQuantity(cell, max, type) {
        let html = "";

        if(type === "readwrite") {
            // html = `<input type="text" max=${max} class="quantity-change">`;
            html = `<input type="text" value=1  class="quantity-change"><p class="max">(máx: ${max})`;
        } else {
            html = `<input type="text" value="${max}" class="quantity-change no-edit" readonly>`;
        }

        $(cell).empty().append(html);
    }

    function removeInputQuantity(cell) {
        $(cell).html("");
    }

    function layoutTablePurchasedProducts() {
        let html = "";

        arrayProducts.forEach((product) => {
            let disabled = "";

            if(complaintType === "change" && product["category"] === "panes" || product["stock"] === 0) {
                disabled = "disabled";
            }

            html += `<tr>
                        <td>${product["code"]}</td>
                        <td>${product["name"]} <input type="hidden" value="${product["category"]}" class="category"> <input type="hidden" value="${product["name"]}" class="name"></td>
                        <td>${product["stock"]} <input type="hidden" value="${product["stock"]}" class="stock"></td>
                        <td class="quantity"></td>
                        <td><label for="${product["code"]}" class="${disabled}"><input type="checkbox" class="cb-selection ${disabled}" id="${product["code"]}" ${disabled}></label><input type="hidden" value="${product["quantity"]}" class="purchased-quantity"></td>`;
            
        });

        $("#tblListProducts tbody").empty().html(html);
    }

    function showMessageModal(message) {
        var h2 = $("#message-info")
        h2.html(message);

        var divModal = $("#container-modal__message")
        divModal.addClass("show");

        var modal = $("#modal-message")
        modal.addClass("show-modal");
    }

    function renderTableReceipt(res) {
        $("#tblReceipt tbody").empty().html(res);
    }

});