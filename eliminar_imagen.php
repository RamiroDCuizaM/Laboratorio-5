<?php
include 'conexion.php';

$response = ['success' => false, 'message' => ''];

try {
    $id = $_POST['id'];
    
    // Obtener información de la imagen antes de eliminarla
    $sql = "SELECT fotografia FROM fotografiashabitaciones WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $imagen = $result->fetch_assoc();
        $archivo = "imagesHotel/" . $imagen['fotografia'];
        
        // Eliminar la imagen de la base de datos
        $conn->query("DELETE FROM fotografiashabitaciones WHERE id = $id");
        
        // Eliminar el archivo físico si existe
        if (file_exists($archivo)) {
            unlink($archivo);
        }
        
        $response['success'] = true;
        $response['message'] = 'Imagen eliminada correctamente';
    } else {
        $response['message'] = 'Imagen no encontrada';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 