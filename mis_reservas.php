<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['correo'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas - Hotel Dulces Alegrías</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Mis Reservas</h2>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Habitación</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT r.*, h.numero, th.nombre as tipo_habitacion, mp.nombre as metodo_pago 
                         FROM reservas r 
                         JOIN habitacion h ON r.habitacion_id = h.id 
                         JOIN tipohabitacion th ON h.tipohabitacion_id = th.id 
                         JOIN metodos_pago mp ON r.metodo_pago_id = mp.id 
                         WHERE r.usuario_id = ? 
                         ORDER BY r.fecha_creacion DESC";
                
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>Habitación {$row['numero']} ({$row['tipo_habitacion']})</td>";
                    echo "<td>" . date('d/m/Y', strtotime($row['fecha_inicio'])) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($row['fecha_fin'])) . "</td>";
                    echo "<td>" . ucfirst($row['estado']) . "</td>";
                    echo "<td>$" . number_format($row['total'], 2) . "</td>";
                    echo "<td>{$row['metodo_pago']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html> 