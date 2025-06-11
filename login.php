<?php 
session_start();
include("conexion.php");

// Validar si se enviaron datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $stmt = $con->prepare('SELECT correo, nombre, rol, estado FROM usuarios WHERE correo = ? AND password = ?');
    $stmt->bind_param("ss", $correo, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (strtolower($usuario['estado']) === 'activo') {
            // Crear sesiones
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
<<<<<<< HEAD
            
            if ($usuario['rol'] === 'admin') {
                header('Location: listar.php');
            } else {
                header('Location: index.php');
            }
            exit;
=======

            // Redireccionar a index.php
            header("Location: index.php");
            exit();
        } else {
            $error = "El usuario se encuentra suspendido.";
>>>>>>> bdcf5b0c06bc5d07f3217571a18875a9a24e6ac3
        }
    } else {
        $error = "Datos de autenticación incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Hotel</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }
        .login-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .mensaje.error {
            background-color: #ffcdd2;
            color: #b71c1c;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #bbb;
            border-radius: 5px;
        }
        .button {
            width: 100%;
            background-color: #004080;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .button:hover {
            background-color: #002f5e;
        }
    </style>
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
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> bdcf5b0c06bc5d07f3217571a18875a9a24e6ac3
