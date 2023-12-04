<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/registroUsuario.css">
</head>
<body>

    <h2>Registro de Usuario</h2>

    <?php
    include_once 'usuario.php';
    include_once 'config.php';
    // Manejo de la solicitud de registro   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once 'usuario.php'; // Asegúrate de incluir el archivo que contiene las funciones relacionadas con los usuarios

        $nombre = $_POST["nombre"];
        $contrasena = $_POST["contrasena"];
        $tipo_usuario = "cliente"; // Puedes ajustar esto según tus necesidades

        // Validaciones adicionales, si es necesario

        // Intentar registrar el nuevo usuario
        $registroExitoso = registrarUsuario($nombre, $contrasena, $tipo_usuario);

        if ($registroExitoso) {
            echo "<p style='color: green;'>Registro exitoso. Ahora puedes iniciar sesión.</p>";
        } else {
            echo "<p style='color: red;'>Error al registrar el usuario. Inténtalo de nuevo.</p>";
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

</body>
</html>
