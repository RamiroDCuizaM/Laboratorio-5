<?php
include 'conexion.php';

$response = ['success' => false, 'message' => ''];

try {
    $id = $_POST['id'];
    $numero = $_POST['numero'];
    $piso = $_POST['piso'];
    $tipo = $_POST['tipohabitacion_id'];

    if ($id) {
        $conn->query("UPDATE habitacion SET numero='$numero', piso='$piso', tipohabitacion_id='$tipo' WHERE id=$id");
        $response['message'] = 'Habitación actualizada correctamente';
    } else {
        $conn->query("INSERT INTO habitacion (numero, piso, tipohabitacion_id) VALUES ('$numero', '$piso', '$tipo')");
        $id = $conn->insert_id;
        $response['message'] = 'Habitación creada correctamente';
    }

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $directorio = "imagesHotel/";
        $nombreOriginal = basename($_FILES['imagen']['name']);
        $temporal = $_FILES['imagen']['tmp_name'];

        if (preg_match('/^hab_\d{3}_[a-z]+\.jpg$/i', $nombreOriginal)) {
            $destino = $directorio . $nombreOriginal;

            if (move_uploaded_file($temporal, $destino)) {
                $orden = 1;
                $queryOrden = $conn->query("SELECT MAX(orden) AS max FROM fotografiashabitaciones WHERE habitacion_id = $id");
                if ($fila = $queryOrden->fetch_assoc()) {
                    $orden = $fila['max'] + 1;
                }

                $conn->query("INSERT INTO fotografiashabitaciones (habitacion_id, fotografia, orden) VALUES ($id, '$nombreOriginal', $orden)");
                $response['message'] .= ' e imagen guardada';
            }
        } else {
            $response['message'] = '❌ El nombre de la imagen debe tener el formato hab_###_texto.jpg';
        }
    }

    $response['success'] = true;
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>

