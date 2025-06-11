<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    $stmt = $con->prepare("DELETE FROM reservas WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar la reserva']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?> 