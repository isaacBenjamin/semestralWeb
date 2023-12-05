<?php

include_once 'config.php';

function login($nombre, $contrasena)
{
    global $conexion;

    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $contrasena = mysqli_real_escape_string($conexion, $contrasena);

    $query = "SELECT idUsuario, nombre, tipo_usuario FROM usuarios WHERE nombre='$nombre' AND contrasena='$contrasena'";
    $resultado = $conexion->query($query);

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        return $usuario;
    } else {
        return false;
    }
}

function esAdmin($usuario)
{
    return $usuario["tipo_usuario"] == "admin";
}

function registrarUsuario($nombre, $contrasena, $tipo_usuario)
{
    global $conexion;

    // Asegúrate de sanear y validar los datos antes de ejecutar la consulta

    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $contrasena = mysqli_real_escape_string($conexion, $contrasena);

    // Consulta para insertar el nuevo usuario
    $query = "INSERT INTO usuarios (nombre, contrasena, tipo_usuario) VALUES ('$nombre', '$contrasena', '$tipo_usuario')";

    $resultado = $conexion->query($query);

    return $resultado;
}

function cambiarTipoUsuario($idUsuario, $tipoUsuario)
{
    global $conexion;

    // Sanear y validar los datos antes de ejecutar la consulta

    $tipoUsuario = mysqli_real_escape_string($conexion, $tipoUsuario);

    // Consulta para actualizar el tipo de usuario
    $query = "UPDATE usuarios SET tipo_usuario = '$tipoUsuario' WHERE idUsuario = $idUsuario";

    $resultado = $conexion->query($query);

    return $resultado;
}

function obtenerUsuarios()
{
    global $conexion;

    // Consulta para obtener la información de los usuarios
    $query = "SELECT idUsuario, nombre, tipo_usuario FROM usuarios";

    $resultado = $conexion->query($query);

    $usuarios = array();

    while ($fila = $resultado->fetch_assoc()) {
        $usuarios[] = $fila;
    }

    return $usuarios;
}

function cambiarDatosUsuario($idUsuario, $nuevoNombre, $nuevaContrasena)
{
    global $conexion;

    // Asegúrate de sanear y validar los datos antes de ejecutar la consulta

    $nuevoNombre = mysqli_real_escape_string($conexion, $nuevoNombre);
    $nuevaContrasena = mysqli_real_escape_string($conexion, $nuevaContrasena);

    // Verificar si el usuario actual es el mismo que está intentando cambiar sus datos
    $usuarioActual = $_SESSION["usuario"];

    if ($usuarioActual['idUsuario'] == $idUsuario && $usuarioActual['idUsuario'] != 1) {
        // El usuario actual es el mismo que está intentando cambiar sus datos y no es el usuario con id=1

        // Si se proporcionó una nueva contraseña, realizar el cambio
        if (!empty($nuevaContrasena)) {

            $query = "UPDATE usuarios SET nombre = '$nuevoNombre', contrasena = '$nuevaContrasena' WHERE idUsuario = $idUsuario";
        } else {
            // Si no se proporcionó una nueva contraseña, cambiar solo el nombre
            $query = "UPDATE usuarios SET nombre = '$nuevoNombre' WHERE id = $idUsuario";
        }

        $resultado = $conexion->query($query);

        return $resultado;
    } else {
        // El usuario actual no tiene permisos para cambiar los datos de otro usuario
        return false;
    }
}


?>
