document.addEventListener("DOMContentLoaded", () => {
  cargarContenidoInicio();
});

//Obtiene el libro más vendido y los libros aleatorios
async function cargarContenidoInicio() {
  const contenedorPrincipal = document.getElementById("libro-mas-vendido");

  const contenedorDestacados = document.getElementById("libros-destacados");

  try {
    //Obtiene el libro más vendido
    const respuestaPrincipal = await fetch(
      "actions/inicio/obtener_libro-mas-vendido.php",
      {
        cache: "no-store",
      },
    );

    const datosPrincipal = await respuestaPrincipal.json();

    if (!respuestaPrincipal.ok || !datosPrincipal.correcto) {
      throw new Error(
        datosPrincipal.mensaje || "No fue posible obtener el libro principal.",
      );
    }

    mostrarLibroMasVendido(datosPrincipal.libro);

    //Evita que el libro principal (más vendido) aparezca entre los destacados
    const idExcluir = encodeURIComponent(datosPrincipal.libro.id_titulo);

    //Obtiene tres libros diferentes de forma aleatoria
    const respuestaDestacados = await fetch(
      `actions/inicio/obtener_libros-destacados.php?excluir=${idExcluir}`,
      {
        cache: "no-store",
      },
    );

    const datosDestacados = await respuestaDestacados.json();

    if (!respuestaDestacados.ok || !datosDestacados.correcto) {
      throw new Error(
        datosDestacados.mensaje ||
          "No fue posible obtener los libros destacados.",
      );
    }

    mostrarLibrosDestacados(datosDestacados.libros);
  } catch (error) {
    console.error("Error al cargar el inicio:", error);

    contenedorPrincipal.innerHTML = `
            <div class="mensaje-carga-inicio">
                <i class="bi bi-exclamation-circle"></i>

                <p class="mb-0">
                    No fue posible cargar el libro principal.
                </p>
            </div>
        `;

    contenedorDestacados.innerHTML = `
            <div class="col-12">
                <div class="mensaje-sin-resultados">
                    <i class="bi bi-exclamation-circle"></i>

                    <h2 class="h4">
                        No fue posible cargar los libros
                    </h2>
                </div>
            </div>
        `;
  }
}

//Muestra el libro con mayor cantidad de ventas
function mostrarLibroMasVendido(libro) {
  const contenedor = document.getElementById("libro-mas-vendido");

  if (!libro) {
    contenedor.innerHTML = `
            <div class="mensaje-carga-inicio">
                No hay un libro disponible.
            </div>
        `;

    return;
  }

  const tipo = formatearTipo(libro.tipo);

  const autores = String(libro.autores || "Autor no disponible").trim();

  const ventas = Number(libro.total_ventas || 0).toLocaleString("es-DO");

  contenedor.innerHTML = `
        <article class="libro-principal-inicio">
            <div class="portada-libro-principal">
                <span class="etiqueta-mas-vendido">
                    Más vendido
                </span>

                <span class="tipo-libro-principal">
                    ${escaparHTML(tipo)}
                </span>

                <h2>
                    ${escaparHTML(libro.titulo)}
                </h2>

                <p>
                    ${escaparHTML(autores)}
                </p>
            </div>

            <div class="informacion-libro-principal">
                <div>
                    <span>Ventas</span>

                    <strong>
                        ${ventas}
                    </strong>
                </div>

                <a href="libros.php?libro=${encodeURIComponent(libro.id_titulo)}" class="btn btn-crema">
                    Ver detalles
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </article>
    `;
}

//Muestra los tres libros seleccionados aleatoriamente
function mostrarLibrosDestacados(libros) {
  const contenedor = document.getElementById("libros-destacados");

  if (!Array.isArray(libros) || libros.length === 0) {
    contenedor.innerHTML = `
            <div class="col-12">
                <div class="mensaje-sin-resultados">
                    No hay libros destacados disponibles.
                </div>
            </div>
        `;

    return;
  }

  const clasesPortadas = [
    "destacado-bosque",
    "destacado-terracota",
    "destacado-dorado",
  ];

  contenedor.innerHTML = "";

  libros.forEach((libro, indice) => {
    const clasePortada = clasesPortadas[indice % clasesPortadas.length];

    const tipo = formatearTipo(libro.tipo);

    const columna = document.createElement("div");

    columna.className = "col-md-6 col-xl-4";

    columna.innerHTML = `
            <article class="tarjeta-destacada-inicio">
                <div class="portada-destacada-inicio ${clasePortada}">
                    <span>
                        ${escaparHTML(tipo)}
                    </span>

                    <h3>
                        ${escaparHTML(libro.titulo)}
                    </h3>
                </div>

                <div class="pie-destacado-inicio">  
                    <a href="libros.php?libro=${encodeURIComponent(libro.id_titulo)}" class="enlace-detalles">
                        Ver detalles
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </article>
        `;

    contenedor.appendChild(columna);
  });
}

//Le da formato a las categorías para que estén en español
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

//Evita que los datos alteren el HTML
function escaparHTML(texto) {
  const elemento = document.createElement("div");

  elemento.textContent = String(texto || "");

  return elemento.innerHTML;
}
