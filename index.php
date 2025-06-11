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
      <button class="btn-menu" onclick="cargarContenido('listar.php')">Administrar Habitaciones</button>
      <button class="btn-menu" onclick="cargarContenido('listar_usuarios.php')">Administrar Usuarios</button>
      <button class="btn-menu" onclick="cargarContenido('listar_reservas.php')">Administrar Reservas</button>
    <?php } else { ?>
      <button class="btn-menu" onclick="cargarContenido('listar.php')">Ver Habitaciones</button>
      <button class="btn-menu" onclick="cargarContenido('mis_reservas.php')">Mis Reservas</button>
      <button class="btn-menu" id="reservaBton" onclick="openReservar()">Reservar Habitación</button>
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
            <form action="" method="post" id="form-Reserva">
                <input type="hidden" name="usuario" id="usuario">
                <label for="tipoHab">Tipo de Habitación:</label>
                <select name="tipoHab" id="tipoHab" onchange="obtenerHabitaciones()" required></select><br>
                
                <label for="habitacion">Habitación:</label>
                <select name="habitacion" id="habitacion" required></select><br>
                
                <label for="ingreso">Fecha de Llegada:</label>
                <input type="date" name="inicio" id="ingreso" required><br>
                
                <label for="salida">Fecha de Salida:</label>
                <input type="date" name="fin" id="salida" required><br>
                
                <label for="metodo_pago">Método de Pago:</label>
                <select name="metodo_pago" id="metodo_pago" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                    <option value="transferencia">Transferencia Bancaria</option>
                </select><br>
                
                <input type="submit" value="Registrar Reserva" onclick="guardarReserva()">
            </form>
        </div>
    </div>


  <script src="script.js"></script>
</body>
</html>
