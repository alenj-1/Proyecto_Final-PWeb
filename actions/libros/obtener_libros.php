<?php

declare(strict_types=1);

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../../config/conexion.php';

    //Obtiene los filtros mediante GET
    $busqueda = trim((string) ($_GET['busqueda'] ?? ''));

    $disponibilidad = (string) ($_GET['disponibilidad'] ?? 'todos');

    $idAutor = trim((string) ($_GET['autor'] ?? ''));

    $idLibro = trim((string) ($_GET['libro'] ?? ''));

    //Comprueba que la disponibilidad sea válida
    $opcionesPermitidas = ['todos', '1', '0'];

    if (
        !in_array($disponibilidad, $opcionesPermitidas,true)
    ) {
        $disponibilidad = 'todos';
    }

    //Obtiene el nombre del autor utilizado como filtro
    $autorFiltro = null;

    if ($idAutor !== '') {
        $consultaAutor = $conexion->prepare(
            "SELECT
                id_autor,
                TRIM(CONCAT(nombre, ' ', apellido)) 
                AS nombre_completo
            FROM autores
            WHERE id_autor = :idAutor
            LIMIT 1"
        );

        $consultaAutor->execute(
            [
                'idAutor' => $idAutor
            ]
        );

        $autorEncontrado = $consultaAutor->fetch();

        if ($autorEncontrado) {
            $autorFiltro = $autorEncontrado;
        }
    }

    //Consulta toda la información de los libros
    $sql = "
        SELECT
            t.id_titulo,
            t.titulo,
            t.tipo,
            t.precio,
            t.avance,
            t.total_ventas,
            t.notas,
            t.fecha_pub,
            t.contrato,
            p.nombre_pub,
            (
                SELECT GROUP_CONCAT(
                    TRIM(CONCAT(a.nombre, ' ', a.apellido))
                    ORDER BY ta.ord_au
                    SEPARATOR ', '
                )
                FROM titulo_autor AS ta
                INNER JOIN autores AS a
                    ON ta.id_autor = a.id_autor
                WHERE ta.id_titulo = t.id_titulo
            ) AS autores
        FROM titulos AS t
        LEFT JOIN publicadores AS p
            ON t.id_pub = p.id_pub
        WHERE 1 = 1
    ";

    $parametros = [];

    //Filtra un libro específico desde la página de Inicio
    if ($idLibro !== '') {
        $sql .= "
            AND t.id_titulo = :idLibro
        ";

        $parametros['idLibro'] = $idLibro;
    }

    //Agrega la búsqueda general
    if ($busqueda !== '') {
        $categoriasBusqueda = [
            'negocios' => 'business',
            'computación' => 'popular_comp',
            'computacion' => 'popular_comp',
            'psicología' => 'psychology',
            'psicologia' => 'psychology',
            'cocina moderna' => 'mod_cook',
            'cocina tradicional' => 'trad_cook',
            'sin categoría' => 'UNDECIDED',
            'sin categoria' => 'UNDECIDED'
        ];

        $textoNormalizado = preg_replace('/\s+/', ' ',$busqueda);

        $busquedaNormalizada = mb_strtolower($textoNormalizado ?? $busqueda);

        $tipoBuscado = $categoriasBusqueda[$busquedaNormalizada] ?? str_replace(' ', '_', $busquedaNormalizada);

        $sql .= "
            AND (
                t.id_titulo LIKE :busquedaCodigo
                OR t.titulo LIKE :busquedaTitulo
                OR t.tipo LIKE :busquedaTipoCodigo
                OR REPLACE(t.tipo, '_',' ') LIKE :busquedaTipoLegible
                OR p.nombre_pub LIKE :busquedaEditorial
                OR EXISTS (
                    SELECT 1
                    FROM titulo_autor AS ta_busqueda
                    INNER JOIN autores AS a_busqueda
                        ON ta_busqueda.id_autor =
                            a_busqueda.id_autor
                    WHERE ta_busqueda.id_titulo =
                        t.id_titulo
                    AND CONCAT(
                        TRIM(a_busqueda.nombre),
                        ' ',
                        TRIM(a_busqueda.apellido)
                    ) LIKE :busquedaAutor
                )
            )
        ";

        $valorBusqueda = '%' . $busqueda . '%';

        $parametros['busquedaCodigo'] = $valorBusqueda;
        $parametros['busquedaTitulo'] = $valorBusqueda;
        $parametros['busquedaTipoCodigo'] = '%' . $tipoBuscado . '%';
        $parametros['busquedaTipoLegible'] = '%' . str_replace('_', ' ', $busquedaNormalizada) . '%';
        $parametros['busquedaEditorial'] = $valorBusqueda;
        $parametros['busquedaAutor'] = $valorBusqueda;
    }

    //Aplica el filtro de disponibilidad
    if ($disponibilidad !== 'todos') {
        $sql .= "
            AND t.contrato = :contrato
        ";

        $parametros['contrato'] =
            $disponibilidad;
    }

    //Filtra los libros relacionados con un autor
    if ($idAutor !== '') {
        $sql .= "
            AND EXISTS (
                SELECT 1
                FROM titulo_autor AS ta_filtro
                WHERE ta_filtro.id_titulo =
                    t.id_titulo
                AND ta_filtro.id_autor =
                    :idAutorFiltro
            )
        ";

        $parametros['idAutorFiltro'] =
            $idAutor;
    }

    //Organiza los libros por título
    $sql .= "
        ORDER BY t.titulo ASC
    ";

    //Prepara y ejecuta la consulta
    $consultaLibros = $conexion->prepare($sql);

    $consultaLibros->execute($parametros);

    //Guarda los libros encontrados
    $libros = $consultaLibros->fetchAll();

    //Devuelve los resultados a JavaScript
    echo json_encode(
        [
            'correcto' => true,
            'libros' => $libros,
            'totalResultados' => count($libros),
            'autorFiltro' => $autorFiltro
        ],
        JSON_UNESCAPED_UNICODE
    );
} catch (Throwable $error) {
    error_log(
        'Error al obtener los libros: '
            . $error->getMessage()
    );

    http_response_code(500);

    echo json_encode(
        [
            'correcto' => false,
            'mensaje' =>
                'No fue posible obtener los libros.'
        ],
        JSON_UNESCAPED_UNICODE
    );
}