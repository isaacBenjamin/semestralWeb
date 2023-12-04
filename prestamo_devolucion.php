<?php
session_start();

include 'usuario.php';
include 'libro.php';

$usuario = $_SESSION["usuario"];

if (!$usuario) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST["accion"];
    $idLibro = $_POST["idLibro"];

    if ($accion == "prestar") {
        tomarPrestado($idLibro, $usuario["id"]);
    } elseif ($accion == "devolver") {
        devolverLibro($idLibro, $usuario["id"]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamo y Devolucion</title>
    <link rel="stylesheet" href="css/prestamo_devolucion.css">
</head>
<body>

    <h2>Bienvenido, <?php echo $usuario["nombre"]; ?>!</h2>

    <h3>Préstamos y Devoluciones</h3>

    <a href="dashboard.php">Volver al Catálogo</a>
    <a href="logout.php" class="logout-link">Cerrar Sesión</a>


    <h4>Historial de Transacciones</h4>
    <ul>
        <?php
        $historial = obtenerHistorialTransacciones();

        echo "<table border='1'>";
        echo "<tr><th>ID Libro</th><th>Título</th><th>Autor</th><th>Género</th><th>Fecha Préstamo</th><th>Fecha Devolución</th></tr>";

        foreach ($historial as $transaccion) {
            echo "<tr>";
            echo "<td>{$transaccion['id']}</td>";
            echo "<td>{$transaccion['titulo']}</td>";
            echo "<td>{$transaccion['autor']}</td>";
            echo "<td>{$transaccion['genero']}</td>";
            echo "<td>{$transaccion['fecha_prestamo']}</td>";
            echo "<td>{$transaccion['fecha_devolucion']}</td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>
    </ul>

    <h4>Libros Prestados</h4>
    <ul>
        <?php
        $librosPrestados = obtenerLibrosPrestados($usuario["id"]);
        foreach ($librosPrestados as $libro) {
            //var_dump for testing purposes
            //var_dump($libro);
            echo "<li>{$libro['titulo']} - {$libro['autor']} - {$libro['genero']} - {$libro['fecha_prestamo']} ";
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='accion' value='devolver'>";
            echo "<input type='hidden' name='idLibro' value='{$libro['id']}'>";
            echo "<input type='submit' value='Devolver'>";
            echo "</form></li>";    
        }
        ?>
    </ul>

</body>
</html>
