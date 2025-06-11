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
      Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>
      <button class="cerrar-sesion"><a href="logout.php">Cerrar sesión</a></button>
    </div>
  </header>

  <!-- Menú -->
  <nav class="menu">
    <?php if($_SESSION['rol'] == 'admin'): ?>
      <button class="btn-menu" onclick="cargarContenido('formulario.php')">Nueva Habitación</button>
      <button class="btn-menu" onclick="cargarContenido('listar.php')">Gestionar Habitaciones</button>
      <button class="btn-menu" onclick="cargarContenido('listar_usuarios.php')">Administrar Usuarios</button>
      <button class="btn-menu" onclick="cargarContenido('listar_reservas.php')">Gestionar Reservas</button>
    <?php else: ?>
      <button class="btn-menu" onclick="cargarContenido('listar.php')">Ver Habitaciones</button>
      <button class="btn-menu" onclick="cargarContenido('mis_reservas.php')">Mis Reservas</button>
      <button class="btn-menu" id="reservaBton" onclick="openReservar()">Nueva Reserva</button>
    <?php endif; ?>
  </nav>

  <!-- Contenido principal -->
  <main class="contenido" id="contenido">
    <div class="welcome-message">
      <h1>Bienvenido al Hotel Dulces Alegrías</h1>
      <p>Su destino para una estadía confortable y memorable</p>
    </div>
  </main>

    <!-- MODAL DE RESERVA -->
    <div class="modal-R" id="modalReserva">
        <div class="modal-content-R">
            <span class="close-R" id="closeBton" onclick="closeModal('modalReserva')">&times;</span>
            <h2>Registrar Reserva</h2>
            <form action="" method="post" id="form-Reserva">
                <input type="hidden" name="usuario" id="usuario">
                
                <div class="form-group">
                    <label for="tipoHab">Tipo de Habitación</label>
                    <select name="tipoHab" id="tipoHab" onchange="obtenerHabitaciones()" required></select>
                </div>

                <div class="form-group">
                    <label for="habitacion">Habitación</label>
                    <select name="habitacion" id="habitacion" required></select>
                </div>

                <div class="form-group">
                    <label for="ingreso">Fecha de Llegada</label>
                    <input type="date" name="inicio" id="ingreso" required>
                </div>

                <div class="form-group">
                    <label for="salida">Fecha de Salida</label>
                    <input type="date" name="fin" id="salida" required>
                </div>

                <div class="form-group">
                    <label for="metodo_pago">Método de Pago</label>
                    <select name="metodo_pago" id="metodo_pago" required></select>
                </div>

                <div class="form-group">
                    <label for="monto_total">Monto Total</label>
                    <input type="text" id="monto_total" readonly>
                </div>

                <button type="submit" class="button" onclick="guardarReserva(event)">Confirmar Reserva</button>
            </form>
        </div>
    </div>

  <script src="script.js"></script>
</body>
</html>
