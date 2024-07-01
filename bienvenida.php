<?php
if (isset($_GET['nombre']) && isset($_GET['apellido'])) {
    $nombre = htmlspecialchars($_GET['nombre']);
    $apellido = htmlspecialchars($_GET['apellido']);
} else {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
</head>
<body>
    <h1>Registro Exitoso</h1>
    <p>Bienvenido, <?php echo $nombre . ' ' . $apellido; ?>.</p>
</body>
</html>