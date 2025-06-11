<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Hotel Dulces Alegrías</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>

  <!-- Encabezado -->
  <header>
    <div class="logo">DULCES ALEGRÍAS</div>
    <div class="usuario">
      Bienvenido, <?php echo $_SESSION['nombre'];?>
      <button class="cerrar-sesion"><a href="logout.php">Cerrar sesión</a></button>
    </div>
  </header>

  <!-- Menú -->
  <nav class="menu">
    <?php if($_SESSION['rol']=='admin'){ ?>
    <button class="btn-menu">Nueva Habitacion</button>
    <?php } ?>
    <button class="btn-menu" onclick="cargarContenido('listar.php')">Ver Habitaciones</button>
    <button class="btn-menu">Mis Reservas</button>
    <button class="btn-menu" id="reservaBton" onclick="openReservar()">Reservar</button>
    <?php if($_SESSION['rol']=='admin'){ ?>
    <button class="btn-menu">Administrar Usuarios</button>
    <?php } ?>
    <?php if($_SESSION['rol']=='admin'){ ?>
    <button class="btn-menu">Control de Usuarios</button>
    <?php } ?>
  </nav>

  <!-- Contenido principal -->
  <main class="contenido" id="contenido">
    <p>Bienvenido al Hotel Dulces Alegrías</p>
  </main>

    <!-- MODAL DE RESERVA -->
    <div class="modal-R" id="modalReserva">
        <div class="modal-content-R">
            <span class="close-R" id="closeBton" onclick="closeModal('modalReserva')">&times;</span>
            <h2>Registrar Reserva</h2>
            <label for="">Tipo habitacion</label>
            <select name="" id="tipoHab" onchange="obtenerHabitaciones()"></select>
            <form action="" method="post" id="form-Reserva">
            <input type="hidden" name="usuario" id="usuario">
            <label for="">Habitacion</label>
            <select name="habitacion" id="habitacion"></select><br>
            <label for="">Fecha Inicio</label>
            <input type="date" name="inicio" id="ingreso"><br>
            <label for="">Fecha Salida</label>
            <input type="date" name="fin" id="salida"><br>
            <label for="">Estado</label>
            <select name="estado" id="estado">
            <option value="pendiente">Pendiente</option>
            <option value="confirmado">Confirmado</option>
            <option value="cancelado">Cancelado</option>
            </select><br>
            <input type="submit" value="Registrar" onclick="guardarReserva()">
            </form>
        </div>
    </div>


  <script src="script.js"></script>
</body>
</html>
