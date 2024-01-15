$(document).ready(function() {
    $("#btnLogin").click(function(e) {
        if(!verifyUser()) {
            e.preventDefault();
        }
    });
    
    $("#btnClose").click(function() {
        $("#container-modal__message").removeClass("show");
        $("#modal-message").removeClass("show-modal");
    });
    
    function verifyUser() {
        let user = $("#user").val();
        let pass = $("#pass").val();
        let band = false;
        const action = "verifyUser";
    
        $.ajax({
            async: false,
            url: "./securityModule/GetLogin.php",
            type: "POST",
            data: {action, user, pass},
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