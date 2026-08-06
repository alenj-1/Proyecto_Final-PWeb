<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Consulta los libros registrados en Librería Capítulos.">
        <title>Libros | Librería Capítulos</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="assets/css/estilos.css">
    </head>
    <body class="d-flex flex-column min-vh-100">
        
        <!-- Menú de navegación -->
        <nav class="navbar navbar-expand-lg navbar-light navbar-personalizada">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Librería Capítulos
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
                    aria-controls="menuPrincipal" aria-expanded="false" aria-label="Mostrar menú">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="libros.php" aria-current="page">
                                Libros
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="autores.php">
                                Autores
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contacto.php">
                                Contacto
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <main class="flex-grow-1">
            <!-- Encabezado de la página -->
            <section class="encabezado-pagina">
                <div class="container">
                    <h1 class="mb-3">
                        Explora nuestros libros
                    </h1>

                    <p class="fs-5 mb-0">
                        Consulta todos nuestros libros y accede 
                        a la información completa de cada uno de ellos.
                    </p>
                </div>
            </section>
            
            <!-- Formulario de búsqueda -->
            <section class="seccion-filtros">
                <div class="container">
                    <div class="panel-filtros">
                        <form action="libros.php" method="GET" class="row g-3 align-items-end">
                            <input type="hidden" id="autor" name="autor">
                            <div class="col-lg-7">
                                <label for="busqueda" class="form-label">
                                    Buscar
                                </label>
                                
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="bi bi-search"></i>
                                    </span>

                                    <input type="search" class="form-control border-start-0" id="busqueda" name="busqueda" placeholder="Título, categoría, autor o editorial">
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-3">
                                <label for="disponibilidad" class="form-label">
                                    Disponibilidad
                                </label>

                                <select class="form-select" id="disponibilidad" name="disponibilidad">
                                    <option value="todos">
                                        Todos los libros
                                    </option>

                                    <option value="1">
                                        Disponibles
                                    </option>

                                    <option value="0">
                                        No disponibles
                                    </option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 col-lg-2 d-grid">
                                <button type="submit" class="btn btn-terracota">
                                    Buscar
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-3 d-none" id="contenedor-limpiar">
                            <a href="libros.php" class="btn btn-sm btn-bosque">
                                <i class="bi bi-x-circle me-1"></i>
                                Limpiar filtros
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Listado de libros -->
            <section class="seccion-contenido">
                <div class="container">
                    <div class="mb-5">
                        <h2 class="titulo-seccion mb-2">
                            Catálogo de libros
                        </h2>

                        <p class="resumen-resultados mb-0" id="resumen-resultados">
                            Cargando información del catálogo...
                        </p>
                    </div>
                    
                    <div class="row g-4" id="contenedor-libros">
                        <div class="col-12 text-center py-5">
                            <div class="spinner-border" role="status" aria-label="Cargando libros"></div>
                            <p class="text-secondary mt-3 mb-0">
                                Cargando libros...
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
        <!-- Pie de página -->
        <footer class="footer-completo">
            <div class="container">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <a href="index.php" class="marca-footer">
                            Librería
                            <span>Capítulos</span>
                        </a>

                        <p class="descripcion-footer">
                            Tu librería en línea para descubrir historias,
                            conocimiento y nuevas perspectivas.
                        </p>
                    </div>

                    <div class="col-6 col-md-3 col-lg-3">
                        <h2>Enlaces</h2>

                        <nav class="enlaces-footer">
                            <a href="index.php">Inicio</a>
                            <a href="libros.php">Libros</a>
                            <a href="autores.php">Autores</a>
                            <a href="contacto.php">Contacto</a>
                        </nav>
                    </div>

                    <div class="col-6 col-md-3 col-lg-3">
                        <h2>Ayuda</h2>

                        <nav class="enlaces-footer">
                            <a href="libros.php">
                                Consultar catálogo
                            </a>

                            <a href="libros.php?disponibilidad=1">
                                Libros disponibles
                            </a>

                            <a href="autores.php">
                                Buscar autores
                            </a>

                            <a href="contacto.php#formulario-contacto">
                                Enviar un mensaje
                            </a>
                        </nav>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <h2>Contacto</h2>

                        <div class="datos-footer">
                            <p>
                                <i class="bi bi-envelope"></i>
                                contacto@libreriacapitulos.com
                            </p>

                            <p>
                                <i class="bi bi-telephone"></i>
                                +1 (809) 905-3300
                            </p>

                            <p>
                                <i class="bi bi-geo-alt"></i>
                                Santo Domingo, RD
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="parte-inferior-footer">
                    <p>
                        © 2026 Librería Capítulos. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </footer>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/js/libros.js"></script>
    </body>
</html>