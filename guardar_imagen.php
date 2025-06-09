<?php
include 'conexion.php';

$response = ['success' => false, 'message' => ''];

try {
    $id = $_POST['id'];
    $habitacion_id = $_POST['habitacion_id'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $directorio = "imagesHotel/";
        $nombreOriginal = basename($_FILES['imagen']['name']);
        $temporal = $_FILES['imagen']['tmp_name'];

        if (preg_match('/^hab_\d{3}_[a-z]+\.jpg$/i', $nombreOriginal)) {
            $destino = $directorio . $nombreOriginal;

            if (move_uploaded_file($temporal, $destino)) {
                $conn->query("UPDATE fotografiashabitaciones SET fotografia = '$nombreOriginal' WHERE id = $id");
                $response['message'] = 'Imagen actualizada correctamente';
                $response['success'] = true;
            } else {
                $response['message'] = 'Error al mover la imagen';
            }
        } else {
            $response['message'] = '❌ El nombre de la imagen debe tener el formato hab_###_texto.jpg';
        }
    } else {
        $response['message'] = 'No se ha seleccionado ninguna imagen';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 