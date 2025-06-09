<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>Gestión de Habitaciones</h1>
</header>

<main>
    <div class="card">
        <button onclick="openModal('modalNuevaHabitacion')" class="button">Añadir una nueva habitacion</button>
        <table>
            <tr>
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
                            <a href='#' onclick='editarHabitacion({$row['id']})'>Editar</a>
                            <a href='#' onclick='eliminarHabitacion({$row['id']})'>Eliminar</a>
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
            
            <label>Número:</label>
            <input type="text" name="numero" required>
            
            <label>Piso:</label>
            <input type="number" name="piso" required>
            
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
            
            <button type="submit">Guardar</button>
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
            
            <label>Número:</label>
            <input type="text" id="edit_numero" name="numero" required>
            
            <label>Piso:</label>
            <input type="number" id="edit_piso" name="piso" required>
            
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
            
            <button type="submit">Guardar Cambios</button>
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
            
            <label>Nueva Imagen:</label>
            <input type="file" name="imagen" accept=".jpg,.jpeg,.png" onchange="previewImage(this)">
            
            <div class="acciones">
                <button type="submit">Guardar Cambios</button>
                <button type="button" onclick="eliminarImagen(document.getElementById('edit_imagen_id').value)">Eliminar Imagen</button>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>

