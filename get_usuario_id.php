<?php
session_start();
include 'conexion.php';

$correo = $_SESSION['correo'];

$sql = "SELECT id FROM usuarios WHERE correo = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'id' => $row['id']]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$con->close();
?>
