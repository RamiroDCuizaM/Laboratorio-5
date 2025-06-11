<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $habitacion_id = $_GET['id'];
    
    $sql = "SELECT th.precio_noche 
            FROM habitacion h 
            JOIN tipohabitacion th ON h.tipohabitacion_id = th.id 
            WHERE h.id = ?";
            
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $habitacion_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'success' => true,
            'precio' => $row['precio_noche']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Habitación no encontrada'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID de habitación no proporcionado'
    ]);
}
?> 