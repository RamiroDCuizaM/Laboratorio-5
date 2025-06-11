<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header('Location: access-denied.php');
    exit;
}

// Obtener todas las reservas
$sql = "SELECT r.*, h.numero as habitacion_numero, th.nombre as tipo_habitacion, 
        u.nombre as nombre_usuario, u.correo as correo_usuario
        FROM reservas r 
        JOIN habitacion h ON r.habitacion_id = h.id 
        JOIN tipohabitacion th ON h.tipohabitacion_id = th.id 
        JOIN usuarios u ON r.usuario_id = u.id 
        ORDER BY r.fecha_creacion DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Reservas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Administrar Reservas</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Habitación</th>
                        <th>Tipo</th>
                        <th>Fecha Llegada</th>
                        <th>Fecha Salida</th>
                        <th>Estado</th>
                        <th>Método de Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($row['correo_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($row['habitacion_numero']); ?></td>
                            <td><?php echo htmlspecialchars($row['tipo_habitacion']); ?></td>
                            <td><?php echo htmlspecialchars($row['fecha_inicio']); ?></td>
                            <td><?php echo htmlspecialchars($row['fecha_fin']); ?></td>
                            <td>
                                <select onchange="cambiarEstado(<?php echo $row['id']; ?>, this.value)">
                                    <option value="pendiente" <?php echo $row['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="confirmado" <?php echo $row['estado'] == 'confirmado' ? 'selected' : ''; ?>>Confirmado</option>
                                    <option value="cancelado" <?php echo $row['estado'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                </select>
                            </td>
                            <td><?php echo htmlspecialchars($row['metodo_pago']); ?></td>
                            <td>
                                <button onclick="eliminarReserva(<?php echo $row['id']; ?>)" class="btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay reservas registradas.</p>
        <?php endif; ?>
    </div>

    <script>
    function cambiarEstado(id, estado) {
        if (confirm('¿Está seguro de cambiar el estado de esta reserva?')) {
            fetch('cambiar_estado_reserva.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&estado=${estado}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Estado actualizado correctamente');
                } else {
                    alert('Error al actualizar el estado');
                }
            });
        }
    }

    function eliminarReserva(id) {
        if (confirm('¿Está seguro de eliminar esta reserva?')) {
            fetch('eliminar_reserva.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al eliminar la reserva');
                }
            });
        }
    }
    </script>
</body>
</html> 