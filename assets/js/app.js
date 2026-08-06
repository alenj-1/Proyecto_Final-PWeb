document.addEventListener("DOMContentLoaded", () => {
    const enlacesMenu = document.querySelectorAll("#menuPrincipal .nav-link");

    enlacesMenu.forEach((enlace) => {
        enlace.addEventListener("click", () => {
            const menu = document.getElementById("menuPrincipal");

            if (menu && menu.classList.contains("show")) {
                const menuBootstrap = bootstrap.Collapse.getOrCreateInstance(menu);

                menuBootstrap.hide();
            }
        });
    });
});
