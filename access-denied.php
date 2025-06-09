<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Denegado</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="access-denied">
        <h1>Acceso Denegado</h1>
        <p>No tienes permisos para acceder a esta página.</p>
        <?php if (isset($_SESSION['rol'])): ?>
            <a href="<?php echo $_SESSION['rol'] === 'admin' ? 'listar.php' : 'index.html'; ?>" class="button">Volver al inicio</a>
        <?php else: ?>
            <a href="login.php" class="button">Iniciar Sesión</a>
        <?php endif; ?>
    </div>
</body>
</html> 