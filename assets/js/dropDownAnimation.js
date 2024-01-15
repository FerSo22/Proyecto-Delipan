let listElements = document.querySelectorAll(".dropdown");
let openMenu = null;

listElements.forEach(listElement => {
    listElement.addEventListener("click", () => {
        if (openMenu !== null && openMenu !== listElement) {
            openMenu.classList.remove("rotate-arrow");
            openMenu.nextElementSibling.style.height = "0px";
        }

        listElement.classList.toggle("rotate-arrow");

        let height = 0;
        let menu = listElement.nextElementSibling;

        if(menu.clientHeight == "0") {
            height = menu.scrollHeight;
        }

        menu.style.height = height + "px";

        openMenu = listElement;
    })
})