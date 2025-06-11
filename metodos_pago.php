<?php
require_once 'conexion.php';

$sql = "SELECT id, nombre FROM metodos_pago WHERE 1";
$resultado = $con->query($sql);

while($fila = $resultado->fetch_assoc()) {
    echo "<option value='" . $fila['id'] . "'>" . htmlspecialchars($fila['nombre']) . "</option>";
}
?> 