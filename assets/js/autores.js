document.addEventListener("DOMContentLoaded", async () => {
  cargarBusqueda();
  await cargarEstados();
  cargarAutores();
});

//Coloca en el formulario los filtros mediante GET
function cargarBusqueda() {
  const parametros = new URLSearchParams(window.location.search);

  const busqueda = parametros.get("busqueda") || "";

  const estado = parametros.get("estado") || "todos";

  document.getElementById("busqueda").value = busqueda;

  //Muestra el botón cuando existe algún filtro
  if (busqueda !== "" || estado !== "todos") {
    document.getElementById("contenedor-limpiar").classList.remove("d-none");
  }
}

//Obtiene los estados registrados
async function cargarEstados() {
  const selector = document.getElementById("estado");

  try {
    const respuesta = await fetch("actions/autores/obtener_estados.php", {
      cache: "no-store",
    });

    const datos = await respuesta.json();

    if (!respuesta.ok || !datos.correcto) {
      throw new Error(datos.mensaje || "No fue posible obtener los estados.");
    }

    //Agrega los estados al selector
    datos.estados.forEach((estado) => {
      const opcion = document.createElement("option");

      opcion.value = estado;
      opcion.textContent = estado;

      selector.appendChild(opcion);
    });

    //Selecciona el estado mediante GET
    const parametros = new URLSearchParams(window.location.search);

    const estadoSeleccionado = parametros.get("estado") || "todos";

    const estadosPermitidos = ["todos", ...datos.estados];

    selector.value = estadosPermitidos.includes(estadoSeleccionado)
      ? estadoSeleccionado
      : "todos";
  } catch (error) {
    console.error("Error al cargar los estados:", error);

    selector.innerHTML = `
            <option value="todos">
                Todos los estados
            </option>
        `;
  }
}

//Obtiene los autores desde la acción obtener_autores
async function cargarAutores() {
  const contenedor = document.getElementById("contenedor-autores");

  const resumen = document.getElementById("resumen-resultados");

  try {
    const parametros = new URLSearchParams(window.location.search);

    const respuesta = await fetch(
      `actions/autores/obtener_autores.php?${parametros.toString()}`,
      {
        cache: "no-store",
      },
    );

    const datos = await respuesta.json();

    if (!respuesta.ok || !datos.correcto) {
      throw new Error(datos.mensaje || "No fue posible obtener los autores.");
    }

    actualizarResumen(datos.totalResultados);

    mostrarAutores(datos.autores);
  } catch (error) {
    console.error("Error al cargar los autores:", error);

    resumen.textContent =
      "No fue posible obtener la información de los autores.";

    contenedor.innerHTML = `
            <div class="col-12">
                <div class="mensaje-sin-resultados">
                    <i class="bi bi-exclamation-circle"></i>

                    <h2 class="h3">
                        No fue posible cargar los autores
                    </h2>

                    <p class="text-secondary mb-0">
                        ${escaparHTML(error.message)}
                    </p>
                </div>
            </div>
        `;
  }
}

//Actualiza la cantidad de autores encontrados
function actualizarResumen(cantidad) {
  const resumen = document.getElementById("resumen-resultados");

  if (Number(cantidad) === 1) {
    resumen.innerHTML = `
            Se encontró <strong>1</strong> autor.
        `;

    return;
  }

  resumen.innerHTML = `
        Se encontraron <strong>${Number(cantidad) || 0}</strong> autores.
    `;
}

//Muestra las tarjetas de información de los autores
function mostrarAutores(autores) {
  const contenedor = document.getElementById("contenedor-autores");

  if (autores.length === 0) {
    contenedor.innerHTML = `
            <div class="col-12">
                <div class="mensaje-sin-resultados">
                    <i class="bi bi-person-x"></i>

                    <h2 class="h3">
                        No encontramos autores
                    </h2>

                    <p class="text-secondary mb-4">
                        Intenta utilizar otro término
                        o cambia el estado seleccionado.
                    </p>

                    <a href="autores.php" class="btn btn-terracota">
                        Mostrar todos los autores
                    </a>
                </div>
            </div>
        `;

    return;
  }

  const clasesAvatar = [
    "avatar-bosque",
    "avatar-terracota",
    "avatar-dorado",
    "avatar-vino",
  ];

  contenedor.innerHTML = "";

  autores.forEach((autor, indice) => {
    const claseAvatar = clasesAvatar[indice % clasesAvatar.length];

    const nombre = String(autor.nombre || "").trim();

    const apellido = String(autor.apellido || "").trim();

    const nombreCompleto = String(
      autor.nombre_completo || `${nombre} ${apellido}`,
    ).trim();

    const iniciales = obtenerIniciales(nombre, apellido);

    const ubicacion = [autor.ciudad, autor.estado, autor.pais]
      .filter((dato) => String(dato || "").trim() !== "")
      .join(", ");

    const columna = document.createElement("div");

    columna.className = "col-12";

    columna.innerHTML = `
            <article class="tarjeta-autor-horizontal">
                <div class="identidad-autor-horizontal">
                    <div
                        class="avatar-autor-horizontal ${claseAvatar}">
                        ${escaparHTML(iniciales)}
                    </div>

                    <span class="codigo-autor-horizontal">
                        ${escaparHTML(autor.id_autor)}
                    </span>

                    <h2>
                        ${escaparHTML(nombreCompleto)}
                    </h2>

                    <p class="ubicacion-autor-horizontal">
                        <i class="bi bi-geo-alt"></i>

                        ${escaparHTML(ubicacion || "Ubicación no especificada")}
                    </p>
                </div>

                <div class="informacion-autor-horizontal">
                    <span class="categoria-autor-horizontal">
                        Información del autor
                    </span>

                    <h3>
                        Datos de contacto y ubicación
                    </h3>

                    <div class="datos-autor-horizontal">
                        <div class="dato-autor-horizontal">
                            <i class="bi bi-telephone"></i>

                            <div>
                                <span>Teléfono</span>

                                <strong>
                                    ${escaparHTML(autor.telefono || "No especificado")}
                                </strong>
                            </div>
                        </div>

                        <div class="dato-autor-horizontal">
                            <i class="bi bi-house-door"></i>

                            <div>
                                <span>Dirección</span>

                                <strong>
                                    ${escaparHTML(autor.direccion || "No especificada")}
                                </strong>
                            </div>
                        </div>

                        <div class="dato-autor-horizontal">
                            <i class="bi bi-buildings"></i>

                            <div>
                                <span>Ciudad</span>

                                <strong>
                                    ${escaparHTML(autor.ciudad || "No especificada")}
                                </strong>
                            </div>
                        </div>

                        <div class="dato-autor-horizontal">
                            <i class="bi bi-map"></i>

                            <div>
                                <span>Estado</span>

                                <strong>
                                    ${escaparHTML(autor.estado || "No especificado")}
                                </strong>
                            </div>
                        </div>

                        <div class="dato-autor-horizontal">
                            <i class="bi bi-globe-americas"></i>

                            <div>
                                <span>País</span>

                                <strong>
                                    ${escaparHTML(autor.pais || "No especificado")}
                                </strong>
                            </div>
                        </div>

                        <div class="dato-autor-horizontal">
                            <i class="bi bi-mailbox"></i>

                            <div>
                                <span>Código postal</span>

                                <strong>
                                    ${escaparHTML(autor.cod_postal || "No especificado")}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="acciones-autor-horizontal">
                        <a href="libros.php?autor=${encodeURIComponent(autor.id_autor)}" class="btn btn-terracota">
                            Ver libros del autor

                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </article>
        `;

    contenedor.appendChild(columna);
  });
}

//Obtiene las iniciales del autor
function obtenerIniciales(nombre, apellido) {
  const inicialNombre = String(nombre || "")
    .trim()
    .charAt(0);

  const inicialApellido = String(apellido || "")
    .trim()
    .charAt(0);

  return (inicialNombre + inicialApellido).toUpperCase();
}

//Evita que los datos alteren el HTML
function escaparHTML(texto) {
  const elemento = document.createElement("div");

  elemento.textContent = String(texto || "");

  return elemento.innerHTML;
}
