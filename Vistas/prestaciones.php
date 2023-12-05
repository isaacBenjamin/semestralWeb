<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include_once '../Controladores/usuarios_controller.php';
include_once '../Controladores/juegos_controller.php';

$usuario = $_SESSION["usuario"];

if (!$usuario) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST["accion"];
    $idJuego = $_POST["idJuego"];

    if ($accion == "prestar") {
        tomarPrestado($idJuego, $usuario["idUsuario"]);
        $nombreUltimoJuegoPrestado = obtenerNombreJuegoPorId($idJuego);
        establecerCookieUltimoJuego($usuario['nombre'], $nombreUltimoJuegoPrestado);
    } elseif ($accion == "devolver") {
        devolverJuego($idJuego, $usuario["idUsuario"]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamo y Devolucion</title>
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/prestaciones.css">
</head>
<body>

    <h1>Prestaciones de <?php echo $usuario["nombre"]; ?></h1>

    <a href="dashboard.php">Volver al Catálogo</a>
    <a href="../Controladores/logout.php" class="logout-link">Cerrar Sesión</a>

    <h3>Juegos Prestados</h3>
        <?php
        $juegosPrestados = obtenerJuegosPrestados($usuario["idUsuario"]);

        if (count($juegosPrestados) > 0) {
            echo "<div class='juegos-grid'>";

        foreach ($juegosPrestados as $juego) {
            echo "<div class='juego'>";
            echo "<h4>{$juego['nombre']}</h4>";
            echo "<h4>{$juego['consola']} - {$juego['publisher']} - {$juego['lanzamiento']}</h4>";
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='accion' value='devolver'>";
            echo "<input type='hidden' name='idJuego' value='{$juego['idJuego']}'>";
            echo "<input type='submit' value='Devolver'>";
            echo "</form></div>";
        }

        echo "</div>";
        } else {
        echo "<p class='mensaje'>No tienes juegos prestados actualmente.</p>";
        }
        ?>



    <h3>Historial de Transacciones</h3>
        <?php
        $usuario = $_SESSION["usuario"];
        $idUsuario = $usuario["idUsuario"];

        $historial = obtenerHistorialTransacciones($idUsuario);

        echo "<table border='1'>";
        echo "<th>Nombre</th><th>Consola</th><th>Fecha Préstamo</th><th>Fecha Devolución</th></tr>";

        foreach ($historial as $transaccion) {
            echo "<tr>";
            echo "<td>{$transaccion['nombre']}</td>";
            echo "<td>{$transaccion['consola']}</td>";
            echo "<td>{$transaccion['fecha_prestamo']}</td>";
            echo "<td>{$transaccion['fecha_devolucion']}</td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>

</body>
</html>
