<?php
$host = "localhost";$user = "root";$pass = "";$db = "bd_hotel";

$con = new mysqli($host, $user, $pass, $db);

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
?>
