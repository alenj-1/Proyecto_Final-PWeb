<?php

declare(strict_types=1);

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../../config/conexion.php';

    //Consulta el libro con la mayor cantidad de ventas
    $consulta = $conexion->query(
        "SELECT
        t.id_titulo,
        t.titulo,
        t.tipo,
        t.total_ventas,
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
    ORDER BY
        COALESCE(t.total_ventas, 0) DESC,
        t.titulo ASC
    LIMIT 1"
    );

    //Guarda el libro encontrado
    $libro = $consulta->fetch();

    echo json_encode(
        [
            'correcto' => true,
            'libro' => $libro
        ],
        JSON_UNESCAPED_UNICODE
    );
} catch (Throwable $error) {
    error_log(
        'Error al obtener el libro más vendido: '
            . $error->getMessage()
    );

    http_response_code(500);

    echo json_encode(
        [
            'correcto' => false,
            'mensaje' => 'No fue posible obtener el libro más vendido.'
        ],
        JSON_UNESCAPED_UNICODE
    );
}
