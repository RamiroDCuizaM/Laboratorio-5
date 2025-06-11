<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['correo'])) {
    header('Location: login.php');
    exit;
}

// Obtener el ID del usuario actual
$stmt = $con->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $_SESSION['correo']);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$usuario_id = $usuario['id'];

// Obtener las reservas del usuario
$sql = "SELECT r.*, h.numero as habitacion_numero, th.nombre as tipo_habitacion 
        FROM reservas r 
        JOIN habitacion h ON r.habitacion_id = h.id 
        JOIN tipohabitacion th ON h.tipohabitacion_id = th.id 
        WHERE r.usuario_id = ? 
        ORDER BY r.fecha_creacion DESC";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Mis Reservas</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Habitación</th>
                        <th>Tipo</th>
                        <th>Fecha Llegada</th>
                        <th>Fecha Salida</th>
                        <th>Estado</th>
                        <th>Método de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['habitacion_numero']); ?></td>
                            <td><?php echo htmlspecialchars($row['tipo_habitacion']); ?></td>
                            <td><?php echo htmlspecialchars($row['fecha_inicio']); ?></td>
                            <td><?php echo htmlspecialchars($row['fecha_fin']); ?></td>
                            <td><?php echo htmlspecialchars($row['estado']); ?></td>
                            <td><?php echo htmlspecialchars($row['metodo_pago']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes reservas registradas.</p>
        <?php endif; ?>
    </div>
</body>
</html> 