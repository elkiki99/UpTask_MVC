const mobileMenuBtn = document.querySelector("#mobile-menu");
const sidebar = document.querySelector(".sidebar");
const cerrarMenuBtn = document.querySelector("#cerrar-menu");

if(mobileMenuBtn) {
    mobileMenuBtn.addEventListener("click", function() {
        sidebar.classList.toggle("mostrar");
    })
}

if(cerrarMenuBtn) {
    cerrarMenuBtn.addEventListener("click", function() {
        sidebar.classList.add("ocultar");

        setTimeout(() => {
            sidebar.classList.remove("mostrar");
            sidebar.classList.remove("ocultar");
        }, 200);
    })
}

// Elimina la clase de mostrar en un tamaño de tablet y mayores

const anchoPantalla = document.body.clientWidth;

window.addEventListener("resize", function() {
    const anchoPantalla = document.body.clientWidth;
    if(anchoPantalla >= 768) {
        sidebar.classList.remove("mostrar");
    }
})