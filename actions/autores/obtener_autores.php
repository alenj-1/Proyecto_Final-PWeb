<?php

declare(strict_types=1);

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../../config/conexion.php';

    //Obtiene los filtros mediante GET
    $busqueda = trim((string) ($_GET['busqueda'] ?? ''));

    $estado = strtoupper(trim((string) ($_GET['estado'] ?? 'todos')));

    //Comprueba que el estado tenga un formato válido
    if (
        $estado !== 'TODOS'
        && strlen($estado) > 2
    ) {
        $estado = 'TODOS';
    }

    //Consulta toda la información de los autores
    $sql = "
        SELECT
            id_autor,
            nombre,
            apellido,
            telefono,
            direccion,
            ciudad,
            estado,
            pais,
            cod_postal
        FROM autores
        WHERE 1 = 1
    ";

    $parametros = [];

    //Agrega la búsqueda por información del autor
    if ($busqueda !== '') {
        $sql .= "
            AND (
                id_autor LIKE :busquedaCodigo
                OR nombre LIKE :busquedaNombre
                OR apellido LIKE :busquedaApellido
                OR telefono LIKE :busquedaTelefono
                OR direccion LIKE :busquedaDireccion
                OR ciudad LIKE :busquedaCiudad
                OR cod_postal LIKE :busquedaPostal
                OR CONCAT(TRIM(nombre), ' ', TRIM(apellido)) LIKE :busquedaNombreCompleto
            )
        ";

        $valorBusqueda = '%' . $busqueda . '%';

        $parametros['busquedaCodigo'] = $valorBusqueda;
        $parametros['busquedaNombre'] = $valorBusqueda;
        $parametros['busquedaApellido'] = $valorBusqueda;
        $parametros['busquedaTelefono'] = $valorBusqueda;
        $parametros['busquedaDireccion'] = $valorBusqueda;
        $parametros['busquedaCiudad'] = $valorBusqueda;
        $parametros['busquedaPostal'] = $valorBusqueda;
        $parametros['busquedaNombreCompleto'] = $valorBusqueda;
    }

    //Agrega el filtro por estado
    if ($estado !== 'TODOS') {
        $sql .= "
            AND estado = :estado
        ";

        $parametros['estado'] = $estado;
    }

    //Organiza los autores por apellido y nombre
    $sql .= "
        ORDER BY apellido ASC, nombre ASC
    ";

    //Prepara y ejecuta la consulta
    $consultaAutores = $conexion->prepare($sql);

    $consultaAutores->execute($parametros);

    //Guarda los autores que se encontraron
    $autores = $consultaAutores->fetchAll();

    //Crea el nombre completo de cada autor
    foreach ($autores as &$autor) {
        $autor['nombre_completo'] = trim($autor['nombre'] . ' ' . $autor['apellido']);
    }

    unset($autor);

    // Devuelve los resultados a JavaScript
    echo json_encode(
        [
            'correcto' => true,
            'autores' => $autores,
            'totalResultados' => sizeof($autores)
        ],
        JSON_UNESCAPED_UNICODE
    );
} catch (Throwable $error) {
    error_log(
        'Error al obtener los autores: '
            . $error->getMessage()
    );

    http_response_code(500);

    echo json_encode(
        [
            'correcto' => false,
            'mensaje' =>
                'No fue posible obtener los autores.'
        ],
        JSON_UNESCAPED_UNICODE
    );
}