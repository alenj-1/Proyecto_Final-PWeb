<?php

declare(strict_types=1);

$servidor = '127.0.0.1';
$puerto = '3306';
$baseDatos = 'dblibreria';
$usuario = 'root';
$contrasena = '';

try {
    $conexion = new PDO(
        "mysql:host={$servidor};port={$puerto};dbname={$baseDatos};charset=utf8mb4",
        $usuario,
        $contrasena,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $error) {
    error_log(
        'Error de conexión con la base de datos: '
            . $error->getMessage()
    );

    throw new RuntimeException(
        'No fue posible conectar con la base de datos.'
    );
}
