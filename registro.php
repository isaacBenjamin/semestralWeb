<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Libro</title>
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>

<div class="container">

<?php

session_start();

include_once 'usuario.php';
include_once 'libro.php';

$usuario = $_SESSION["usuario"];

if ($usuario["tipo_usuario"] !== "admin") {
    // Muestra un mensaje y luego redirige a index.php
    echo "<p style='color: red;'>Por favor ingrese como administrador.</p>";
    header("Refresh: 2; URL=index.php"); // Redirige después de 3 segundos
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $genero = $_POST["genero"];

    registrarLibro($titulo, $autor, $genero);
}
?>

<h3>Registrar Libro</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" required><br>

    <label for="autor">Autor:</label>
    <input type="text" name="autor" required><br>

    <label for="genero">Género:</label>
    <input type="text" name="genero" required><br>

    <input type="submit" value="Registrar libro">
</form>

</div>

</body>
</html>

