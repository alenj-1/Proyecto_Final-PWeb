<?php

declare(strict_types=1);

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../../config/conexion.php';

    //Consulta los estados diferentes registrados en los autores
    $consultaEstados = $conexion->query(
        "SELECT DISTINCT
            TRIM(estado) AS estado
        FROM autores
        WHERE TRIM(estado) <> ''
        ORDER BY estado ASC"
    );

    //Guarda únicamente los nombres de los estados que se encontraron
    $estados = $consultaEstados->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode(
        [
            'correcto' => true,
            'estados' => $estados
        ],
        JSON_UNESCAPED_UNICODE
    );
} catch (Throwable $error) {
    error_log(
        'Error al obtener los estados de los autores: '
            . $error->getMessage()
    );

    http_response_code(500);

    echo json_encode(
        [
            'correcto' => false,
            'mensaje' => 'No fue posible obtener los estados.'
        ],
        JSON_UNESCAPED_UNICODE
    );
}
