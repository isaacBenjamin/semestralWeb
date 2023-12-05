<?php

//conexión a la base de datos
include_once 'config.php';

// GET request method
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todos los datos de la tabla juegos
    $result = $conexion->query("SELECT * FROM juegos");

    if ($result) {
        // Obtener datos como un arreglo asociativo
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // retornar una respuesta en JSON con data
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        // Respuesta en JSON en caso de que falle la consulta
        echo json_encode(['success' => false, 'message' => 'Error al recuperar datos de la base de datos']);
    }
} else {
    // Devolver una respuesta JSON para métodos de solicitud no admitidos
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no admitido']);
}

?>
