<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Hotel Dulces Alegrías</title>
  <link rel="stylesheet" href="estilos.css">
  <script src="script.js"></script>
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
    <button class="btn-menu">Reservar</button>
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

</body>
</html>
