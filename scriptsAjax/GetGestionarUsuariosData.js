$(document).ready(function() {
    renderTableUsers();

    let arrayPrivileges = [];
    let arrayNewPrivileges = [];
    let arraySecurityQuestions = [];
    let arraySelectsOptions = [];
    let questionsAnswers = [];

    $(document).on("click", "#btnToRegisterForm", function() {
        arraySecurityQuestions = getSecurityQuestions();
        loadFormRegisterUser();

        arrayPrivileges = [];
    });

    $(document).on("click", "#btnRegister", function() {
        arrayPrivileges = getSelectedPrivileges();

        verifyNewUserData(arrayPrivileges);
    });

    $(document).on("click", "#btnSave", function() {
        arrayNewPrivileges = getSelectedPrivileges();

        verifyModifiedUserData(arrayNewPrivileges);
    });

    $(document).on("click", "#btnBack", function() {
        location.reload();
        arrayPrivileges = [];
        arrayNewPrivileges = [];
    });

    $(document).on("change", "#countQuestions", function() {
        let numberQuestions = $(this).val();
        $("#secondColumn").empty();
        arraySelectsOptions = [];
        questionsAnswers = [];

        if(numberQuestions > 0) {
            for(let i = 0; i < numberQuestions; i++) {
                questionsAnswers[i] = {
                    "question": "",
                    "answer": ""
                };

                arraySelectsOptions[i] = arraySecurityQuestions.slice();
                layoutSelectSecurityQuestions(arraySelectsOptions[i], i + 1);
            }
        }
    });

    $(document).on("change", "#securityQuestions_1", function() {
        let selectedQuestion = $(this).val();

        questionsAnswers[0]["question"] = selectedQuestion;

        // console.log(questionsAnswers);
    });

    $(document).on("change", "#securityQuestions_2", function() {
        let selectedQuestion = $(this).val();

        questionsAnswers[1]["question"] = selectedQuestion;

        // console.log(questionsAnswers);
    });

    $(document).on("change", "#securityQuestions_3", function() {
        let selectedQuestion = $(this).val();

        questionsAnswers[2]["question"] = selectedQuestion;

        // console.log(questionsAnswers);
    });

    $(document).on("click", ".btn-modifiy", function() {
        arrayPrivileges = [];
        arrayNewPrivileges = [];

        let row = $(this)[0].closest("tr");
        
        let user = $(row).find("input").val();

        loadFormEditUser(user);
    });

    $(document).on("click", ".switch-state", function() {
        let row = $(this)[0].closest("tr");
        
        let checkbox = $(this);
        let isChecked = $(this).prop("checked");
        let user = $(row).find("input").val();
        
        let value = 0;

        if(isChecked) {
            value = 1;
        }

        switchUserState(value, user, checkbox);
    });

    // $(document).on("click", ".cb-privilege", function() {
    //     let checkbox = $(this)[0];
    //     let privilege = $(checkbox).val();

    //     verifyArrayPrivileges(checkbox, privilege);

    //     //console.log(arrayPrivileges);
    // }); 

    $(document).on("click", "#btnClose", function() {
        $("#container-modal__message").removeClass("show");
        $("#modal-message").removeClass("show-modal");
    });

    function verifyNewUserData(privileges) {
        let name = $("#name").val();
        let lastName = $("#lastName").val();
        let dni = $("#dni").val();
        let pass = $("#pass").val();
        let rePass = $("#rePass").val();

        if(questionsAnswers !== null) {
            for(let i = 0; i < questionsAnswers.length; i++) {
                let answer = $("#securityAnswer_" + (i + 1)).val();

                questionsAnswers[i]["answer"] = answer;
            }
        }

        let personalData = {name, lastName, dni}; 
        let userData = {pass, rePass, questionsAnswers, privileges};
        const action = "verifyNewUserData";

        $.ajax({
            async: false,
            url: "../userModule/GetGestionarUsuariosData.php",
            type: "POST",
            data: {action, personalData, userData},
            success: function(response) {
                res = JSON.parse(response);
                if(res[0] === "") {
                    showMessageModal("Usuario creado con éxito");
                    loadFormRegisterUser();
                    
                    arrayPrivileges = [];
                    arraySelectsOptions = [];
                    questionsAnswers = [];
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
        
    }

    function verifyModifiedUserData(privileges) {
        let newPass = $("#newPass").val();
        let reNewPass = $("#reNewPass").val();

        let user = $("#user").val();
        let newData = {newPass, reNewPass, privileges};
        const action = "verifyModifiedUserData";

        $.ajax({
            async: false,
            url: "../userModule/GetGestionarUsuariosData.php",
            type: "POST",
            data: {action, user, newData},
            success: function(response) {
                res = JSON.parse(response);
                
                if(res[0] === "") {
                    //showMessageModal("Usuario modificado con éxito");
                    location.reload();
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
    }

    function loadFormRegisterUser() {
        const action = "loadFormRegisterUser";

        $.ajax({
            async: false,
            url: "../userModule/GetGestionarUsuariosData.php",
            type: "POST",
            data: {action},
            success: function(response) {
                $("#mainContainer").html(response);
            }
        });
    }

    function loadFormEditUser(login) {
        const action = "loadFormEditUser";

        $.ajax({
            async: false,
            url: "../userModule/GetGestionarUsuariosData.php",
            type: "POST",
            data: {action, login},  
            success: function(response) {
                $("#mainContainer").html(response);
            }
        });
    }

    function getSecurityQuestions() {
        let questions = [];
        const action = "getSecurityQuestions";

        $.ajax({
            async: false,
            url: "../userModule/GetGestionarUsuariosData.php",
            type: "POST",
            data: {action},
            success: function(response) {
                res = JSON.parse(response);
                questions = res[0];
            }
        });

        return questions;
    }

    function layoutSelectSecurityQuestions(questions, count) {
        let html = `<div class="container-data">
                        <label>Pregunta de Seguridad</label>
                        <select name="securityQuestions_${count}" id="securityQuestions_${count}" class="select-form security-question">
                            <option value="" class="option-form empty-option" selected></option>`;

        questions.forEach(question => {
            html += `<option value="${question["id"]}" class="option-form">${question["question"]}</option>`;
        });

        html += `</select>
                </div>
                <div class="container-data">
                    <label>Respuesta</label>
                    <input type="text" name="securityAnswer_${count}" id="securityAnswer_${count}" class="input-form security-answer"/>
                </div>`;

        $("#secondColumn").append(html);
    }

    function switchUserState(value, user, checkbox) {
        const action = "switchUserState";

        $.ajax({
            url: "../userModule/GetGestionarUsuariosData.php",
            type: "POST",
            data: {action, value, user},
            success: function(response) {
                res = JSON.parse(response);

                if(res[0] === "") {
                    showMessageModal("No es posible deshabilitar el usuario actual");
                    checkbox.prop("checked", true);
                } else {
                    showMessageModal(res[0]);
                }
            }
        });
    }

    // function verifyArrayPrivileges(checkbox, privilege) {
    //     if (checkbox.checked) {
    //         if (!arrayPrivileges.includes(privilege)) {
    //             arrayPrivileges.push(privilege);
    //         }
    //     } else {
    //         let index = arrayPrivileges.indexOf(privilege);
    //         if (index !== -1) {
    //             arrayPrivileges.splice(index, 1);
    //         }
    //     }
    // }  

    function getSelectedPrivileges() {
        let checkbox = $(".cb-privilege");
        let selectedCheckbox = checkbox.filter(":checked");

        let array = [];

        selectedCheckbox.each(function() {
            array.push($(this).val());
        });
        
        return array;
    }

    function renderTableUsers() {
        const action = "getAllUsers";
    
        $.ajax({
            url: "../userModule/GetGestionarUsuariosData.php",
            type: "POST",
            data: {action},
            success: function(response) {
                res = JSON.parse(response);
                $("#tblUsers tbody").empty().html(res[0]);
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
});

