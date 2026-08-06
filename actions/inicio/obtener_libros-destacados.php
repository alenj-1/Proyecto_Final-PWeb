<?php

declare(strict_types=1);

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../../config/conexion.php';

    //Obtiene el libro que no debe repetirse
    $idExcluir = trim(
        (string) ($_GET['excluir'] ?? '')
    );

    //Consulta para obtener los libros destacados
    $sql = "
        SELECT
            t.id_titulo,
            t.titulo,
            t.tipo,
            t.contrato,
            p.nombre_pub
        FROM titulos AS t
        LEFT JOIN publicadores AS p
            ON t.id_pub = p.id_pub
        WHERE t.contrato = 1
    ";

    $parametros = [];

    //Evita repetir el libro mostrado en el encabezado
    if ($idExcluir !== '') {
        $sql .= " AND t.id_titulo <> :idExcluir";

        $parametros['idExcluir'] = $idExcluir;
    }

    //Selecciona tres libros de forma aleatoria
    $sql .= " ORDER BY RAND() LIMIT 3";

    $consulta = $conexion->prepare($sql);
    $consulta->execute($parametros);

    $libros = $consulta->fetchAll();

    echo json_encode(
        [
            'correcto' => true,
            'libros' => $libros
        ],
        JSON_UNESCAPED_UNICODE
    );
} catch (Throwable $error) {
    error_log(
        'Error al obtener los libros destacados: '
            . $error->getMessage()
    );

    http_response_code(500);

    echo json_encode(
        [
            'correcto' => false,
            'mensaje' => 'No fue posible obtener los libros destacados.'
        ],
        JSON_UNESCAPED_UNICODE
    );
}
