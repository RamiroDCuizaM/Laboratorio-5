<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: access-denied.php');
    exit;
}

// Consulta para obtener los usuarios
$sql = "SELECT id, nombre, correo, rol, estado FROM usuarios";
$resultado = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Lista de Usuarios</h1>
        <a href="index.php">← Volver al inicio</a>
    </header>
    <main>
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                        <td><?php echo htmlspecialchars($fila['rol']); ?></td>
                        <td><?php echo htmlspecialchars($fila['estado']); ?></td>
                        <td>
                            <button onclick="editarUsuario(<?php echo $fila['id']; ?>)">Editar</button>
                            <button onclick="eliminarUsuario(<?php echo $fila['id']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
    <script src="script.js"></script>
</body>
</html>
