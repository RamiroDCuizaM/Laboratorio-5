<?php
session_start();
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario'];
    $habitacion_id = $_POST['habitacion'];
    $fecha_inicio = $_POST['inicio'];
    $fecha_fin = $_POST['fin'];
    $metodo_pago = $_POST['metodo_pago'];
    
    // Verificar si la habitación está disponible para las fechas seleccionadas
    $stmt = $con->prepare("SELECT COUNT(*) as count FROM reservas 
                          WHERE habitacion_id = ? 
                          AND estado != 'cancelado'
                          AND ((fecha_inicio BETWEEN ? AND ?) 
                          OR (fecha_fin BETWEEN ? AND ?))");
    $stmt->bind_param("issss", $habitacion_id, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'La habitación no está disponible para las fechas seleccionadas']);
        exit;
    }
    
    // Insertar la reserva
    $stmt = $con->prepare("INSERT INTO reservas (usuario_id, habitacion_id, fecha_inicio, fecha_fin, metodo_pago) 
                          VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $usuario_id, $habitacion_id, $fecha_inicio, $fecha_fin, $metodo_pago);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Reserva registrada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar la reserva']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
