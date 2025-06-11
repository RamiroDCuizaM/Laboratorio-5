<?php
session_start();
include 'conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['correo'])) {
    echo json_encode(['success' => false, 'message' => 'No hay sesión activa']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario'];
    $habitacion_id = $_POST['habitacion'];
    $fecha_inicio = $_POST['inicio'];
    $fecha_fin = $_POST['fin'];
    $metodo_pago_id = $_POST['metodo_pago'];

    // Verificar disponibilidad de la habitación
    $query = "SELECT COUNT(*) as count FROM reservas 
              WHERE habitacion_id = ? 
              AND estado != 'cancelada'
              AND ((fecha_inicio BETWEEN ? AND ?) 
              OR (fecha_fin BETWEEN ? AND ?))";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("issss", $habitacion_id, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'La habitación no está disponible para las fechas seleccionadas']);
        exit;
    }

    // Obtener el precio total
    $query = "SELECT th.precio, DATEDIFF(?, ?) as noches 
              FROM habitacion h 
              JOIN tipohabitacion th ON h.tipohabitacion_id = th.id 
              WHERE h.id = ?";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssi", $fecha_fin, $fecha_inicio, $habitacion_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $total = $row['precio'] * $row['noches'];

    // Insertar la reserva
    $query = "INSERT INTO reservas (usuario_id, habitacion_id, fecha_inicio, fecha_fin, estado, metodo_pago_id, total) 
              VALUES (?, ?, ?, ?, 'pendiente', ?, ?)";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("iisssd", $usuario_id, $habitacion_id, $fecha_inicio, $fecha_fin, $metodo_pago_id, $total);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true, 
            'message' => 'Reserva registrada correctamente',
            'redirect' => $_SESSION['rol'] === 'admin' ? 'listar_reservas.php' : 'mis_reservas.php'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar la reserva']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
