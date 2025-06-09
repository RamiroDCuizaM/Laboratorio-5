<?php
include 'auth.php';
checkUser();
$usuario = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Sistema Hotel</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<nav class="navbar">
    <a href="index.php" class="navbar-brand">Sistema de Gestión Hotel</a>
    <div class="navbar-user">
        <span>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></span>
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
</nav>

<header>
    <h1>Bienvenido al Sistema de Gestión del Hotel</h1>
</header>

<main>
    <div class="card">
        <h2>Mis Reservas</h2>
        <?php
        include 'conexion.php';
        $sql = "SELECT r.*, h.numero, th.nombre as tipo_habitacion 
                FROM reservas r 
                JOIN habitacion h ON r.habitacion_id = h.id 
                JOIN tipohabitacion th ON h.tipohabitacion_id = th.id 
                WHERE r.usuario_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuario['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Habitación</th>
                        <th>Tipo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                    </tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['numero']}</td>
                        <td>{$row['tipo_habitacion']}</td>
                        <td>{$row['fecha_inicio']}</td>
                        <td>{$row['fecha_fin']}</td>
                        <td>{$row['estado']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No tienes reservas activas.</p>";
        }
        ?>
    </div>
</main>
</body>
</html>