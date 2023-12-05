<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/formularios_usuario.css">
</head>
<body>

<div class="container">

    <h1>Registro de Usuario</h1>

    <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        include_once '../Controladores/usuarios_controller.php';
        include_once '../Controladores/config.php';

        // Manejo de la solicitud de registro   
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST["nombre"];
            $contrasena = $_POST["contrasena"];
            $tipo_usuario = "cliente"; // Puedes ajustar esto según tus necesidades

            // Validaciones adicionales, si es necesario

            // Intentar registrar el nuevo usuario
            $registroExitoso = registrarUsuario($nombre, $contrasena, $tipo_usuario);

            if ($registroExitoso) {
                echo "<p style='color: green;'>Registro exitoso. Ahora puedes iniciar sesión.</p>";
                header("Refresh: 2; URL=index.php");
                exit(); // Exit after header to prevent further output
            } else {
                echo "<p style='color: red;'>Error al registrar el usuario. Inténtalo de nuevo.</p>";
                header("Refresh: 2; URL=registroUsuario.php");
                exit(); // Exit after header to prevent further output
            }
        }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre">Nombre de usuario:</label>
        <input type="text" name="nombre" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br>

        <input type="submit" value="Registrar">
    </form>
    <br>
    <a href="dashboard.php">Volver al Inicio de Sesión</a>

</div>

</body>
</html>
