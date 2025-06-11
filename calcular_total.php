<?php
include 'conexion.php';

header('Content-Type: application/json');

if (!isset($_GET['tipo_hab']) || !isset($_GET['fecha_inicio']) || !isset($_GET['fecha_fin'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros requeridos']);
    exit;
}

$tipo_hab = $_GET['tipo_hab'];
$fecha_inicio = new DateTime($_GET['fecha_inicio']);
$fecha_fin = new DateTime($_GET['fecha_fin']);

// Verificar que las fechas sean válidas
if ($fecha_inicio > $fecha_fin) {
    echo json_encode(['success' => false, 'message' => 'La fecha de inicio debe ser anterior a la fecha de fin']);
    exit;
}

// Obtener el precio por noche del tipo de habitación
$query = "SELECT precio FROM tipohabitacion WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $tipo_hab);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $precio_por_noche = $row['precio'];
    
    // Calcular número de noches
    $interval = $fecha_inicio->diff($fecha_fin);
    $noches = $interval->days;
    
    // Calcular total
    $total = $precio_por_noche * $noches;
    
    echo json_encode([
        'success' => true,
        'total' => number_format($total, 2),
        'noches' => $noches,
        'precio_por_noche' => $precio_por_noche
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se encontró el tipo de habitación']);
}
?> 