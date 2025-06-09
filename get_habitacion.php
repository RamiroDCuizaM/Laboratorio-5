<?php
include 'conexion.php';

$id = $_GET['id'];
$sql = "SELECT * FROM habitacion WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $habitacion = $result->fetch_assoc();
    echo json_encode($habitacion);
} else {
    echo json_encode(['error' => 'Habitación no encontrada']);
}
?> 