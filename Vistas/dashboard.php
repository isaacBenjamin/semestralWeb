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

$filtroEditor = isset($_POST['filtroEditor']) ? $_POST['filtroEditor'] : '';

// Verificar si el usuario está autenticado y obtener su nombre de usuario
if (isset($_SESSION['usuario'])) {
    $username = $usuario['nombre'];

    // Verificar si existe la cookie del último juego prestado por el usuario
    if (isset($_COOKIE["ultimo_juego_prestado_$username"])) {
        $ultimoJuego = $_COOKIE["ultimo_juego_prestado_$username"];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/dashboard.css">
</head>
<body>

<header>
    <h1>¡Bienvenido, <?php echo $usuario["nombre"]; ?>!</h1>

    <?php if ($usuario["tipo_usuario"] === "admin") { ?>
        <a href="registroJuego.php">Registrar un VideoJuego</a>
    <?php } ?>
    
    <a href="prestaciones.php">Videojuegos Prestados</a>
    <a href="../Controladores/logout.php" class="logout-link">Cerrar Sesión</a>
    <?php if ($usuario["tipo_usuario"] === "admin") { ?>
        <a href="permisos.php" class="logout-link">Permisos</a>
    <?php } ?>
    <a href="cambiarPerfil.php" class="logout-link">Cambiar Perfil</a>
</header>

<?php

if (!empty($ultimoJuego)) {
    echo "<body><h3>Último juego prestado: $ultimoJuego</h3>";
}

echo "<div class='filtrado'><h3>Filtrar por Editor (Publisher)</h3>";
echo "<form method='post' action='{$_SERVER['PHP_SELF']}'>";
echo "<select name='filtroEditor'>";
echo "<option value=''>Mostrar Todos</option><br>";

$editores = obtenerPublishers();

foreach ($editores as $editor) {
    echo "<option value='$editor'>$editor</option>";
}

echo "</select>";
echo "<input type='submit' value='Filtrar'>";
echo "</form></div><br>";

echo "<div class='catalogo'>";
echo "<h2>CATÁLOGO DE JUEGOS</h2>";

$juegos = obtenerCatalogoJuegos($filtroEditor);

if (count($juegos) > 0) {
    echo "<div class='juegos-grid'>";

    foreach ($juegos as $juego) {
        if ($juego['disponibilidad'] == '1') {
            echo "<div class='juego'>";
            echo "<h4>{$juego['nombre']}</h4>";
            echo "<h4>{$juego['consola']} - {$juego['publisher']} - {$juego['lanzamiento']}</h4>";
            echo "<form method='post' action='prestaciones.php'>";
            echo "<input type='hidden' name='accion' value='prestar'>";
            echo "<input type='hidden' name='idJuego' value='{$juego['idJuego']}'>";
            echo "<input type='submit' value='Pedir Prestado'>";
            echo "</form></div>";
        }
    }

    echo "</div>";
} else {
    echo "<p>No hay juegos disponibles.</p>";
}

echo "</div>";
?>

</body>
</html>
