<?php
// Conexión a la base de datos
require 'db_config.php';

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
?>
