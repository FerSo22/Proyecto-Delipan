const select = document.getElementById("securityQuestion");
const label = document.getElementById("lblSecurityQuestion");

select.addEventListener("focus", () => {
    label.classList.add("transformed");
});

select.addEventListener("click", () => {
    label.classList.add("transformed");
});

select.addEventListener("blur", () => {
    if (select.value === "") {
        label.classList.remove("transformed");
    }
});

