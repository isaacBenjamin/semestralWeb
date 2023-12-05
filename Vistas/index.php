<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();

    include_once '../Controladores/usuarios_controller.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $contrasena = $_POST["contrasena"];

        $usuario = login($nombre, $contrasena);

        if ($usuario) {
            $_SESSION["usuario"] = $usuario;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Nombre de usuario o contraseña incorrectos.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/formularios_usuario.css">
</head>
<body>

<div class="container">

    <h1>Login</h1>

    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre">Nombre de usuario:</label>
        <input type="text" name="nombre" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br>

        <input type="submit" value="Iniciar sesión">
    </form><br>
    <a href="registroUsuario.php" class="">Registrarse</a>

</div>

</body>
</html>

