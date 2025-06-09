<?php
include 'conexion.php';

$id = $_GET['id'];
$sql = "SELECT * FROM fotografiashabitaciones WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $imagen = $result->fetch_assoc();
    echo json_encode($imagen);
} else {
    echo json_encode(['error' => 'Imagen no encontrada']);
}
?> 