$(document).ready(function() {
    $("#btnAccept").click(function(e) {
        if(!verifyDNI()) {
            e.preventDefault();
        }
    });
    
    $("#btnContinue").click(function(e) {
        if(!verifySecurityQuestion()) {
            e.preventDefault();
        }
    });
    
    $("#btnConfirm").click(function(e) {
        if(!verifyPasswordChange()) {
            e.preventDefault();
        }
    });
    
    $("#btnClose").click(function() {
        $("#container-modal__message").removeClass("show");
        $("#modal-message").removeClass("show-modal");
    });
    
    function verifyDNI() {
        let dni = $("#dni").val();
        let res;
        let band = false;
        const action = "verifyDNI";
    
        $.ajax({
            async: false,
            url: "../securityModule/GetPassRecoveryData.php",
            type: "POST",
            data: {action, dni},
            success: function(response) {
                if (response === "") {
                    band = true;
                } else {
                    res = JSON.parse(response);
                    showMessageModal(res[0]);
                }
            }
        });
    
        return band;
    }
    
    function verifySecurityQuestion() {
        let value = $("#securityQuestion").val();
        let hiddenDNI = $("#hiddenDNI").val();
        let answer = $("#securityAnswer").val();
        let res;
        let band = false;
        const action = "verifySecurityQuestion";
    
        $.ajax({
            async: false,
            url: "../securityModule/GetPassRecoveryData.php",
            type: "POST",
            data: {action, value, hiddenDNI, answer},
            success: function(response) {
                if (response === "") {
                    band = true;
                } else {
                    res = JSON.parse(response);
                    showMessageModal(res[0]);
                }
            }
        });
    
        return band;
    }
    
    function verifyPasswordChange() {
        let newPass = $("#newPass").val();
        let reNewPass = $("#reNewPass").val();
        let hiddenDNI = $("#hiddenDNI").val();
        let res;
        let band = false;
        const action = "verifyPasswordChange";
    
        $.ajax({
            async: false,
            url: "../securityModule/GetPassRecoveryData.php",
            type: "POST",
            data: {action, newPass, reNewPass, hiddenDNI},
            success: function(response) {
                if (response === "") {
                    band = true;
                } else {
                    res = JSON.parse(response);
                    showMessageModal(res[0]);
                }
            }
        });
    
        return band;
    }
    
    function showMessageModal(message) {
        var h2 = $("#message-info")
        h2.html(message);
    
        var divModal = $("#container-modal__message")
        divModal.addClass("show");
    
        var modal = $("#modal-message")
        modal.addClass("show-modal");
    }
});