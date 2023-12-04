<?php

include_once 'config.php';

function registrarLibro($titulo, $autor, $genero)
{
    global $conexion;

    $titulo = mysqli_real_escape_string($conexion, $titulo);
    $autor = mysqli_real_escape_string($conexion, $autor);
    $genero = mysqli_real_escape_string($conexion, $genero);

    $query = "INSERT INTO libros (titulo, autor, genero, disponibilidad) VALUES ('$titulo', '$autor', '$genero', '1')";
    
    $resultado = $conexion->query($query);

    if ($resultado) {
        // Redirige al dashboard si el registro fue exitoso
        header("Location: dashboard.php");
        exit();
    } else {
        // Manejar el error de alguna manera (puedes agregar más lógica aquí)
        echo "Error al registrar el libro: " . $conexion->error;
    }
}

//METODO GET con un API simple
function obtenerCatalogoLibros()
{
    global $conexion;

    $query = "SELECT * FROM libros";
    $resultado = $conexion->query($query);

    $libros = array();

    while ($fila = $resultado->fetch_assoc()) {
        $libros[] = $fila;
    }

    return $libros;
}

function tomarPrestado($idLibro, $idUsuario)
{
    global $conexion;

    // Verificar disponibilidad antes de tomar prestado
    $queryDisponibilidad = "SELECT disponibilidad FROM libros WHERE id = $idLibro";
    $resultadoDisponibilidad = $conexion->query($queryDisponibilidad);

    if ($resultadoDisponibilidad->num_rows == 1) {
        $fila = $resultadoDisponibilidad->fetch_assoc();
        if ($fila['disponibilidad'] == '1') {
            // Cambiar disponibilidad del libro
            $queryPrestamo = "UPDATE libros SET disponibilidad = '0' WHERE id = $idLibro";
            $conexion->query($queryPrestamo);

            // Registrar la transacción
            $queryRegistro = "INSERT INTO transacciones (libro_id, usuario_id, fecha_prestamo) VALUES ($idLibro, $idUsuario, NOW())";
            $conexion->query($queryRegistro);

            return true;
        }
    }

    return false;
}

function obtenerHistorialTransacciones()
{
    global $conexion;

    $query = "SELECT libros.id, libros.titulo, libros.autor, libros.genero, transacciones.fecha_prestamo, transacciones.fecha_devolucion
              FROM transacciones
              JOIN libros ON transacciones.libro_id = libros.id";
    $resultado = $conexion->query($query);

    $historialTransacciones = array();

    while ($fila = $resultado->fetch_assoc()) {
        $historialTransacciones[] = $fila;
    }

    return $historialTransacciones;
}


function obtenerLibrosPrestados($idUsuario)
{
    global $conexion;

    $query = "SELECT libros.id, libros.titulo, libros.autor, libros.genero, MAX(transacciones.fecha_prestamo) as fecha_prestamo
              FROM transacciones
              JOIN libros ON transacciones.libro_id = libros.id
              WHERE transacciones.usuario_id = $idUsuario AND libros.disponibilidad = '0'
              GROUP BY libros.id";
    $resultado = $conexion->query($query);

    $librosPrestados = array();

    while ($fila = $resultado->fetch_assoc()) {
        $librosPrestados[] = $fila;
    }

    return $librosPrestados;
}



function devolverLibro($idLibro, $idUsuario)
{
    global $conexion;

    if (!empty($idLibro)) {
        // Verificar si el libro está actualmente prestado por el usuario
        $queryVerificarPrestamo = "SELECT * FROM transacciones WHERE libro_id = $idLibro AND usuario_id = $idUsuario AND fecha_devolucion IS NULL";
        $resultadoVerificarPrestamo = $conexion->query($queryVerificarPrestamo);

        if ($resultadoVerificarPrestamo->num_rows > 0) {
            // El libro está prestado por el usuario, proceder con la devolución
            $fechaDevolucion = date('Y-m-d H:i:s');

            // Actualizar la transacción existente con la fecha de devolución
            $queryActualizarTransaccion = "UPDATE transacciones SET fecha_devolucion = '$fechaDevolucion' WHERE libro_id = $idLibro AND usuario_id = $idUsuario AND fecha_devolucion IS NULL";
            $resultadoActualizarTransaccion = $conexion->query($queryActualizarTransaccion);

            if ($resultadoActualizarTransaccion) {
                // Cambiar disponibilidad del libro a disponible
                $queryDevolucion = "UPDATE libros SET disponibilidad = '1' WHERE id = $idLibro";
                $resultadoDevolucion = $conexion->query($queryDevolucion);
                //Si...me causo problemas y hubo hart debugging.
                if ($resultadoDevolucion) {
                    echo "Libro devuelto correctamente";
                } else {
                    echo "Error al devolver el libro: " . $conexion->error;
                }
            } else {
                echo "Error al actualizar la transacción: " . $conexion->error;
            }
        } else {
            echo "El libro no está actualmente prestado por el usuario.";
        }
    } else {
        echo "ID de libro vacío";
    }
}



?>
