<?php
include 'conexion.php';

$response = ['success' => false, 'message' => ''];

try {
$id = $_GET['id'];

// Primero eliminar las fotos asociadas
$conn->query("DELETE FROM fotografiashabitaciones WHERE habitacion_id = $id");

// Luego eliminar la habitación
$conn->query("DELETE FROM habitacion WHERE id = $id");

    $response['success'] = true;
    $response['message'] = 'Habitación eliminada correctamente';
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
