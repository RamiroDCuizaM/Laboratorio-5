<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    
    $stmt = $con->prepare("UPDATE reservas SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $estado, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?> 