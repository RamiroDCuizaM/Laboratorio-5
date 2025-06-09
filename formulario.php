<?php
include 'conexion.php';

$id = '';
$numero = '';
$piso = '';
$tipohabitacion_id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM habitacion WHERE id = $id";
    $result = $conn->query($sql)->fetch_assoc();

    $numero = $result['numero'];
    $piso = $result['piso'];
    $tipohabitacion_id = $result['tipohabitacion_id'];
}

$tipos = $conn->query("SELECT * FROM tipohabitacion");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1><?php echo $id ? "Editar" : "Nueva"; ?> Habitación</h1>
</header>

<main>
    <div class="card">
        <form action="guardar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label>Número:</label><br>
            <input type="text" name="numero" value="<?php echo $numero; ?>" required><br><br>

            <label>Piso:</label><br>
            <input type="number" name="piso" value="<?php echo $piso; ?>" required><br><br>

            <label>Tipo de Habitación:</label><br>
            <select name="tipohabitacion_id" required>
                <?php while ($tipo = $tipos->fetch_assoc()): ?>
                    <option value="<?php echo $tipo['id']; ?>" <?php if ($tipo['id'] == $tipohabitacion_id) echo "selected"; ?>>
                        <?php echo $tipo['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label>Imagen (ej: hab_101_cama.jpg):</label><br>
            <input type="file" name="imagen" accept=".jpg,.jpeg,.png"><br><br>

            <button type="submit">Guardar</button>
            <a href="listar.php" class="button">Cancelar</a>
        </form>
    </div>
</main>

</body>
</html>
