document.addEventListener("DOMContentLoaded", () => {
  cargarFiltros();
  cargarLibros();
});

//Coloca en el formulario los filtros mediante GET
function cargarFiltros() {
  const parametros = new URLSearchParams(window.location.search);

  const busqueda = parametros.get("busqueda") || "";

  const disponibilidad = parametros.get("disponibilidad") || "todos";

  const autor = parametros.get("autor") || "";

  const libro = parametros.get("libro") || "";

  document.getElementById("busqueda").value = busqueda;

  document.getElementById("autor").value = autor;

  const selectorDisponibilidad = document.getElementById("disponibilidad");

  const opcionesPermitidas = ["todos", "1", "0"];

  selectorDisponibilidad.value = opcionesPermitidas.includes(disponibilidad)
    ? disponibilidad
    : "todos";

  //Muestra el botón cuando existe algún filtro
  if (
    busqueda !== "" ||
    disponibilidad !== "todos" ||
    autor !== "" ||
    libro !== ""
  ) {
    document.getElementById("contenedor-limpiar").classList.remove("d-none");
  }
}

//Obtiene los libros desde la acción obtener_libros
async function cargarLibros() {
  const contenedor = document.getElementById("contenedor-libros");

  const resumen = document.getElementById("resumen-resultados");

  try {
    const parametros = new URLSearchParams(window.location.search);

    const respuesta = await fetch(
      `actions/libros/obtener_libros.php?${parametros.toString()}`,
      {
        cache: "no-store",
      },
    );

    const datos = await respuesta.json();

    if (!respuesta.ok || !datos.correcto) {
      throw new Error(datos.mensaje || "No fue posible obtener los libros.");
    }

    actualizarResumen(datos);

    mostrarLibros(datos.libros);
  } catch (error) {
    console.error("Error al cargar los libros:", error);

    resumen.textContent = "No fue posible obtener la información del catálogo.";

    contenedor.innerHTML = `
            <div class="col-12">
                <div class="mensaje-sin-resultados">
                    <i class="bi bi-exclamation-circle"></i>

                    <h2 class="h3">
                        No fue posible cargar los libros
                    </h2>

                    <p class="text-secondary mb-0">
                        ${escaparHTML(error.message)}
                    </p>
                </div>
            </div>
        `;
  }
}

//Actualiza la cantidad de resultados encontrados
function actualizarResumen(datos) {
  const resumen = document.getElementById("resumen-resultados");

  const cantidad = Number(datos.totalResultados || 0);

  const autor = datos.autorFiltro?.nombre_completo || "";

  let textoCantidad = "";

  if (cantidad === 1) {
    textoCantidad = "Se encontró <strong>1</strong> libro.";
  } else {
    textoCantidad = `
            Se encontraron <strong>${cantidad}</strong> libros.
        `;
  }

  if (autor !== "") {
    resumen.innerHTML = `
            ${textoCantidad}
        `;

    return;
  }

  resumen.innerHTML = `
        ${textoCantidad}
    `;
}

//Muestra las tarjetas de información de los libros
function mostrarLibros(libros) {
  const contenedor = document.getElementById("contenedor-libros");

  if (libros.length === 0) {
    contenedor.innerHTML = `
            <div class="col-12">
                <div class="mensaje-sin-resultados">
                    <i class="bi bi-search"></i>

                    <h2 class="h3">
                        No encontramos libros
                    </h2>

                    <p class="text-secondary mb-4">
                        Intenta utilizar otro término
                        o cambia los filtros seleccionados.
                    </p>

                    <a href="libros.php" class="btn btn-terracota">
                        Mostrar todos los libros
                    </a>
                </div>
            </div>
        `;

    return;
  }

  const clasesPortadas = [
    "destacado-bosque",
    "destacado-terracota",
    "destacado-dorado",
    "destacado-vino",
  ];

  contenedor.innerHTML = "";

  libros.forEach((libro, indice) => {
    const clasePortada = clasesPortadas[indice % clasesPortadas.length];

    const tipo = formatearTipo(libro.tipo);

    const autores = String(libro.autores || "Autor no disponible").trim();

    const editorial = String(libro.nombre_pub || "No especificada").trim();

    const descripcion = String(
      libro.notas || "Este libro no tiene una descripción registrada.",
    ).trim();

    const precio = formatearMoneda(libro.precio);

    const avance = formatearMoneda(libro.avance);

    const ventas = formatearNumero(libro.total_ventas);

    const fecha = formatearFecha(libro.fecha_pub);

    const disponible = String(libro.contrato) === "1";

    const estado = disponible
      ? `
                <span class="estado-libro-horizontal disponible">
                    <i class="bi bi-circle-fill"></i>
                    Disponible
                </span>
            `
      : `
                <span class="estado-libro-horizontal no-disponible">
                    <i class="bi bi-circle-fill"></i>
                    No disponible
                </span>
            `;

    const columna = document.createElement("div");

    columna.className = "col-12";

    columna.innerHTML = `
            <article class="tarjeta-libro-horizontal">
                <div class="portada-destacada-inicio portada-libro-horizontal ${clasePortada}">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <span>
                            ${escaparHTML(tipo)}
                        </span>

                        <span class="codigo-portada-catalogo">
                            ${escaparHTML(libro.id_titulo)}
                        </span>
                    </div>

                    <p class="titulo-portada-libro-horizontal">
                        ${escaparHTML(libro.titulo)}
                    </p>
                </div>

                <div class="informacion-libro-horizontal">
                    <div class="encabezado-libro-horizontal">
                        <div>
                            <span class="categoria-libro-horizontal">
                                ${escaparHTML(tipo)}
                            </span>

                            <h2>
                                ${escaparHTML(libro.titulo)}
                            </h2>

                            <p class="autores-libro-horizontal">
                                ${escaparHTML(autores)}
                            </p>
                        </div>

                        ${estado}
                    </div>

                    <p class="descripcion-libro-horizontal">
                        ${escaparHTML(descripcion)}
                    </p>

                    <div class="datos-libro-horizontal">
                        <div class="dato-libro-horizontal">
                            <strong>Precio</strong>

                            <span class="precio-libro-horizontal">
                                ${precio}
                            </span>
                        </div>

                        <div class="dato-libro-horizontal">
                            <strong>Editorial</strong>

                            <span>
                                ${escaparHTML(editorial)}
                            </span>
                        </div>

                        <div class="dato-libro-horizontal">
                            <strong>Publicación</strong>

                            <span>
                                ${fecha}
                            </span>
                        </div>

                        <div class="dato-libro-horizontal">
                            <strong>Ventas</strong>

                            <span>
                                ${ventas}
                            </span>
                        </div>

                        <div class="dato-libro-horizontal">
                            <strong>Avance</strong>

                            <span>
                                ${avance}
                            </span>
                        </div>

                        <div class="dato-libro-horizontal">
                            <strong>Código</strong>

                            <span>
                                ${escaparHTML(libro.id_titulo)}
                            </span>
                        </div>
                    </div>
                </div>
            </article>
        `;

    contenedor.appendChild(columna);
  });
}

//Traduce las categorías de la base de datos
function formatearTipo(tipo) {
  const categorias = {
    business: "Negocios",
    mod_cook: "Cocina moderna",
    popular_comp: "Computación",
    psychology: "Psicología",
    trad_cook: "Cocina tradicional",
    UNDECIDED: "Sin categoría",
  };

  const tipoLimpio = String(tipo || "").trim();

  return categorias[tipoLimpio] || "Sin categoría";
}

//Establece el formato de moneda
function formatearMoneda(valor) {
  if (valor === null || valor === "") {
    return "No especificado";
  }

  return Number(valor).toLocaleString("es-DO", {
    style: "currency",
    currency: "USD",
  });
}

//Organiza las cantidades numéricas
function formatearNumero(valor) {
  if (valor === null || valor === "") {
    return "No especificadas";
  }

  return Number(valor).toLocaleString("es-DO");
}

//Organiza la fecha como día/mes/año
function formatearFecha(fecha) {
  if (!fecha) {
    return "No especificada";
  }

  const partes = String(fecha).substring(0, 10).split("-");

  return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

//Evita que los datos alteren el HTML
function escaparHTML(texto) {
  const elemento = document.createElement("div");

  elemento.textContent = String(texto || "");

  return elemento.innerHTML;
}
