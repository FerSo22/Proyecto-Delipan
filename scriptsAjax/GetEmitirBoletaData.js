$(document).ready(function() {
    var listProducts = [];
    var tempQuantities = [];
    var totalAmount;

    $(document).on("click", ".button-list__inside", function() {
        listProducts = [];
        tempQuantities = [];
        totalAmount = 0;
    });

    $(document).on("click", "#btnSearchProduct", function(e) {
        emptyTable();

        if(!verifyProductText()) {
            e.preventDefault();
        }
    });

    $(document).on("click", "#btnClose", function() {
        $("#container-modal__message").removeClass("show");
        $("#modal-message").removeClass("show-modal");
    });
    
    $(document).on("click", ".btn-add", function() {
        let row = $(this)[0].closest("tr");

        let code = $(row).find(".code").val();
        let name = $(row).find(".name").val();
        let price = $(row).find(".price").val();
        let stock = $(row).find(".stock").val();

        let product = {code, name, price, stock};

        if(parseInt(stock) === 0) {
            showMessageModal("Stock insuficiente");
        } else {
            addProduct(product, code);
        }
        
        updateArrayQuantities();
        updateTotalAmount();
    });

    $(document).on("click", ".btn-delete", function() {
        let row = $(this)[0].closest("tr");

        let code = $(row).find(".code").val();

        removeProduct(row, code);

        updateArrayQuantities();
        updateTotalAmount();
        //console.log(listProducts);
    });

    function verifyProductText() {
        let product = $("#product").val();
        let band = false;
        const action = "searchProduct";

        $.ajax({
            async: false,
            url: "../salesModule/GetProduct.php",
            type: "POST",
            data: {action, product},
            success: function(response) {
                res = JSON.parse(response);

                if (res[0][0] == true) {
                    renderTableProducts(res[0][1]);
                } else {
                    showMessageModal(res[0]);
                }
            }
        });

        return band;
    }

    function addProduct(product, code) {
        duplicate = listProducts.some(function(p) {
            return p.code === code;
        });

        if(!duplicate) {
            let html = "<tr>"
                    + "<td>" + product["code"] + " <input type='hidden' value='" + product["code"] + "' class='code'> </td>"
                    + "<td>" + product["name"] + " <input type='hidden' value='" + product["name"] + "'> </td>"
                    + "<td>" + product["price"] + " <input type='hidden' value=" + product["price"] + "> </td>"
                    // + "<td> <input type='text' min=1 max='" + product["stock"] + "' class='quantity' value=1> </td>"
                    + "<td> <input type='text' class='quantity' value=1> </td>"
                    + "<td> <button class='btn-delete'> <i class='fa-solid fa-ban'></i> </button> </td>";

            $("#tblListProducts tbody").append(html);

            listProducts.push(product);
        } else {
            showMessageModal("El producto ya se encuentra en la lista");
        }
    }

    function removeProduct(product, code) {
        product.remove();

        var index = listProducts.findIndex(function(p) {
            return p.code === code;
        });

        if(index !== -1) {
            listProducts.splice(index, 1);
        }
    }

    function updateTotalAmount() {
        totalAmount = 0;

        if(listProducts.length === 0) {
            $("#total").val("0.00");
        } else {
            if (tempQuantities.length === 0) {
                listProducts.forEach(function(product) {
                    totalAmount += parseFloat(product["price"]);
                });
            } else {
                for(i = 0; i < tempQuantities.length; i++) {
                    totalAmount += tempQuantities[i] * parseFloat(listProducts[i]["price"]);
                }
            }
            
            totalAmount = Math.round(totalAmount * 10) / 10;

            if(!isNaN(totalAmount)) {
                $("#total").val(totalAmount.toFixed(2));
            } else {
                $("#total").val("");
            }
        }
    }

    function showMessageModal(message) {
        var h2 = $("#message-info")
        h2.html(message);

        var divModal = $("#container-modal__message")
        divModal.addClass("show");

        var modal = $("#modal-message")
        modal.addClass("show-modal");
    }

    function renderTableProducts(res) {
        $("#tblProducts tbody").empty().html(res);
    }

    function emptyTable() {
        $("#tblProducts tbody").empty();
    }

    /* EMITIR BOLETA */

    $(document).on("click", "#btnCancelList", function(e) {
        e.preventDefault();
    
        if(listProducts.length === 0) {
            showMessageModal("La lista ya se encuentra vacía");
        } else {
            showConfirmationModal("Esto anulará la lista por completo, ¿desea continuar?");
        
            $("#btnYes").click(function() {
                emptyTables();
                listProducts = [];
                tempQuantities = [];
                totalAmount = 0;
                $("#product").val("");
                updateTotalAmount();
                hiddenConfirmationModal();
            });
    
            $("#btnNo").click(function() {
                hiddenConfirmationModal();
            });
        }
    });

    $(document).on("click", "#btnConfirmSale", function(e) {
        verifySaleData();
        e.preventDefault();
    });

    $(document).on("keyup", ".quantity", function() {
        // let auxVal = $(this).val();
        var currentValue = parseInt($(this).val(), 10);

        // var min = parseInt($(this).attr("min"), 10);
        // var max = parseInt($(this).attr("max"), 10);
    
        // if(currentValue < min) {
        //     $(this).val(min);
        // }
    
        // if(currentValue > max) {
        //     $(this).val(max);
        // }

        // if(isNaN(currentValue) && auxVal !== "") {
        //     $(this).val(min);
        // }
        if (currentValue >= 0) {
            updateArrayQuantities();
            updateTotalAmount();
        }
    });

    function updateArrayQuantities() {
        tempQuantities = [];

        $(document).find(".quantity").each(function() {
            let value = $(this).val();

            if(value !== "") {
                value = parseInt(value, 10);
            } else {
                value = 0;
            }

            tempQuantities.push(value);
        });
    }

    function verifySaleData() {
        let products = listProducts;
    
        if(products.length === 0) {
            showMessageModal("No hay ningun producto en la lista");
    
            return;
        }
    
        let paymentMethod = $('input[name="payment-method"]:checked').val();
        let quantities = [];
        const action = "issueReceipt";
    
        if(!paymentMethod) {
            paymentMethod = "empty";
        } 
    
        $(".quantity").each(function() {
            var value = $(this).val();
            quantities.push(value);
        });

        $.ajax({
            async: false,
            url: "../salesModule/GetEmitirBoleta.php",
            type: "POST",
            data: {action, products, paymentMethod, quantities, totalAmount},
            success: function(response) {
                res = JSON.parse(response);
                
                if(res[0] === "successful") {
                    //showMessageModal("Boleta emitida con éxito");
                    /*
                    listProducts = [];
                    $("#product").val("");
                    emptyTables();
                    */
                    let idReceipt = getCookie("idReceipt");
                    let url = "../salesModule/GetBoleta.php?idReceipt=" + idReceipt;
                    location.reload();
                    window.open(url, "_blank");
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
    }

    function getCookie(cookieName) {
        var nameEQ = cookieName + "=";
        var cookies = document.cookie.split(';');
        
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) == ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) == 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    }

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

    function emptyTables() {
        $("#tblProducts tbody").empty();
        $("#tblListProducts tbody").empty();
    }
});
