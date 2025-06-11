<?php
include 'conexion.php';

$usuario_id = $_POST['usuario'];
$habitacion_id = $_POST['habitacion'];
$fechainicio = $_POST['inicio'];
$fechasalida = $_POST['fin'];
$estado = $_POST['estado'];

$sql = "INSERT INTO reservas (usuario_id, habitacion_id, fecha_inicio, fecha_fin, estado) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("iisss", $usuario_id, $habitacion_id, $fechainicio, $fechasalida, $estado);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$con->close();
?>
