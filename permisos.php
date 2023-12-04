<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="css/permisos.css">
</head>
<body>

    <h2>Administración de Usuarios</h2>

    <?php
    session_start();

    include_once 'usuario.php';
    include_once 'libro.php';
    
    $usuario = $_SESSION["usuario"];
    
    if ($usuario["tipo_usuario"] !== "admin") {
        // Muestra un mensaje y luego redirige
        echo "<p style='color: red;'>Por favor ingrese como administrador.</p>";
        header("Refresh: 2; URL=index.php"); // Redirige después de 3 segundos
        exit();
    }
    // Manejo de cambios de tipo de usuario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["cambiar_rol"])) {
            $idUsuario = $_POST["id"];
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
        echo "<td>{$usuario['id']}</td>";
        echo "<td>{$usuario['nombre']}</td>";
        echo "<td>{$usuario['tipo_usuario']}</td>";
        
        if ($usuario["tipo_usuario"] == 'admin') {

            $accion= 'Cambiar a Cliente';
        }
        else {
            $accion= 'Cambiar a Admin';
        }

        // Botón para cambiar tipo_usuario (excluyendo al usuario con id=1)
        if ($usuario['id'] != 1) {
            echo "<td><form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='id' value='{$usuario['id']}'>";
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
    <a href="dashboard.php">Volver al Dashboard</a>

</body>
</html>
