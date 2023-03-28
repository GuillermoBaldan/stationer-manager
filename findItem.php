<?php
// Conexión a la base de datos
require 'db_config.php';

// Obtener datos del formulario
$search_term = $_POST['search_term'];

// Consultar la tabla 'Articulo' para buscar artículos con la palabra clave
$sql = "SELECT * FROM Articulo WHERE nombre_articulo LIKE ?";
$stmt = $conn->prepare($sql);

// Verificar si la preparación de la sentencia fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la sentencia SQL: " . $conn->error);
}

$search_term = '%' . $search_term . '%';
$stmt->bind_param("s", $search_term);
$stmt->execute();
$result = $stmt->get_result();

// Mostrar resultados de la búsqueda
if ($result->num_rows > 0) {
    echo "<h2>Resultados de la búsqueda:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id_articulo"] . " - Nombre: " . $row["nombre_articulo"] . " - Descripción: " . $row["descripcion_articulo"] . "<br>";
    }
} else {
    echo "No se encontraron artículos con la palabra clave ingresada.";
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
