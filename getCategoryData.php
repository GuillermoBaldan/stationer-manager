<?php
header("Content-Type: application/json");

// Conexión a la base de datos
require 'db_config.php';

// Obtener el ID de la categoría
$id_categoria = $_GET['id_categoria'];

// Consultar la tabla 'Categoria' para obtener los datos de la categoría
$sql = "SELECT * FROM Categoria WHERE id_categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();

// Devolver los datos de la categoría en formato JSON
if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(array('error' => 'No se encontró la categoría.'));
}

$stmt->close();
$conn->close();
?>
