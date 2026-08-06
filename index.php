<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Portal web para consultar libros y autores disponibles en Librería Capítulos.">
        <title>Inicio | Librería Capítulos</title>
        
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
                            <a class="nav-link active" href="index.php" aria-current="page">
                                Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="libros.php">
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
            <!-- Presentación principal -->
            <section class="hero">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <h1 class="mb-4">
                                Historias que amplían tus horizontes
                            </h1>
                            
                            <p class="texto-principal mb-4">
                                Explora nuestro catálogo y conoce a los autores detrás de cada historia.
                            </p>
                            
                            <div class="d-flex flex-wrap gap-3">
                                <a href="libros.php" class="btn btn-terracota">
                                    Explorar libros
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                                
                                <a href="autores.php" class="btn btn-bosque">
                                    Nuestros autores
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-lg-5 d-none d-md-block">
                            <div id="libro-mas-vendido">
                                <div class="text-center py-5">
                                    <div class="spinner-border" role="status" aria-label="Cargando libro"></div>
                                    <p class="mt-3 mb-0">
                                        Cargando libro más vendido...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Libros destacados -->
            <section class="seccion-contenido">
                <div class="container">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-5">
                        <div>
                            <h2 class="titulo-seccion mb-2">
                                Libros destacados
                            </h2>

                            <p class="subtitulo-seccion mb-0">
                                Una selección de libros disponibles
                                actualmente en nuestro catálogo.
                            </p>
                        </div>

                        <a href="libros.php" class="btn btn-bosque">
                            Ver catálogo completo
                        </a>
                    </div>
                    
                    <div class="row g-4" id="libros-destacados">
                        <div class="col-12 text-center py-5">
                            <div class="spinner-border" role="status" aria-label="Cargando libros"></div>
                            <p class="text-secondary mt-3 mb-0">
                                Seleccionando libros...
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Sección de contacto -->
            <section class="seccion-contacto">
                <div class="container">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <span class="text-uppercase fw-bold small opacity-75">
                                Estamos para ayudarte
                            </span>

                            <h2 class="mt-2 mb-3">
                                ¿Buscas más información?
                            </h2>

                            <p class="mb-0 fs-5">
                                Envíanos un mensaje y te responderemos mediante
                                nuestro formulario de contacto.
                            </p>
                        </div>

                        <div class="col-lg-4 text-lg-end">
                            <a href="contacto.php" class="btn btn-crema">
                                Contáctanos
                                <i class="bi bi-send ms-2"></i>
                            </a>
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
        <script src="assets/js/inicio.js"></script>
    </body>
</html>