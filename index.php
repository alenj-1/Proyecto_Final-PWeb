<?php

declare(strict_types=1);

$titulo = 'Proyecto Final de Librería';
$versionPhp = PHP_VERSION;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($titulo) ?></h1>
    <p>El entorno PHP está funcionando correctamente.</p>
    <p>Versión de PHP: <?= htmlspecialchars($versionPhp) ?></p>
</body>

</html>