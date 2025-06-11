<?php
session_start();

// Si ya está logueado, redirigir según el rol
if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['rol'] === 'admin') {
        header('Location: listar.php');
    } else {
        header('Location: index.html');
    }
    exit;
}

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'conexion.php';
    
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    
    $sql = "SELECT id, nombre, rol, estado FROM usuarios WHERE correo = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $correo, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        
        if ($usuario['estado'] === 'suspendido') {
            $error = "Tu cuenta está suspendida. Contacta al administrador.";
        } else {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            
            if ($usuario['rol'] === 'admin') {
                header('Location: listar.php');
            } else {
                header('Location: index.php');
            }
            exit;
        }
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Hotel</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="login-container">
        <div class="card login-card">
            <h1>Iniciar Sesión</h1>
            
            <?php if (isset($error)): ?>
                <div class="mensaje error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php" class="login-form">
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="button">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>