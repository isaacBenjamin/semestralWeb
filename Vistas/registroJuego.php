<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include_once '../Controladores/usuarios_controller.php';
include_once '../Controladores/juegos_controller.php';

$usuario = $_SESSION["usuario"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $consola = $_POST["consola"];
    $lanzamiento = $_POST["lanzamiento"];
    $publisher = $_POST["publisher"];

    registrarJuego($nombre, $consola, $lanzamiento, $publisher);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Juego</title>
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/funcionalidades.css">
</head>
<body>
    <h1>Registrar Juego</h1>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="consola">Consola:</label>
        <input type="text" name="consola" required><br>

        <label for="lanzamiento">Lanzamiento (año):</label>
        <input type="number" name="lanzamiento" required min="1970" max="<?php echo date("Y"); ?>"><br><br>
        <label for="publisher">Publisher:</label>
        <input type="text" name="publisher" required><br>

        <input type="submit" value="Registrar Juego">
    </form>

    <a href="dashboard.php">Volver al Dashboard</a>

</body>
</html>
