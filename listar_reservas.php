<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header('Location: access-denied.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Reservas - Hotel Dulces Alegrías</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Administrar Reservas</h2>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Habitación</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Método de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT r.*, u.nombre as usuario_nombre, h.numero, th.nombre as tipo_habitacion, mp.nombre as metodo_pago 
                         FROM reservas r 
                         JOIN usuarios u ON r.usuario_id = u.id 
                         JOIN habitacion h ON r.habitacion_id = h.id 
                         JOIN tipohabitacion th ON h.tipohabitacion_id = th.id 
                         JOIN metodos_pago mp ON r.metodo_pago_id = mp.id 
                         ORDER BY r.fecha_creacion DESC";
                
                $result = $con->query($query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['usuario_nombre']}</td>";
                    echo "<td>Habitación {$row['numero']} ({$row['tipo_habitacion']})</td>";
                    echo "<td>" . date('d/m/Y', strtotime($row['fecha_inicio'])) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($row['fecha_fin'])) . "</td>";
                    echo "<td>
                            <select onchange='cambiarEstado({$row['id']}, this.value)'>
                                <option value='pendiente' " . ($row['estado'] == 'pendiente' ? 'selected' : '') . ">Pendiente</option>
                                <option value='confirmada' " . ($row['estado'] == 'confirmada' ? 'selected' : '') . ">Confirmada</option>
                                <option value='cancelada' " . ($row['estado'] == 'cancelada' ? 'selected' : '') . ">Cancelada</option>
                            </select>
                          </td>";
                    echo "<td>$" . number_format($row['total'], 2) . "</td>";
                    echo "<td>{$row['metodo_pago']}</td>";
                    echo "<td>
                            <button onclick='eliminarReserva({$row['id']})' class='btn-danger'>Eliminar</button>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
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
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar el estado');
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
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar la reserva');
            });
        }
    }
    </script>
</body>
</html> 