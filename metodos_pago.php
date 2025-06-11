<?php
include 'conexion.php';

$query = "SELECT id, nombre FROM metodos_pago ORDER BY nombre";
$result = $con->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
    }
} else {
    echo "<option value=''>Error al cargar métodos de pago</option>";
}
?> 