<?php 
include 'conexion.php';
include 'auth.php';
checkAdmin(); // Solo administradores pueden acceder
$usuario = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<nav class="navbar">
    <a href="listar.php" class="navbar-brand">Sistema de Gestión Hotel</a>
    <div class="navbar-user">
        <span>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></span>
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
</nav>

<header>
    <h1>Gestión de Habitaciones</h1>
</header>

<main>
    <div class="card">
        <button onclick="openModal('modalNuevaHabitacion')" class="button">➕ Nueva habitación</button>
        <table>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Piso</th>
                <th>Tipo</th>
                <th>Imágenes</th>
                <th>Acciones</th>
            </tr>

            <?php
            $sql = "SELECT habitacion.id, numero, piso, tipohabitacion.nombre AS tipo 
                    FROM habitacion 
                    JOIN tipohabitacion ON habitacion.tipohabitacion_id = tipohabitacion.id";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $idHab = $row['id'];
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['numero']}</td>
                        <td>{$row['piso']}</td>
                        <td>{$row['tipo']}</td>
                        <td><div class='imagenes-container'>";

                $imagenes = $conn->query("SELECT id, fotografia FROM fotografiashabitaciones WHERE habitacion_id = $idHab ORDER BY orden ASC");
                if ($imagenes->num_rows > 0) {
                    while ($img = $imagenes->fetch_assoc()) {
                        echo "<img src='imagesHotel/{$img['fotografia']}' 
                              alt='foto' 
                              onclick='editarImagen({$idHab}, {$img['id']})'>";
                    }
                } else {
                    echo "No disponible";
                }

                echo    "</div></td>
                        <td class='acciones'>
                            <a href='#' onclick='editarHabitacion({$row['id']})'>✏️ Editar</a>
                            <a href='#' onclick='eliminarHabitacion({$row['id']})'>🗑️ Eliminar</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</main>

<!-- Modal Nueva Habitación -->
<div id="modalNuevaHabitacion" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modalNuevaHabitacion')">&times;</span>
        <h2>Nueva Habitación</h2>
        <form onsubmit="guardarHabitacion(event)">
            <input type="hidden" name="id" value="">
            
            <div class="form-group">
                <label>Número:</label>
                <input type="text" name="numero" required>
            </div>
            
            <div class="form-group">
                <label>Piso:</label>
                <input type="number" name="piso" required>
            </div>
            
            <div class="form-group">
                <label>Tipo de Habitación:</label>
                <select name="tipohabitacion_id" required>
                    <?php 
                    $tipos = $conn->query("SELECT * FROM tipohabitacion");
                    while ($tipo = $tipos->fetch_assoc()): 
                    ?>
                        <option value="<?php echo $tipo['id']; ?>">
                            <?php echo $tipo['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <button type="submit" class="button">Guardar</button>
        </form>
    </div>
</div>

<!-- Modal Editar Habitación -->
<div id="modalEditarHabitacion" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modalEditarHabitacion')">&times;</span>
        <h2>Editar Habitación</h2>
        <form onsubmit="guardarHabitacion(event)">
            <input type="hidden" id="edit_id" name="id">
            
            <div class="form-group">
                <label>Número:</label>
                <input type="text" id="edit_numero" name="numero" required>
            </div>
            
            <div class="form-group">
                <label>Piso:</label>
                <input type="number" id="edit_piso" name="piso" required>
            </div>
            
            <div class="form-group">
                <label>Tipo de Habitación:</label>
                <select id="edit_tipohabitacion_id" name="tipohabitacion_id" required>
                    <?php 
                    $tipos->data_seek(0);
                    while ($tipo = $tipos->fetch_assoc()): 
                    ?>
                        <option value="<?php echo $tipo['id']; ?>">
                            <?php echo $tipo['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <button type="submit" class="button">Guardar Cambios</button>
        </form>
    </div>
</div>

<!-- Modal Editar Imagen -->
<div id="modalEditarImagen" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modalEditarImagen')">&times;</span>
        <h2>Editar Imagen</h2>
        <form onsubmit="guardarImagen(event)">
            <input type="hidden" id="edit_imagen_id" name="id">
            <input type="hidden" id="edit_habitacion_id" name="habitacion_id">
            
            <img id="imagen_preview" class="imagen-preview" src="" alt="Preview">
            
            <div class="form-group">
                <label>Nueva Imagen:</label>
                <input type="file" name="imagen" accept=".jpg,.jpeg,.png" onchange="previewImage(this)">
            </div>
            
            <div class="acciones">
                <button type="submit" class="button">Guardar Cambios</button>
                <button type="button" class="button secondary" onclick="eliminarImagen(document.getElementById('edit_imagen_id').value)">Eliminar Imagen</button>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>

