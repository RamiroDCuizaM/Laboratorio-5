<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario'];
    $habitacion_id = $_POST['habitacion'];
    $fecha_inicio = $_POST['inicio'];
    $fecha_fin = $_POST['fin'];
    $metodo_pago_id = $_POST['metodo_pago'];
    
    // Calcular monto total
    $sql_precio = "SELECT th.precio_noche 
                   FROM habitacion h 
                   JOIN tipohabitacion th ON h.tipohabitacion_id = th.id 
                   WHERE h.id = ?";
    $stmt = $con->prepare($sql_precio);
    $stmt->bind_param("i", $habitacion_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $dias = ceil((strtotime($fecha_fin) - strtotime($fecha_inicio)) / (60 * 60 * 24));
    $monto_total = $dias * $row['precio_noche'];
    
    // Verificar disponibilidad
    $sql_check = "SELECT COUNT(*) as count FROM reservas 
                  WHERE habitacion_id = ? 
                  AND estado != 'cancelada'
                  AND ((fecha_inicio BETWEEN ? AND ?) 
                  OR (fecha_fin BETWEEN ? AND ?))";
                  
    $stmt = $con->prepare($sql_check);
    $stmt->bind_param("issss", $habitacion_id, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'La habitación no está disponible para las fechas seleccionadas'
        ]);
        exit;
    }
    
    // Insertar reserva
    $sql = "INSERT INTO reservas (usuario_id, habitacion_id, fecha_inicio, fecha_fin, 
            estado, metodo_pago_id, monto_total) 
            VALUES (?, ?, ?, ?, 'pendiente', ?, ?)";
            
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iisssd", $usuario_id, $habitacion_id, $fecha_inicio, $fecha_fin, 
                      $metodo_pago_id, $monto_total);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Reserva registrada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al registrar la reserva'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
?>
