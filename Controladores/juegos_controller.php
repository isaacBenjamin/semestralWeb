<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'config.php';

function registrarJuego($nombre, $consola, $lanzamiento, $publisher)
{
    global $conexion;

    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $consola = mysqli_real_escape_string($conexion, $consola);

    // Obtener el año actual
    $anioActual = date('Y');

    // Verificar si $lanzamiento es un valor de año numérico válido y está en un rango aceptable
    if (is_numeric($lanzamiento) && strlen($lanzamiento) === 4 && $lanzamiento >= 1970 && $lanzamiento <= $anioActual) {
        $lanzamiento = mysqli_real_escape_string($conexion, $lanzamiento);

        $query = "INSERT INTO juegos (nombre, consola, lanzamiento, disponibilidad, publisher) VALUES ('$nombre', '$consola', '$lanzamiento', '1','$publisher')";
        
        $resultado = $conexion->query($query);

        if ($resultado) {
            // Redirige al dashboard si el registro fue exitoso
            header("Location: dashboard.php");
            exit();
        } else {
            // Manejar el error de alguna manera (puedes agregar más lógica aquí)
            echo "Error al registrar el juego: " . $conexion->error;
        }
    } else {
        echo "El año de lanzamiento no es válido. Debe ser un valor numérico de 4 dígitos, mayor a 1970 y menor o igual al año actual.";
    }
}


//METODO GET con un API simple
function obtenerCatalogoJuegos($filtroEditor = '')
{
    global $conexion;

    $filtro = '';
    if ($filtroEditor != '') {
        $filtro = "WHERE publisher = '$filtroEditor'";
    }

    $query = "SELECT * FROM juegos $filtro";
    $resultado = $conexion->query($query);

    $juegos = array();

    while ($fila = $resultado->fetch_assoc()) {
        $juegos[] = $fila;
    }

    return $juegos;
}


function tomarPrestado($idJuego, $idUsuario)
{
    global $conexion;

    // Verificar disponibilidad antes de tomar prestado
    $queryDisponibilidad = "SELECT disponibilidad FROM juegos WHERE idJuego = $idJuego";
    $resultadoDisponibilidad = $conexion->query($queryDisponibilidad);

    if ($resultadoDisponibilidad->num_rows == 1) {
        $fila = $resultadoDisponibilidad->fetch_assoc();
        if ($fila['disponibilidad'] == '1') {
            // Cambiar disponibilidad del juego
            $queryPrestamo = "UPDATE juegos SET disponibilidad = '0' WHERE idJuego = $idJuego";
            $conexion->query($queryPrestamo);

            // Registrar la transacción
            $queryRegistro = "INSERT INTO transacciones (juego_id, usuario_id, fecha_prestamo) VALUES ($idJuego, $idUsuario, NOW())";
            $conexion->query($queryRegistro);

            return true;
        }
    }

    return false;
}

function obtenerHistorialTransacciones($idUsuario)
{
    global $conexion;

    $query = "SELECT juegos.idJuego, juegos.nombre, juegos.consola, transacciones.fecha_prestamo, transacciones.fecha_devolucion
            FROM transacciones
            JOIN juegos ON transacciones.juego_id = juegos.idJuego
            WHERE transacciones.usuario_id = $idUsuario
            ORDER BY CASE 
                    WHEN transacciones.fecha_devolucion IS NULL THEN 0 
                    ELSE 1 
                END,
                transacciones.transacciones_id DESC
            LIMIT 10"; // Limitar a las últimas 10 transacciones

    $resultado = $conexion->query($query);

    $historialTransacciones = array();

    while ($fila = $resultado->fetch_assoc()) {
        $historialTransacciones[] = $fila;
    }

    return $historialTransacciones;
}



function obtenerJuegosPrestados($idUsuario)
{
    global $conexion;

    $query = "SELECT juegos.idJuego, juegos.nombre, juegos.consola, juegos.lanzamiento, juegos.publisher, MAX(transacciones.fecha_prestamo) as fecha_prestamo
              FROM transacciones
              JOIN juegos ON transacciones.juego_id = juegos.idJuego
              WHERE transacciones.usuario_id = $idUsuario AND juegos.disponibilidad = '0'
              GROUP BY juegos.idJuego";
              
    $resultado = $conexion->query($query);

    $juegosPrestados = array();

    while ($fila = $resultado->fetch_assoc()) {
        $juegosPrestados[] = $fila;
    }

    return $juegosPrestados;
}

function establecerCookieUltimoJuego($username, $ultimoJuego) 
{
    // Nombre de la cookie con el nombre de usuario
    $cookie_name = "ultimo_juego_prestado_$username";

    // Establecer la cookie del último juego prestado al usuario
    setcookie($cookie_name, $ultimoJuego, time() + (86400 * 30), "/"); // Validez por 30 días
}


function devolverJuego($idJuego, $idUsuario)
{
    global $conexion;

    if (!empty($idJuego)) {
        // Verificar si el juego está actualmente prestado por el usuario
        $queryVerificarPrestamo = "SELECT * FROM transacciones WHERE juego_id = $idJuego AND usuario_id = $idUsuario AND fecha_devolucion IS NULL";
        $resultadoVerificarPrestamo = $conexion->query($queryVerificarPrestamo);

        if ($resultadoVerificarPrestamo->num_rows > 0) {
            // El juego está prestado por el usuario, proceder con la devolución
            $fechaDevolucion = date('Y-m-d H:i:s');

            // Actualizar la transacción existente con la fecha de devolución
            $queryActualizarTransaccion = "UPDATE transacciones SET fecha_devolucion = '$fechaDevolucion' WHERE juego_id = $idJuego AND usuario_id = $idUsuario AND fecha_devolucion IS NULL";
            $resultadoActualizarTransaccion = $conexion->query($queryActualizarTransaccion);

            if ($resultadoActualizarTransaccion) {
                // Cambiar disponibilidad del juego a disponible
                $queryDevolucion = "UPDATE juegos SET disponibilidad = '1' WHERE idJuego = $idJuego";
                $resultadoDevolucion = $conexion->query($queryDevolucion);
                //Si...me causo problemas y hubo hart debugging.
                if ($resultadoDevolucion) {
                    echo "Juego devuelto correctamente";
                } else {
                    echo "Error al devolver el juego: " . $conexion->error;
                }
            } else {
                echo "Error al actualizar la transacción: " . $conexion->error;
            }
        } else {
            echo "El Juego no está actualmente prestado por el usuario.";
        }
    } else {
        echo "ID de juego vacía";
    }
}

function obtenerNombreJuegoPorId($idJuego) 
{
    global $conexion;

    $idJuego = mysqli_real_escape_string($conexion, $idJuego);

    $query = "SELECT nombre FROM juegos WHERE idJuego = $idJuego";
    $resultado = $conexion->query($query);

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        return $fila['nombre'];
    } else {
        return "Juego no encontrado";
    }
}

function obtenerPublishers()
{
    global $conexion;

    $query = "SELECT DISTINCT publisher FROM juegos";
    $resultado = $conexion->query($query);

    $publishers = array();

    while ($fila = $resultado->fetch_assoc()) {
        $publishers[] = $fila['publisher'];
    }

    return $publishers;
}

?>
