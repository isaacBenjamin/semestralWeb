<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Datos de Usuario</title>
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/funcionalidades.css">
</head>
<body>

    <h1>Cambiar Datos de Usuario</h1>

    <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include_once '../Controladores/usuarios_controller.php';

$usuario = $_SESSION["usuario"];

// Verificar si el usuario está autenticado
if (!$usuario) {
    header("Location: index.php");
    exit();
}

// Verificar si se envió un formulario para cambiar datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevoNombre = $_POST["nuevoNombre"];
    $nuevaContrasena = $_POST["nuevaContrasena"];

    // Cambiar los datos del usuario
    $cambioExitoso = cambiarDatosUsuario($usuario['idUsuario'], $nuevoNombre, $nuevaContrasena);

    if ($cambioExitoso) {
        echo "<p style='color: green;'>Datos cambiados exitosamente. Vuelva a Iniciar Sesión.</p>";
        header("Refresh: 2; URL=index.php"); // Redirige después de 3 segundos
        exit();
        
    } else {
        echo "<p style='color: red;'>Error al cambiar datos. Asegúrese de que la contraseña sea válida y vuelva a intentarlo.</p>";
    }
}

?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nuevoNombre">Nuevo Nombre:</label>
        <input type="text" name="nuevoNombre" required><br>

        <label for="nuevaContrasena">Nueva Contraseña:</label>
        <input type="password" name="nuevaContrasena"><br>

        <input type="submit" value="Cambiar Datos">
    </form>

    <a href="dashboard.php">Volver al Dashboard</a>

</body>
</html>
