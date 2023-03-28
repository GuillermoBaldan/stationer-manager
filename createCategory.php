<?php
// Conexión a la base de datos
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre_categoria = $_POST['nombre_categoria'];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO Categoria (nombre_categoria) VALUES (?)";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la sentencia fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la sentencia SQL: " . $conn->error);
    }

    $stmt->bind_param("s", $nombre_categoria);

    if ($stmt->execute()) {
        echo "Categoría creada exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="style/createCategory.css"> 
</head>
<body>
    <?php include 'components/navbar.php'; ?>
    <h1>Crear Nueva Categoría</h1>
    <form method="POST" action="createCategory.php">
        <label for="nombre_categoria">Nombre de la Categoría:</label>
        <input type="text" id="nombre_categoria" name="nombre_categoria" required>
        <button type="submit">Crear Categoría</button>
    </form>
</body>
</html>
