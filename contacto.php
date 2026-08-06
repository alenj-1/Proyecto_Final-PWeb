<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Información de contacto y formulario de Librería Capítulos.">
        <title>Contacto | Librería Capítulos</title>
        
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
                            <a class="nav-link active" href="contacto.php" aria-current="page">
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
                        Contáctanos
                    </h1>

                    <p class="fs-5 mb-0">
                        Consulta nuestra información de contacto o envíanos un mensaje.
                    </p>
                </div>
            </section>
            
            <!-- Información y formulario -->
            <section class="seccion-contacto-pagina">
                <div class="container">
                    <div class="row g-5">
                        <!-- Información de contacto -->
                        <div class="col-lg-5">
                            <div class="panel-informacion-contacto">

                                <h2 class="titulo-seccion mb-4">
                                    Información de contacto
                                </h2>

                                <div class="item-informacion-contacto">
                                    <div class="icono-contacto">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>

                                    <div>
                                        <h3>Ubicación</h3>

                                        <p>
                                            Santo Domingo, República Dominicana
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="item-informacion-contacto">
                                    <div class="icono-contacto">
                                        <i class="bi bi-envelope"></i>
                                    </div>

                                    <div>
                                        <h3>Correo electrónico</h3>

                                        <p>
                                            contacto@libreriacapitulos.com
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="item-informacion-contacto">
                                    <div class="icono-contacto">
                                        <i class="bi bi-telephone"></i>
                                    </div>

                                    <div>
                                        <h3>Teléfono</h3>

                                        <p>
                                            +1 (809) 905-3300
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="item-informacion-contacto">
                                    <div class="icono-contacto">
                                        <i class="bi bi-clock"></i>
                                    </div>

                                    <div>
                                        <h3>Horario</h3>

                                        <p>
                                            Lunes a viernes:
                                            9:00 a. m. - 6:00 p. m.
                                        </p>

                                        <p>
                                            Sábados:
                                            10:00 a.m - 4:00 p.m.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Formulario de contacto -->
                        <div class="col-lg-7">
                            <div class="panel-formulario-contacto">
                                <h2 class="h1 mb-3">
                                    ¿Cómo podemos ayudarte?
                                </h2>

                                <p class="text-secondary mb-4">
                                    Completa el formulario y nos pondremos en contacto contigo para atender tu solicitud.
                                </p>
                                
                                <form id="formulario-contacto" action="actions/contacto/guardar_mensaje.php" method="POST">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="nombre" class="form-label">
                                                Nombre completo
                                            </label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" autocomplete="name" required>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="correo" class="form-label">
                                                Correo electrónico
                                            </label>
                                            
                                            <input type="email" class="form-control" id="correo" name="correo" maxlength="150" autocomplete="email" required>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="asunto" class="form-label">
                                                Asunto
                                            </label>
                                            
                                            <input type="text" class="form-control" id="asunto" name="asunto" maxlength="150" required>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label
                                                for="comentario"
                                                class="form-label">
                                                Mensaje
                                            </label>

                                            <textarea class="form-control" id="comentario" name="comentario" minlength="10" maxlength="2000" required></textarea>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-terracota" id="boton-enviar">
                                                <span class="spinner-border spinner-border-sm me-2 d-none" id="cargando-boton" aria-hidden="true"></span>
                                                <span id="texto-boton">
                                                Enviar mensaje
                                                </span>

                                                <i class="bi bi-send ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="d-none" id="mensaje-formulario" role="alert" aria-live="polite"></div>
                                </form>
                            </div>
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
        <script src="assets/js/contacto.js"></script>
    </body>
</html>