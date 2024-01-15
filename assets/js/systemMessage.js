const containerModal = document.getElementById("container-modal");
const modal = document.getElementById("modal");
const btnOpen = document.getElementById("btn-open");
const btnOpen2 = document.getElementById("btn-open2");
const btnClose = document.getElementById("btn-close");

btnOpen.addEventListener("click", () => {
    containerModal.classList.add("show");
    modal.classList.add("show-modal");
});

btnOpen2.addEventListener("click", () => {
    containerModal.classList.add("show");
    modal.classList.add("show-modal");
});

btnClose.addEventListener("click", () => {
    containerModal.classList.remove("show");
    modal.classList.remove("show-modal");
});