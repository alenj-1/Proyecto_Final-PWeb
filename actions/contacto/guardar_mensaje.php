<?php

declare(strict_types=1);

header('Content-Type: application/json');

//Comprueba que la solicitud haya sido enviada mediante POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode(
        [
            'correcto' => false,
            'mensaje' => 'Método de solicitud no permitido.'
        ],
        JSON_UNESCAPED_UNICODE
    );

    exit;
}

try {
    require_once __DIR__ . '/../../config/conexion.php';

    //Obtiene y limpia los datos enviados desde el formulario
    $nombre = trim((string) ($_POST['nombre'] ?? ''));
    $correo = trim((string) ($_POST['correo'] ?? ''));
    $asunto = trim((string) ($_POST['asunto'] ?? ''));
    $comentario = trim((string) ($_POST['comentario'] ?? ''));

    $errores = [];

    //Valida el nombre
    if ($nombre === '') {
        $errores[] = 'El nombre es obligatorio.';
    } elseif (strlen($nombre) > 100) {
        $errores[] = 'El nombre no puede superar los 100 caracteres.';
    }

    //Valida el correo electrónico
    if ($correo === '') {
        $errores[] = 'El correo es obligatorio.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El correo electrónico no es válido.';
    } elseif (strlen($correo) > 150) {
        $errores[] = 'El correo no puede superar los 150 caracteres.';
    }

    //Valida el asunto
    if ($asunto === '') {
        $errores[] = 'El asunto es obligatorio.';
    } elseif (strlen($asunto) > 150) {
        $errores[] = 'El asunto no puede superar los 150 caracteres.';
    }

    //Valida el comentario
    if ($comentario === '') {
        $errores[] = 'El comentario es obligatorio.';
    } elseif (strlen($comentario) < 10) {
        $errores[] = 'El comentario debe tener al menos 10 caracteres.';
    } elseif (strlen($comentario) > 2000) {
        $errores[] = 'El comentario no puede superar los 2000 caracteres.';
    }

    //Detiene el proceso cuando existe algún error
    if (count($errores) > 0) {
        http_response_code(422);

        echo json_encode(
            [
                'correcto' => false,
                'mensaje' => 'Revisa los datos ingresados.',
                'errores' => $errores
            ],
            JSON_UNESCAPED_UNICODE
        );

        exit;
    }

    //Prepara la consulta para guardar el mensaje
    $consulta = $conexion->prepare(
        "INSERT INTO contacto (fecha, correo, nombre, asunto, comentario) 
        VALUES (NOW(), :correo, :nombre, :asunto, :comentario)"
    );

    //Ejecuta la consulta con los datos recibidos
    $consulta->execute(
        [
            'correo' => $correo,
            'nombre' => $nombre,
            'asunto' => $asunto,
            'comentario' => $comentario
        ]
    );

    //Devuelve una respuesta cuando el mensaje se guarda correctamente
    echo json_encode(
        [
            'correcto' => true,
            'mensaje' => 'Tu mensaje fue registrado correctamente.'
        ],
        JSON_UNESCAPED_UNICODE
    );
} catch (Throwable $error) {
    error_log($error->getMessage());

    http_response_code(500);

    echo json_encode(
        [
            'correcto' => false,
            'mensaje' => 'No fue posible guardar el mensaje.'
        ],
        JSON_UNESCAPED_UNICODE
    );
}
