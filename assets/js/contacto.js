document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.getElementById("formulario-contacto");

    formulario.addEventListener("submit", guardarMensaje);
});

//Envía los datos del formulario hacia la acción guardar_mensaje
async function guardarMensaje(evento) {
    evento.preventDefault();

    const formulario = evento.currentTarget;
    const botonEnviar = document.getElementById("boton-enviar");
    const textoBoton = document.getElementById("texto-boton");
    const cargandoBoton = document.getElementById("cargando-boton");

    //Muestra las validaciones propias del formulario
    if (!formulario.checkValidity()) {
        formulario.reportValidity();
        return;
    }

    //Bloquea el botón mientras se procesa el formulario
    botonEnviar.disabled = true;
    textoBoton.textContent = "Enviando...";
    cargandoBoton.classList.remove("d-none");

    ocultarMensaje();

    try {
        //Guarda todos los datos escritos en el formulario
        const datosFormulario = new FormData(formulario);

        //Envía los datos mediante POST
        const respuesta = await fetch("actions/contacto/guardar_mensaje.php", {
            method: "POST",
            body: datosFormulario,
        });

        //Obtiene primero la respuesta como texto
        const contenido = await respuesta.text();

        let datos;

        try {
            datos = JSON.parse(contenido);
        } catch {
            throw new Error("El servidor no devolvió una respuesta válida.");
        }

        //Comprueba si la acción encontró algún error
        if (!respuesta.ok || !datos.correcto) {
            const mensajeError = Array.isArray(datos.errores) ? datos.errores.join(" ") : datos.mensaje;

            throw new Error(mensajeError || "No fue posible enviar el mensaje.");
        }

        //Muestra la confirmación y limpia el formulario
        mostrarMensaje("success", datos.mensaje);
        formulario.reset();
    } catch (error) {
        console.error("Error al guardar el mensaje:", error);

        mostrarMensaje("danger", error.message || "No fue posible guardar el mensaje.");
    } finally {
        botonEnviar.disabled = false;
        textoBoton.textContent = "Enviar mensaje";
        cargandoBoton.classList.add("d-none");
    }
}

//Muestra el resultado del envío dentro del formulario
function mostrarMensaje(tipo, mensaje) {
    const contenedor = document.getElementById("mensaje-formulario");

    contenedor.className = `alert alert-${tipo} mt-4`;
    contenedor.textContent = mensaje;
}

//Oculta cualquier mensaje que se haya mostrado antes
function ocultarMensaje() {
    const contenedor = document.getElementById("mensaje-formulario");

    contenedor.className = "d-none";
    contenedor.textContent = "";
}
