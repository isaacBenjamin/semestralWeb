<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/permisos.css">
</head>
<body>

    <h1>Administración de Usuarios</h1>
    <a href="dashboard.php">Volver al Catálogo</a>
    <a href="../Controladores/logout.php" class="logout-link">Cerrar Sesión</a>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();

    include_once '../Controladores/usuarios_controller.php';
    include_once '../Controladores/juegos_controller.php';
    
    $usuario = $_SESSION["usuario"];
    
    // Manejo de cambios de tipo de usuario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["cambiar_rol"])) {
            $idUsuario = $_POST["idUsuario"];
            $tipoUsuario = $_POST["cambiar_rol"];
            // Enviar idUsuario y tipoUsuario a la funcion
            if ($tipoUsuario == 'cliente') {
                cambiarTipoUsuario($idUsuario, 'admin');
              
            }
            else{
                cambiarTipoUsuario($idUsuario, 'cliente');
            }
            // Muestra un mensaje y luego redirige
            echo "<p style='color: green;'>Cambio exitoso, vuelva a iniciar sesión.</p>";
            header("Refresh: 2; URL=index.php"); // Redirige después de 2 segundos
            exit();
        }
    }

    // Obtener información de los usuarios
    $usuarios = obtenerUsuarios();

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre de Usuario</th><th>Tipo de Usuario</th><th>Acciones</th></tr>";

    foreach ($usuarios as $usuario) {
        echo "<tr>";
        echo "<td>{$usuario['idUsuario']}</td>";
        echo "<td>{$usuario['nombre']}</td>";
        echo "<td>{$usuario['tipo_usuario']}</td>";
        
        if ($usuario["tipo_usuario"] == 'admin') {

            $accion= 'Cambiar a Cliente';
        }
        else {
            $accion= 'Cambiar a Admin';
        }

        // Botón para cambiar tipo_usuario (excluyendo al usuario con id=1)
        if ($usuario['idUsuario'] != 1) {
            echo "<td><form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='idUsuario' value='{$usuario['idUsuario']}'>";
            echo "<input type='hidden' name='cambiar_rol' value='{$usuario['tipo_usuario']}'>";
            echo "<input type='submit' value='$accion'>";
            echo "</form></td>";
        } else {
            echo "<td>Acción no permitida</td>";
        }
        
        echo "</tr>";
    }

    echo "</table>";
    ?>
    <br>

</body>
</html>
